<?php

namespace App\Http\Controllers;

use App\SkeletalElement;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\FileStorageTrait;
use App\Exports\FileExports;
use App\SkeletalBone;
use App\Jobs\FileExportJob;
use App\Jobs;
use App\Project;
use Session;

class FileController extends Controller
{
    use FileStorageTrait;

    const TIMESTAMP_ATTRIBUTES = [
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
            'deleted_at'
        ];

    public function __construct()
    {
        parent::__construct();
        $exportTypes = DB::table('export_maps')->where('deleted_at', "=", null)->get();
//        $exportTypes = DB::table('export_maps')->get();
        foreach($exportTypes as $exportType) {
            $exportType->table_names = explode(', ', $exportType->table_names);
        }
        $this->viewData['exportTypes'] = $exportTypes;
    }
    
    /*	
     * FileExportAdvanced
     *	
     */	
    public function exportOptionsAdvanced() {
        $this->logInfo(__METHOD__);	
        if ($this->authorize( 'browse',  [SkeletalElement::class])) {	
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);	
            $this->viewData['heading'] = trans('labels.export_files_advanced');
            return view('files.exports.advanceoptionselectgroups', $this->viewData);	
        }	
    }	

    /*
     * FileExport
     * Lists all the available export types
     */
    public function listExportOptions() {
        $this->logInfo(__METHOD__);
        if ($this->authorize( 'browse',  [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['heading'] = trans('labels.export_files');
            return view('files.exports.selectgroups', $this->viewData);
        }
    }

    /*
     * FileExport
     * Lists all the tables for a particular export type
     * Only available for Admin users
     */
    public function exportType($exportTypeId)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize( 'browse',  [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                /*
                *  Get all the tables for the selected id
                */
                $tableArray = array();
                $exportType = DB::table('export_maps')->where('id', $exportTypeId)->first();
                $exportType->table_names = explode(', ', $exportType->table_names);

                /*
                *  Get all the columns for each table
                */
                foreach($exportType->table_names as $table) {
                    $columns = Schema::getColumnListing($table);
                    $filteredColumns = collect($columns)->diff(self::TIMESTAMP_ATTRIBUTES);
                    $tableArray[$table] = $filteredColumns->toArray();
                }
                $this->viewData['exportType'] = $exportType;
                $this->viewData['tableArray'] = $tableArray;
                return view('files.exports.selecttables', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /*
     * FileExport
     * Exports all the tables when a user selects tables and columns
     * from the advanced tab. Available for Admin users only
     */
    public function exportFile(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize( 'browse',  [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                /*
                 * Get the tables and associated columns
                 * Create an exportable and store in S3 with proper file path
                 * This function is only for individual tables to be selected and exported and available for admins
                 */
                $selectedTables = $request["tables"];
                $shouldIncludeTimestamps = $request["include-timestamps"];
                $exportTypeId = $request['id'];
                $exportType = DB::table('export_maps')->where('id', $exportTypeId)->first();

                $this->logInfo(__METHOD__,'Creating array of selected tables and associated columns');
                $tableColumnArray = array();
                foreach ($selectedTables as $selectedTable) {
                    $currentTableColumns = $request[$selectedTable];
                    if ($shouldIncludeTimestamps) {
                        $currentTableColumns = array_merge($currentTableColumns, self::TIMESTAMP_ATTRIBUTES);
                    }
                    array_set($tableColumnArray, $selectedTable, $currentTableColumns);
                }

                $this->logInfo(__METHOD__,'Dispatching the FileExport Job');
                $this->dispatch((new FileExportJob($this->theUser->id, $exportType, $tableColumnArray))->onQueue('default'));
                return view('files.exports.selectgroups', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /*
     * FileExport
     * Exports all the tables when a user clicks on "Export"
     * on a particular export types from the available export types
     */
    public function exportGroup(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize( 'browse',  [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                // If the user clicks on Export directly, export the tables with all columns
                $exportTypeId = $request['exportTypeId'];
                $exportType = DB::table('export_maps')->where('id', $exportTypeId)->first();

                /*
                 * Check if tables are specified for the export type
                 * And format them into an array
                 */
                if($exportType->table_names) {
                    $exportType->table_names = explode(', ', $exportType->table_names);
                }

                // Create a new file export job and start it in the background
                $this->logInfo(__METHOD__,'Dispatching the FileExport Job');
                $this->dispatch((new FileExportJob($this->theUser->id, $exportType))->onQueue('default'));
                return response(array('success' => true));
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /*
     * FileImport
     * This function lists all the available import types
     */
    public function listImportOptions()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize( 'browse',  [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                /*
                 * Get all available import options
                 */
                $importTypes = DB::table('import_file_types')->whereNull('updated_at')
                    ->get()->pluck('display_name', 'id');

                $this->viewData['heading'] = trans('labels.file_import');
                $this->viewData['importTypes'] = $importTypes;
                return view('files.imports.main', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /*
     * FileImport
     * Store uploaded file for importing to DB and start a import job
     */
    public function storeUploadedFile(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize( 'browse',  [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                // First check if we have a file
                if (!$request->hasFile('importAttachment')) {
                    Session::flash('error_message', 'Invalid file upload: No importAttachment');
                    return redirect()->back();
                }

                $uploaded_file = $request->file('importAttachment');
                $this->logInfo(__METHOD__, "uploaded file name: ".$uploaded_file->getClientOriginalName());
                $stats = ["filename"=>$uploaded_file->getClientOriginalName(), "size"=>$uploaded_file->getClientSize(),
                    "mime"=>$uploaded_file->getClientMimeType(), "ext"=>$uploaded_file->getClientOriginalExtension(),];

                /*
                 * Store file in S3 and get the location/URL
                 */
                $returnRequest = $this->storeFiles($request, $this->theUser);

                // Store filename and path, typeID in import_file_types table
                $this->logInfo(__METHOD__, "Storing filename and path, typeID in import_file_types table");
                $currentDate = Carbon::now();
                $importFileDetailsId = DB::table('import_file_details')->insertGetId(
                    ['filename' => $returnRequest['importAttachment'], 'type_id' => $returnRequest['importFileType'], 'file_location' => $returnRequest['fileLocation'],
                        'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name, 'created_at' => $currentDate, 'updated_at' => $currentDate,
                        'user_id' => $this->theUser->id, 'project_id' => $this->theProject->id, 'org_id' => $this->theOrg->id, 'stats'=>json_encode($stats)
                    ]);
                $typeId = intval($returnRequest['importFileType']);

                // Dispatch the Job
                if ($returnRequest['isZip'] === true) {
                    $this->logInfo(__METHOD__, "Dispatching Job/FileImportFromZip: " . $importFileDetailsId. " and typeId: ". $typeId);
                    $this->dispatch((new Jobs\FileImportFromZip($this->theUser->id, $importFileDetailsId, $typeId))->onQueue('default'));
                } else {
                    $this->logInfo(__METHOD__, "Dispatching Job/SeedTable: " . $importFileDetailsId. " and typeId: ". $typeId);
                    $this->dispatch((new Jobs\SeedTable($this->theUser->id, $importFileDetailsId, $typeId))->onQueue('default'));
                }

                Session::flash('flash_message', 'File Import started. You will receive a notification when import is completed');
                return redirect()->back();
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /*
     * FileImport
     * Download a sample template for a specific import type
     */
    public function downloadTemplate($importTypeId)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize( 'browse',  [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $importTypeId = intval($importTypeId);
                $importFileTypeDetails = DB::table('import_file_types')->where('id', $importTypeId)->first();
                $fileLocation = $importFileTypeDetails->template_location;
                $templateFilePath = resource_path($fileLocation);
                $name = $importFileTypeDetails->name . '_sample_template.csv';
                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Description' => 'File Download'
                ];

                $this->logInfo(__METHOD__, "Downloading template file: ". $name);
                return response()->download($templateFilePath, $name, $headers);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /*
     * FileImport
     * Download all templates as a zip for all available imports
     */
    public function downloadAllTemplates()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize( 'browse',  [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $allImportTemplates = DB::table('import_file_types')->get();

                $zip = new \ZipArchive();
                $zip->open('allTemplates' . '.zip', \ZipArchive::CREATE);
                foreach($allImportTemplates as $allImportTemplate) {
                    $fileName = $allImportTemplate->name . '.csv';
                    $zip->addFromString($fileName, file_get_contents(resource_path($allImportTemplate->template_location)));
                }
                $zip->close();

                $headers = [ 'Content-Type' => 'application/zip', ];
                $zipFileToDownload = 'allTemplates.zip';
                $this->logInfo(__METHOD__, "Downloading all templates zip file: allTemplates.zip");
                return response()->download($zipFileToDownload, 'allTemplates.zip', $headers);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /*
      * FileManager
      * View the exported files
      */
    public function viewExports()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize( 'browse',  [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                /*
                 * Get all the export types for the current user from export_file_details table
                 * Render a view with links to these export Types
                 */

                // Get all the files exported by a user from an org for each export type
                $userExports = DB::table('export_file_details')
                    ->where("org_id", "=", $this->theOrg->id)
                    ->where("project_id", "=", $this->theProject->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $this->viewData['heading'] = trans('labels.file_manager');
                $this->viewData['userExports'] = $userExports;
                return view('files.manager.exports', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    public function createFileName($exportType, $projectId)
    {
        $fileName = '';
        $project = Project::where('id', $projectId)->first();
        $fileName = strtolower($this->theOrg->acronym . '_' . $project->getAcronymNameAttribute() . '_' . $exportType . '_');
        return $fileName;
    }

    /*
     * FileManager
     * Download export zip file
     */
    public function downloadExportsAsZip($exportType, $fileId)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize( 'browse',  [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->logInfo(__METHOD__,"FileId: ".$fileId);
                $fileToDownload = DB::table('export_file_details')->where('id', $fileId)->first();
                $headers = [ "Content-disposition: attachment; filename=$fileToDownload->filename", 'Content-Type' => 'application/zip', ];

                // Update record with download stats such as who downloaded, when, etc
                DB::table('export_file_details')->where('id', $fileId)
                        ->update(['last_downloaded_at'=>date_create(), 'downloaded_by'=>$this->theUser->display_name]);

                $this->logInfo(__METHOD__,"File to Download: ".$fileToDownload->filename);
                return Storage::download($fileToDownload->file_location, $fileToDownload->filename, $headers);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }
}


