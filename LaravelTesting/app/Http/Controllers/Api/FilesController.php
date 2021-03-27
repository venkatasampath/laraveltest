<?php

/**
 * Cora Api FilesController
 *
 * @category
 * @package    CoRA-Api-Controller
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2020, Sachin Pawaskar, All rights reserved.
 * @license    Proprietary software, All rights reserved.
 * @version    GIT: $Id$
 * @since      File available since Release 3.0.0
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;
use App\Http\Traits\FileStorageTrait;
use App\SkeletalElement;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Exports\FileExports;
use App\SkeletalBone;
use App\Jobs\FileExportJob;
use App\Jobs;
use App\Project;
use Session;

/**
 * Class FilesController
 * @package App\Http\Controllers\Api
 */
class FilesController extends Controller
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
        foreach($exportTypes as $exportType) {
            $exportType->table_names = explode(', ', $exportType->table_names);
        }
        $this->viewData['exportTypes'] = $exportTypes;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function getExportTypes(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                // Get all available export maps
                $exportTypes = DB::table('export_maps')->where('deleted_at', "=", null)->get();
                foreach($exportTypes as $exportType) {
                    $exportType->table_names = explode(', ', $exportType->table_names);
                }
                return response()->json([ "data" => ["count" => $exportTypes->count(), "exportTypes" => $exportTypes] ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => ["error" => "Database Query Exception" ]], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function getImportTypes(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize( 'browse',  [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                // Get all available import options
                $importTypes = DB::table('import_file_types')->whereNull('updated_at')->get();
                return response()->json([ "data" => ["count" => $importTypes->count(), "importTypes" => $importTypes] ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => ["error" => "Database Query Exception" ]], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /*
     * FileExport
     * Lists all the tables for a particular export type
     * Only available for Admin users
     */
    public function getExportTypeDetails(Request $request, $exportTypeId)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize( 'browse',  [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                // Get all the tables for the selected id
                $tableArray = array();
                $exportType = DB::table('export_maps')->where('id', $exportTypeId)->first();
                $exportType->table_names = explode(', ', $exportType->table_names);

                // Get all the columns for each table
                foreach($exportType->table_names as $table) {
                    $columns = Schema::getColumnListing($table);
                    $filteredColumns = collect($columns)->diff(self::TIMESTAMP_ATTRIBUTES);
                    $tableArray[$table] = $filteredColumns->toArray();
                }

                $this->viewData['exportType'] = $exportType;
                $this->viewData['tableArray'] = $tableArray;
                return response()->json([ "data" => [ "exportType"=>$exportType, "tableArray"=>$tableArray ] ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => ["error" => "Database Query Exception" ]], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /*
     * FileExport
     * Exports all the tables when a user selects tables and columns
     * from the advanced tab. Available for Admin users only
     */
    public function exportFile(Request $request, $id)
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
                return response()->json([ "data" => [ "exportType"=>$exportType, "tableColumns"=>$tableColumnArray, "viewData"=>$this->viewData ] ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => ["error" => "Database Query Exception" ]], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
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
                $exportTypeId = $request['id'];
                $exportType = DB::table('export_maps')->where('id', $exportTypeId)->first();

                if($exportType->table_names) {
                    $exportType->table_names = explode(', ', $exportType->table_names);
                }
                // Create a new file export job and start it in the background
                $this->logInfo(__METHOD__,'Dispatching the FileExport Job');
                $this->dispatch((new FileExportJob($this->theUser->id, $exportType))->onQueue('default'));
                //return response(array('success' => true));
                return response()->json([ "data" => [ "exportType"=>$exportType, "viewData"=>$this->viewData ] ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => ["error" => "Database Query Exception" ]], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }
    /*
    * FileImport
    * Download a sample template for a specific import type
    */
    public function downloadTemplate(Request $request)
    {
        $this->logInfo(__METHOD__);
        $importTypeId= $request['importId'];

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
     * FileManager
     * View the exported files
     */
    public function viewExports(Request $request)
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
                return response()->json([ "data" => ["count" => $userExports->count(), "userExports" => $userExports] ], 200);

            } catch (\Doctrine\DBAL\Query\QueryException $ex) {
                $this->logQueryException(__METHOD__, $request,$ex);
                return redirect()->back();
            }
        }
    }

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
            } catch (\Doctrine\DBAL\Query\QueryException $ex) {
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
                    ['filename' => $returnRequest['importAttachment'],
                        'type_id' => $returnRequest['importFileType'],
                        'file_location' => $returnRequest['fileLocation'],
                        'created_by' => $this->theUser->name,
                        'updated_by' => $this->theUser->name,
                        'created_at' => $currentDate,
                        'updated_at' => $currentDate,
                        'user_id' => $this->theUser->id,
                        'project_id' => $this->theProject->id,
                        'org_id' => $this->theOrg->id,
                        'stats'=>json_encode($stats)
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
                return response()->json([ "data" => "success" ], 200);

            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }
}
