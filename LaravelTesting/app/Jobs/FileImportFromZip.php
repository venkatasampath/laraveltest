<?php


namespace App\Jobs;


use App\Notifications\ImportCompleted;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileImportFromZip extends CoraBaseJob
{
    public $tries = 1;
    protected $importFileType;
    protected $importFileDetails;
    protected $disk;

    public function __construct($user_id, $importFileDetailsId, $typeId)
    {
        parent::__construct($user_id);
        $this->logInfo(__METHOD__);

        $this->disk = env('FILESYSTEM_DRIVER');
        $this->importFileType = DB::table('import_file_types')->where('id', $typeId)->first();
        $this->importFileDetails = DB::table('import_file_details')->where('id', $importFileDetailsId)->first();

        $this->notification_params['type'] = 'import';
        $this->notification_params['typeId'] = $typeId;
        $this->notification_params['payload'] = $this->importFileType;
        $this->notification_params['fileName'] = $this->importFileDetails->filename;
    }

    public function getZipFilePath()
    {
        $zipFilePath = $this->importFileDetails->file_location;
        if ($this->disk === 'public') {
            $zipFilePath = storage_path('app/public/' . $zipFilePath);
        }

        return $zipFilePath;
    }

    public function getImportFilePath()
    {
        return 'Files/Imports/' .
            $this->theOrg->acronym . '/' .
            $this->theProject->name . '/' .
            $this->theUser->id . '/';
    }

    public function getUnzipPath()
    {
        return storage_path('app/public/' . $this->getImportFilePath() .  'archive/unzipped/');
    }

    public function handle()
    {
        $zipArchive = new \ZipArchive();
        $zipArchive->open($this->getZipFilePath());

        $this->logInfo(__METHOD__,'Zip file object: ' . $zipArchive->numFiles . ' : ' . $this->getZipFilePath() . ' : ' . $this->disk);

        // Unzip and store each file on the disk.
        for ($i = 0; $i < $zipArchive->numFiles; $i++) {
            $this->logInfo(__METHOD__,'Zip file for loop, unzipping files: file count: '.$i . " of " .$zipArchive->numFiles);

            $fileName = $zipArchive->getNameIndex($i);
            $zipArchive->extractTo($this->getUnzipPath(), array($zipArchive->getNameIndex($i)));
            $unzipFileStoragePath = $this->getImportFilePath() . $fileName;

            if (file_get_contents($this->getUnzipPath() . $fileName) === false) {
                $this->logInfo(__METHOD__,'Reading contents from' . $fileName . 'failed.' . $fileName . 'skipped and data will not be imported');
                continue;
            } else {
                Storage::disk($this->disk)
                    ->put(
                        $unzipFileStoragePath,
                        file_get_contents($this->getUnzipPath() . $fileName),
                        "public"
                    );

                // Store file location in DB
                $importFileDetailsId = DB::table('import_file_details')
                    ->insertGetId(['filename' => $fileName, 'type_id' => $this->importFileType->id,
                        'file_location' => $unzipFileStoragePath, 'created_by' => $this->theUser->name,
                        'updated_by' => $this->theUser->name, 'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(), 'user_id' => $this->theUser->id,
                        'project_id' => $this->theProject->id, 'org_id' => $this->theOrg->id
                    ]);

                // Start a job for importing data from each file in the zip
                SeedTable::dispatch($this->theUser->id,
                    $importFileDetailsId,
                    $this->importFileType->id)->onQueue('default');
            }
        }

        $this->logInfo(__METHOD__,'Unzip of files complete');
        // delete the archive directory
        Storage::disk('public')->deleteDirectory($this->getImportFilePath() . 'archive');
        // either send 1 notification for all files after import or send 1 notification of unzip complete process if needed
        // keep track of all failed files
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
        $this->theUser->notify((new ImportCompleted($this->theUser->id, $this->notification_params))->onQueue('notifications'));
    }
}