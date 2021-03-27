<?php

namespace App\Exports;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class FileExportsFromQuery implements FromCollection, WithStrictNullComparison, WithHeadings, WithMapping
{
    const ACCESSION_NUMBER = 'accession_number';
    const PROVENANCE_1 = 'provenance1';
    const PROVENANCE_2 = 'provenance2';
    const DESIGNATOR = 'designator';
    use Exportable;

    const SKELETAL_BONE = 'skeletal_bone';
    const SIDE = 'side';
    const SKELETAL_ELEMENT = 'skeletal_element';
    const NAME = 'name';
    const MEASURE = 'measure';
    /**
     * @var String
     * hold the query string to be executed
     */
    private $query;

    /**
     * @var array
     * Stores the column headers for excel file to be exported
     */
    private $columnHeaders = [];

    /**
     * @var array
     * store the exported data from tables
     */
    private $exportData;

    /**
     * @var String
     * The type of export to format exported data accordingly 
     */
    private $exportType;

    /**
     * @var String
     * The type of export to format exported data accordingly
     */
    private $skeletalBoneName;

    public function __construct($query, $exportType, $skeletalBoneName = null)
    {
        $this->query = $query;
        $this->exportType = $exportType;
        $this->skeletalBoneName = $skeletalBoneName;

        // Execute the query string and format the query result if needed
        $this->exportData = $this->executeQuery();

        // Return column headers
        $this->columnHeaders = $this->headings();
    }

    /**
     * return exported data
     * @return Collection
     */
    public function collection()
    {
        return $this->exportData;
    }

    /**
     * return column headers
     * @return array
     */
    public function headings(): array
    {
        return $this->columnHeaders;
    }

    /**
     * map bool values to readable format
     * @return array
     */
    public function map($object): array
    {
        if (!is_array($object)) {
            $object = $object->toArray();
        }
        foreach($object as $key => $value) {
            if(is_bool($value)) {
                if($value) {
                    $object[$key] = "True";
                } else {
                    $object[$key] = "False";
                }
            }
        }
        return $object;
    }

    /**
     * Executes the query string and format the result based on export type
     * @return Collection
     */
    public function executeQuery()
    {
        // Execute query and save it in class variable
        $exportData = collect(DB::select($this->query))->map(function ($item) {
            return get_object_vars($item);
        });

        if ($this->exportType->name == 'Osteometric Sorting') {
            // Get all the bone types for each skeletal bone,
            // to ensure proper mapping of measurements and bone type
            $skeletalBoneTypes = DB::select($this->getQueryForSkeletalBoneTypes());
            $currentExportData = $this->formatExportObjectFromQuery($exportData, $skeletalBoneTypes);

            if (!$currentExportData->isEmpty()) {
                $this->updateColumnHeaders(array_keys($currentExportData[0]));

                return collect($currentExportData);
            }
        }

        return $exportData;
    }

    /**
     * Format query result
     * @param $exportObject
     * @param $skeletalBoneTypes
     * @return Collection
     */
    public function formatExportObjectFromQuery(Collection $exportObject, array $skeletalBoneTypes)
    {
        $exportDataArray = $exportObject->toArray();
        // Create an array with all keys (column-headers) with default empty values
        // This ensures the column headers and values in the generated file are in proper sorted order
        $formattedArray = $this->setDefaultMeasurements($skeletalBoneTypes);
        $formattedDataArray = [];

        foreach ($exportDataArray as $exportRow) {
            $seKey = $this->getKeyAttribute($exportRow);

            if ($seKey == array_get($formattedArray, self::SKELETAL_ELEMENT, null)) {
                array_set($formattedArray, array_get($exportRow, self::NAME, ''), array_get($exportRow, self::MEASURE, ''));
            } else {
                if (sizeof($formattedArray) && !empty(array_get($formattedArray, self::SKELETAL_ELEMENT))) {
                    array_push($formattedDataArray, $formattedArray);

                    // Reset the array to defaults for a new skeletal element
                    // This will be a new row on the generated excel file
                    $formattedArray = $this->setDefaultMeasurements($skeletalBoneTypes);
                }

                array_set($formattedArray, 'se_id', array_get($exportRow, 'id', ''));
                array_set($formattedArray, self::SKELETAL_ELEMENT, $seKey);
                array_set($formattedArray, self::ACCESSION_NUMBER, array_get($exportRow, self::ACCESSION_NUMBER, ''));
                array_set($formattedArray, self::PROVENANCE_1, array_get($exportRow, self::PROVENANCE_1, ''));
                array_set($formattedArray, self::PROVENANCE_2, array_get($exportRow, self::PROVENANCE_2, ''));
                array_set($formattedArray, self::DESIGNATOR, array_get($exportRow, self::DESIGNATOR, ''));
                array_set($formattedArray, self::SKELETAL_BONE, array_get($exportRow, self::SKELETAL_BONE, ''));
                array_set($formattedArray, self::SIDE, array_get($exportRow, self::SIDE, ''));
                array_set($formattedArray, array_get($exportRow, self::NAME, ''), array_get($exportRow, self::MEASURE, ''));
            }
        }
        // Make sure last iteration's data gets pushed to the returened data
        array_push($formattedDataArray, $formattedArray);

        return collect($formattedDataArray);
    }

    /**
     * Update column headers once query is executed
     * @param $headers
     */
    public function updateColumnHeaders(array $headers)
    {
        foreach ($headers as $header) {
            array_push($this->columnHeaders, $header);
        }
    }

    /**
     * Set a default array with all keys in proper order
     * This makes sure the generated file has no mismatched headers and values
     * @param $boneTypes
     * @return array
     */
    public function setDefaultMeasurements($boneTypes)
    {
        $measurementsArray = [
            'se_id'                 =>  '',
            self::SKELETAL_ELEMENT  => '',
            self::ACCESSION_NUMBER  => '',
            self::PROVENANCE_1      => '',
            self::PROVENANCE_2      => '',
            self::DESIGNATOR        => '',
            self::SKELETAL_BONE     => '',
            self::SIDE              => '',
        ];
        foreach ($boneTypes as $boneType) {
            array_set($measurementsArray, $boneType->name, '');
        }

        return $measurementsArray;
    }

    /**
     * Create skeletal element key
     * @param $row
     * @return string
     */
    public function getKeyAttribute($row)
    {
        $accession = array_get($row, self::ACCESSION_NUMBER, '');
        $p1 = $row[self::PROVENANCE_1] != 'None' ? $row[self::PROVENANCE_1] : '';
        $p2 = $row[self::PROVENANCE_2] != 'None' ? $row[self::PROVENANCE_2] : '';
        $designator = array_get($row, self::DESIGNATOR, '');

        return ($accession . '-' . $p1 . '-' . $p2 . '-' . $designator);
    }

    /**
     * Return query for skeletal bone types
     * @param $row
     * @return string
     */
    public function getQueryForSkeletalBoneTypes()
    {
        return "select name from measurements where sb_id = (select id from skeletal_bones where name = '" . $this->skeletalBoneName . "') ORDER BY name ASC;";
    }
}
