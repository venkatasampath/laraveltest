<?php

namespace App\Jobs;

use App\Exports\FileExports;
use App\Exports\FileExportsFromQuery;
use App\Notifications\ExportCompleted;
use App\SkeletalBone;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class FileExportJob extends CoraBaseJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const EXPORT_FOLDER = 'Files/Exports/';
    const CSV_FILE_EXTENSION = '.csv';
    const ZIP_FILE_EXTENSION = '.zip';
    const PUBLIC_DISK = 'public';
    const NAME_SEPARATOR = '-';
    const FILE_SEPARATOR = '_';

    /**
     * number of tries for the job to execute
     */
    public $tries = 1;

    /**
     * The type of export firing this job
     * @var object
     */
    protected $exportType;
    protected $user;

    /**
     * Advanced export when Admin user select columns and tables
     * for an export type
     * @var array
     */
    protected $tableColumnArray;

    /**
     * Relative path for storing files on current configured disk
     * Works with Illuminate\Support\Facades\Storage
     * @var String
     */
    protected $storagePath;

    /*
     * Path to temp directory for storing exported files before
     * they are zipped together
     */
    protected $tempStoragePath;

    /**
     * Current storage disk
     * @var String
     */
    protected $disk;

    public function __construct($user_id, $exportType, $tableColumnArray = [])
    {
        parent::__construct($user_id);
        $this->logInfo(__METHOD__);

        $this->notification_params['type'] = 'export';
        $this->notification_params['payload'] = $this->exportType = $exportType;
        $this->tableColumnArray = $tableColumnArray;
        $this->storagePath = self::EXPORT_FOLDER.$this->theOrg->acronym.'/'.$this->theProject->name .'/'.$this->theUser->id.'/';
        $this->tempStoragePath = $this->storagePath .'temp/';
        $this->disk = env('FILESYSTEM_DRIVER');
    }

    public function handle()
    {
        if ($this->disk === null) {
            $this->logInfo(__METHOD__,'No file driver configuration found, falling back to local');
            $this->disk = self::PUBLIC_DISK;
        } else {
            $this->logInfo(__METHOD__,'FILESYSTEM_DRIVER:'.$this->disk);
        }

        // Check if a folder exists for the current Org
        if (!Storage::disk($this->disk)->exists($this->storagePath)) {
            $this->logInfo(__METHOD__, "Creating storage path: ".$this->storagePath);
            Storage::makeDirectory($this->storagePath);
        }

        if (!Storage::disk($this->disk)->exists($this->tempStoragePath)) {
            $this->logInfo(__METHOD__, "Creating temporary storage path: ".$this->tempStoragePath);
            Storage::makeDirectory($this->tempStoragePath);
        }

        $tempExportTypeName = $this->formatStringWithSpaces($this->exportType->name, self::NAME_SEPARATOR);
        $fileArray = array();

        if (!empty($this->tableColumnArray)) {
            foreach ($this->tableColumnArray as $table => $columns) {
                if ($table != 'skeletal_elements' && $table != 'se_measurement' && $table != 'se_zone') {
                    $filePathTemp = $this->exportFileAndStore($table, $columns);
                    $strArray = explode("/", $filePathTemp);
                    $fileName = end($strArray);
                    $fileArray[$fileName] = $filePathTemp;
                }
            }
        } else if ($this->exportType->table_names) {
            // Export Data based on table names
            foreach($this->exportType->table_names as $table) {
                $columns = Schema::getColumnListing($table);
                if ($table != 'skeletal_elements' && $table != 'se_measurement' && $table != 'se_zone'){
                    $filePathTemp = $this->exportFileAndStore($table, $columns);
                    $strArray = explode("/", $filePathTemp);
                    $fileName = end($strArray);
                    $fileArray[$fileName] = $filePathTemp;
                }
            }
        } else {
            // Export data based on query string
            $queryString = $this->exportType->query;

            // Check if this is Osteometric Sorting and Export
            $this->logInfo(__METHOD__, "Export Type is : ".$this->exportType->name);
            if ($this->exportType->name == 'Osteometric Sorting') {
                $bones = $this->getSkeletalBones();
                if(!is_null($bones)) {
                    $queryString = rtrim($queryString,';');
                    foreach ($bones as $bone) {
                        // Update the query string for each bone and generate a file
                        $queryStringForBone = $queryString . " where sb.id = '" . $bone->id . "' and se.project_id = " . $this->theProject->id . " order by se.id;";
                        $currentExportObj = new FileExportsFromQuery($queryStringForBone, $this->exportType, $bone->name);
                        $fileName = $tempExportTypeName . self::FILE_SEPARATOR .
                            $this->formatStringWithSpaces($bone->name, self::NAME_SEPARATOR) . self::FILE_SEPARATOR .
                            $this->formatStringWithSpaces(Carbon::now()->toDateTimeString(), self::FILE_SEPARATOR) . self::CSV_FILE_EXTENSION;
                        $tempFilePath = $this->tempStoragePath . $fileName;

                        // Store these files in a temp folder on the public disk
                        $this->logInfo(__METHOD__, "Attempting to store file : ".$tempFilePath);
                        $currentExportObj->store($tempFilePath, self::PUBLIC_DISK);
                        $fileArray[$fileName] = $tempFilePath;
                        $this->logInfo(__METHOD__, "Successfully stored file : ".$tempFilePath);
                    }
                }
            } else {
                $this->logInfo(__METHOD__, "Export Type is not Osteometric Sorting");
                $exportObj = new FileExportsFromQuery($queryString, $this->exportType);
                $fileName = $tempExportTypeName . self::FILE_SEPARATOR .
                    $this->formatStringWithSpaces($this->exportType->group, self::NAME_SEPARATOR) . self::FILE_SEPARATOR .
                    $this->formatStringWithSpaces(Carbon::now()->toDateTimeString(), self::FILE_SEPARATOR) . self::CSV_FILE_EXTENSION;
                $tempFilePath = $this->tempStoragePath . $fileName;

                // Store these files in a temp folder on the public disk
                $this->logInfo(__METHOD__, "Attempting to store file : ".$tempFilePath);
                $exportObj->store($tempFilePath, $this->disk);
                $fileArray[$fileName] = $tempFilePath;
                $this->logInfo(__METHOD__, "Successfully stored file : ".$tempFilePath);
            }
        }

        // Create a zip file of all exported files
        $this->logInfo(__METHOD__, "Attempting to create zip file of all exported files");
        $exportZip = new \ZipArchive();
        $zipFileName = $this->getZipFileName() . self::ZIP_FILE_EXTENSION;

        // This is the location where the zip file will be stored on the disk
        // And can be accessed by Storage facade
        $zipFilePath = $this->storagePath . $zipFileName;
        $this->logInfo(__METHOD__, "Zip file storage location: ".$zipFilePath);

        // We need this temp path as ZipArchive class does not work with relative path
        $tempZipPath = storage_path('app/public/' . $this->storagePath);

        $exportZip->open($tempZipPath . $zipFileName, \ZipArchive::CREATE);
        foreach($fileArray as $fileName => $fileUrl) {
            $exportZip->addFromString($fileName, Storage::disk(self::PUBLIC_DISK)->get($fileUrl));
        }
        $exportZip->close();
        
        // If the configured disk is not public, get the file contents and move it to the
        // configured disk
        $this->logInfo(__METHOD__, "Configured disk is: ".$this->disk);
        if ($this->disk !== self::PUBLIC_DISK) {
            $this->logInfo(__METHOD__,'Moving file to configured disk: '.$this->disk);
            $fileContents = Storage::disk(self::PUBLIC_DISK)->get($zipFilePath);
            Storage::put($zipFilePath, $fileContents);

            // Once moved to the proper disk, remove the zip file from public disk
            $this->logInfo(__METHOD__,'Deleting zip file from public disk');
            Storage::disk(self::PUBLIC_DISK)->delete($zipFilePath);
        }

        // Save file details in DB
        $this->logInfo(__METHOD__,'Inserting location for exported zip file into database');
        DB::table('export_file_details')
                ->insert(['org_id' => $this->theOrg->id, 'project_id' => $this->theProject->id, 'user_id' => $this->theUser->id, 'filename' => $zipFileName,
                'file_location' => $zipFilePath, 'export_type' => $this->exportType->name, 'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name,
                        'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        // Remove the temp folder
        $this->logInfo(__METHOD__,'Deleting temp directory');
        Storage::disk(self::PUBLIC_DISK)->deleteDirectory($this->tempStoragePath);

        // Create a new mail notification job after the export job is completed and start it in the background
        $this->logInfo(__METHOD__,'Sending ExportCompleted Notification');
        $this->theUser->notify((new ExportCompleted($this->theUser->id, $this->notification_params))->onQueue('notifications'));
    }

    /**
     * Return name for zip file with project and org acronyms
     *
     * @return string
     */
    public function getZipFileName() {
        return strtolower($this->theOrg->acronym . self::FILE_SEPARATOR .
                $this->theProject->getAcronymNameAttribute() . self::FILE_SEPARATOR .
                $this->exportType->name . self::FILE_SEPARATOR) .
            $this->formatStringWithSpaces(Carbon::now()->toDateTimeString(), self::FILE_SEPARATOR);
    }

    /**
     * Return all the skeletal bones which have a measurement
     *
     * @return SkeletalBone
     */
    public function getSkeletalBones()
    {
        return SkeletalBone::where('measurements', true)->get();
    }

    /**
     * The job failed to process.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {
        Log::error(__METHOD__." ".$exception->getMessage());
        $this->logInfo(__METHOD__,'Dispatching notification for failed job');
        $this->notification_params['hasJobFailed'] = true;
        $this->theUser->notify((new ExportCompleted($this->theUser->id, $this->notification_params))->onQueue('notifications'));
    }

    /**
     * Export the table with selected columns, store the file on disk
     *
     * @param $table
     * @param $columns
     * @return string
     */
    public function exportFileAndStore($table, $columns)
    {
        $this->logInfo(__METHOD__,'tables: ' . $table . ' columns: ' . json_encode($columns));
        $exportObject = new FileExports($table, $columns);
        $tempExportTypeName = $this->formatStringWithSpaces($this->exportType->name, self::NAME_SEPARATOR);
        $fileName = $tempExportTypeName . self::FILE_SEPARATOR . $table . self::FILE_SEPARATOR .
            $this->formatStringWithSpaces(Carbon::now()->toDateTimeString(), self::FILE_SEPARATOR) . self::CSV_FILE_EXTENSION;
        $tempFilePath = $this->tempStoragePath . $fileName;
        $this->logInfo(__METHOD__,'tempFilePath: ' . $tempFilePath . ' disk: ' . $this->disk);
        $exportObject->store($tempFilePath, $this->disk);

        return $tempFilePath;
    }

    /**
     * Replace a spaces in a string with specified character
     *
     * @param $stringWithSpaces
     * @param $char
     * @return string
     */
    public function formatStringWithSpaces($stringWithSpaces, $char)
    {
        return str_replace(' ', $char, $stringWithSpaces);
    }
}