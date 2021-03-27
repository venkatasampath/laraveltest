<?php

// This file involves the seeding of database tables directly from CSV files
// All seeder classes must inherit this abstract class CsvDataSeeder to seed tables from CSV files

namespace App\Imports;

use App\Dna;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\SkeletalElement;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Exception;

/*
 * This function retrieves data from CSV files
 * It is invoked by a Seeder class and
 * seeds the corresponding tables with the data
 * $table                   Sets the Table Name
 * $filename                Sets the absolute path file name of the CSV
 * $offsetRows              Denotes the rows to be offset from the start of CSV file
 * $insertChunkSize         Inserts data to DB from array once this value is reached
 * $mapping                 Creates a map of DB column names
 * $idExists                Boolean flag to check if the CSV file has an id column, if true, the "id" column will be used to do an update
 * $user                    Current user
 */

class ImportDataSeeder extends Seeder
{
    public $table;
    public $filename;
    public $user;
    public $insertChunkSize = 500;
    public $csvDelimiter = ',';
    public $offsetRows = 1;
    public $mapping = [];
    public $idExists = false;

    public function __construct($table, $filename, $user)
    {
        $this->table = $table;
        $this->filename = $filename;
        $this->user = $user;
    }

    public function setColumnMapping()
    {
        /*
         * Retrieve the column names of the table and store them in the array
         */
        $columns = Schema::getColumnListing($this->table);
        $i = 1;
        while ($i < (sizeof($columns) - 1)) {
            array_push($this->mapping, $columns[$i]);
            $i++;
        }
    }

    public function openFile($filename)
    {
        /*
         * Open the current file and return the file handle
         */
        $handle = fopen($filename, 'r');
        return $handle;
    }

    public function seedFromFile($filename, $deliminator = ',')
    {
        ini_set('auto_detect_line_endings', TRUE);
        $handle = $this->openFile($filename);
        /*
         * CSV doesn't exist or couldn't be read from.
         */
        if ($handle === FALSE) {
            Log::info('ImportDataSeeder.seedFromCSV File ' . $filename . ' could not be opened is ');
            return [];
        }

        $header = NULL;
        $rowCount = 0;
        $data = [];
        $csvHeaderArray = [];
        $mapping = $this->mapping ?: [];
        $csvDbColumnMap = [];

        /*
         * Create a key:value pair of Db column name and csv file column name from the import mapping table
         */
        foreach ($mapping as $dbCol) {
            $csvColumnName = DB::table('import_csv_file_table_map')->where('table_name', $this->table)
                                                    ->where('table_column_name', '=', $dbCol)
                                                    ->value('csv_column_name');
            /*
             * Set the key:value only if we have a mapping
             */
            if($csvColumnName) {
                $csvDbColumnMap [$dbCol] = $csvColumnName;
            }
        }
        $offset = $this->offsetRows;

        /*
         * Read each row from the CSV file
         */
        while (($row = fgetcsv($handle, 0, $deliminator)) !== FALSE) {

            // If an offset exists, offset the specified number of rows
            while ($offset > 0) {
                //If the row being read is the first, store the CSV header names in an array
                $index = 0;
                while ($index < sizeof($row)) {
                    /*
                     * Check if the imported CSV file has an "id" column and set the flag
                     */
                    if($row[$index] == 'id') {
                        $this->idExists = true;
                    }
                    array_push($csvHeaderArray, $row[$index]);
                    $index++;
                }
                $offset--;
                continue 2;
            }
            ini_set('auto_detect_line_endings', FALSE);

            //No mapping specified - grab the first CSV row and use it
            if (!$mapping) {
                $mapping = $row;
            } else {
                /*
                 * Array to store CSV column headers
                 */
                $sourceArray = $this->readRow($row, $csvHeaderArray);

                /*
                 * Create a map of database column names to the corresponding values from current CSV file
                 */
                $row = $this->fillMapArray($sourceArray, $csvDbColumnMap);

                // Insert only non-empty rows from the csv file
                if (!$row)
                    continue;
                $data[$rowCount] = $row;
                /*
                 * Chunk size reached, insert school_summary
                */
                if (++$rowCount == $this->insertChunkSize) {
                    $this->insert($data);
                    $rowCount = 0;
                    // Clear the array explicitly to avoid duplicate inserts
                    $data = array();
                }
            }
        }

        // Insert any leftover rows
        if (count($data))
            $this->insert($data);
        fclose($handle);
        return $data;

    }

    public function readRow(array $row, array $csvHeaderArray)
    {
        /*
         * Read the values of the current CSV file column headers and store them in an array
         */
        $sourceArray = [];
        foreach ($csvHeaderArray as $index => $csvCol) {
            if (!isset($row[$index]) || $row[$index] === '') {
                $sourceArray[$csvCol] = NULL;
            } else {
                $sourceArray[$csvCol] = $row[$index];
            }
        }
        return $sourceArray;
    }

    /*
     * This function prepares array mapping DB Columns and CSV Values
     * It is invoked for each row read from the CSV file
     * Checks for Foreign Keys in the table to insert data
     * Retrieves the associated ID value of Foreign Key from corresponding table
     * Eg: In the CSV file, user will always upload data with the Measurement Name and measure value
     * Using the Measurement name, we will retrieve the corresponding (Primary Key) 'id' value from measurements table
     * This "id" value will be inserted as 'measurement_id' foreign key in se_measurement table
     */
    public function fillMapArray($sourceArray, $csvDbColumnMap)
    {
        $rowValues = [];
        $numOfColumnsToFill = sizeof($sourceArray);

        /*
         * Create a key : value pair between DB column names and current CSV file
         * Check for DB Column Foreign Keys, and retrieve the Primary key based
         * upon the 'name' value provided in CSV File from the associated table
         */
        foreach($csvDbColumnMap as $dbCol => $csvHeader) {
            if($dbCol == 'sb_id') {
                $currentBone = $sourceArray['bone'];
                $skeletalBoneId = DB::table('skeletal_bones')->where('name', $currentBone)->value('id');
                $rowValues[$dbCol] = $skeletalBoneId;
                $numOfColumnsToFill--;
            } elseif ($dbCol == 'se_id') {
                $skeletalElementId = DB::table('skeletal_elements')->where([
                                                            ['accession_number', $sourceArray['Accession_Number']],
                                                            ['provenance1', $sourceArray['Provenance1']],
                                                            ['provenance2', $sourceArray['Provenance2']],
                                                            ['designator', $sourceArray['Designator']]
                                                            ])->value('id');
                $rowValues[$dbCol] = $skeletalElementId;
                $numOfColumnsToFill--;
            } elseif ($dbCol == 'measurement_id') {
                $measurementId = DB::table('measurements')->where('name', $sourceArray['Measurement_Name'])->value('id');
                $rowValues[$dbCol] = $measurementId;
                $numOfColumnsToFill--;
            } elseif ($dbCol == 'zone_id') {
                $skeletalBoneId = DB::table('skeletal_bones')->where('name', $sourceArray['bone'])->value('id');
                $zoneId = DB::table('zones')->where([
                                                    ['name', $sourceArray['Zone_Name']],
                                                    ['sb_id', $skeletalBoneId]
                                                    ])->value('id');
                $rowValues[$dbCol] = $zoneId;
                $numOfColumnsToFill--;
            } elseif ($dbCol == 'lab_id') {
                $labId = DB::table('labs')->where('name', $sourceArray['Lab_Name'])->value('id');
                $rowValues[$dbCol] = $labId;
                $numOfColumnsToFill--;
            } else {
                if($numOfColumnsToFill > 0) {
                    $rowValues[$dbCol] = $sourceArray[$csvHeader];
                    $numOfColumnsToFill--;
                }
            }
        }

        // This ensures org, project and user IDs are always set
        if($this->table == 'skeletal_elements') {
            // Set user id only for skeletal_elements
            $rowValues['user_id'] = $this->user->id;
        }
        $rowValues['org_id'] = $this->user->org->id;
        $rowValues['project_id'] = $this->user->getProfileValue('default_project');
        return $rowValues;
    }

    public function insert(array $seedData)
    {
        //TODO : Update to handle DNA and SE_Measurements table

        if($this->table == 'skeletal_elements') {
            try {
                for($i = 0; $i < count($seedData); $i++) {
                    if($this->idExists) {
                        SkeletalElement::updateOrCreate(['id' => $seedData[$i]['id']], $seedData[$i]);
                    } else {
                        SkeletalElement::updateOrCreate([
                            'accession_number' => $seedData[$i]['accession_number'],
                            'provenance1' => $seedData[$i]['provenance1'],
                            'provenance2' => $seedData[$i]['provenance2'],
                            'designator' => $seedData[$i]['designator']
                        ], $seedData[$i]);
                    }
                }
            } catch (Exception $e) {
                Log::error("CSV insert failed: " . $e->getMessage() . " - CSV " . $this->filename);
                return FALSE;
            }
        } else if ($this->table == 'dnas') {
            try {
                for($i = 0; $i < count($seedData); $i++) {
                    if($this->idExists) {
                        Dna::updateOrCreate(['id' => $seedData[$i]['id']], $seedData[$i]);
                    } else {
                        Dna::updateOrCreate(['se_id' => $seedData[$i]['se_id']], $seedData[$i]);
                    }
                }
            } catch (Exception $e) {
                Log::error("CSV insert failed: " . $e->getMessage() . " - CSV " . $this->filename);
                return FALSE;
            }
        } else {
            // For tables with no Eloquent Model, inserting directly is the only option
            try {
                DB::table($this->table)->insert($seedData);
            } catch (\Exception $e) {
                Log::error("CSV insert failed: " . $e->getMessage() . " - CSV " . $this->filename);
                return FALSE;
            }
        }
        return TRUE;
    }
}
