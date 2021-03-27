<?php

namespace App\Jobs;



use App\Notifications\ImportCompleted;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class SeedTable extends CoraBaseJob
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    protected $importFileType;
    protected $importFileDetails;
    public $table;
    public $fileLocation;
    public $fileName;
    protected $importTypeMap = [
        'se'                => 'SkeletalElements',
        'dna'               => 'Dnas',
        'pairs'             => 'SePairs',
        'zones'             => 'SeZones',
        'measurements'      => 'SeMeasurements',
        'articulations'     => 'SeArticulations',
        'missing persons'   => 'MissingPerson'

    ];
    const IMPORT_PREFIX = 'App\\Imports\\';

    public function __construct($user_id, $importFileDetailsId, $typeId)
    {
        parent::__construct($user_id);
        $this->logInfo(__METHOD__);

        /*
        * Get the current import file details
        */
        $this->importFileType = DB::table('import_file_types')->where('id', $typeId)->first();
        $this->importFileDetails = DB::table('import_file_details')->where('id', $importFileDetailsId)->first();

        $this->notification_params['type'] = 'import';
        $this->notification_params['typeId'] = $typeId;
        $this->notification_params['payload'] = $this->importFileType;
        $this->notification_params['fileName'] = $this->importFileDetails->filename;

        /*
         * Set the table name and filename
         */
        $this->table = $this->importFileType->table_names;
        $this->fileLocation = $this->importFileDetails->file_location;
        $this->logInfo(__METHOD__, "Importing into Table: ".$this->table. " from file location: ".$this->fileLocation);
        $this->logInfo(__METHOD__, "path extension: ".pathinfo($this->fileLocation, PATHINFO_EXTENSION));
    }

    /**
     * Executes the job based on the queue priority
     *
     * @return void
     */
    public function handle()
    {
        $disk = env('FILESYSTEM_DRIVER');
        $importType = $this->importFileType->name;

        $this->logInfo(__METHOD__,'Import Type: ' . $importType);
        if (array_key_exists($importType, $this->importTypeMap)) {
            $importName = $this->importTypeMap[$importType];
        }
        $importClass = self::IMPORT_PREFIX . $importName;

        $this->logInfo(__METHOD__,'Calling excel import: ' . $this->fileLocation);
        Excel::import(new $importClass($this->theUser), $this->fileLocation, $disk);
//        Excel::import(new $importClass($this->theUser), $this->fileLocation, $disk, \Maatwebsite\Excel\Excel::CSV);

        /* Send a notification to the user
         * Create a new mail notification job after the import is completed and start it in the background
         */
        $this->logInfo(__METHOD__,'Sending ImportCompleted Notification');
        $this->theUser->notify((new ImportCompleted($this->theUser->id, $this->notification_params))->onQueue('notifications'));
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