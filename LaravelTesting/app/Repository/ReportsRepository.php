<?php

namespace App\Repository;

use App\SkeletalElement;
use App\Scopes\ProjectScope;

class ReportsRepository
{
    // Search term constants
    const ACCESSIONNUM = 1;
    const PROV1= 2;
    const PROV2 = 3;
    const DESIGNATOR = 4;

    public function __construct() {
        //;
    }
    
    public function doMethodsSearch($searchParams) 
    {
        $results = SkeletalElement::withoutGlobalScope(ProjectScope::class)->where($searchParams['field'], $searchParams['operator'], $searchParams['value'])
                        ->join('skeletal_bones', 'skeletal_elements.sb_id', '=' ,'skeletal_bones.id')
                        ->join('se_method_feature', 'skeletal_elements.id', '=', 'se_method_feature.se_id')
                        ->join('method_features', 'se_method_feature.method_feature_id', '=', 'method_features.id')
                        ->join('methods', 'se_method_feature.method_id', '=', 'methods.id')
                        ->select('accession_number', 'provenance1', 'provenance2', 'designator', 'side', 'skeletal_bones.name as bone', 'methods.name as method', 'method_features.feature', 'score')
                        ->get();
        
//        dd($results);
            
        return $results;
    }
    
    public function doMeasurementsSearch($searchParams) 
    {
        $tmpResults = SkeletalElement::withoutGlobalScope(ProjectScope::class)->where($searchParams['field'], $searchParams['operator'], $searchParams['value'])
                        ->join('se_measurement', 'skeletal_elements.id', '=', 'se_measurement.se_id')
                        ->join('measurements', 'se_measurement.measurement_id', '=', 'measurements.id')
                        ->join('skeletal_bones', 'skeletal_elements.sb_id', '=', 'skeletal_bones.id')
                        ->select('accession_number', 'provenance1', 'provenance2', 'designator', 'side', 'skeletal_bones.name as bone', 'measurements.name as measurename', 'measure')
                        ->get();
        
        $results = array();
        foreach($tmpResults as $result) {
            $composite_key = $result->accession_number . '-' . $result->provenance1 . '-' . $result->provenance2 . '-' . $result->designator;
            if (!array_key_exists($composite_key, $results)) {
                $results[$composite_key] = array('accession_number' => $result->accession_number, 'provenance1' => $result->provenance1, 'provenance2' => $result->provenance2, 'designator' => $result->designator, 'bone' => $result->bone, 'side'=> $result->side);
            }
            $results[$composite_key][$result->measurename] = $result->measure;  
        }

        return $results;
    }
    
    public function doDNASearch($searchParams) 
    {
        $results = SkeletalElement::withoutGlobalScope(ProjectScope::class)->where($searchParams['field'], $searchParams['operator'], $searchParams['value'])
                        ->join('skeletal_bones', 'skeletal_elements.sb_id', '=' ,'skeletal_bones.id')
                        ->join('dnas', 'skeletal_elements.id', '=', 'dnas.se_id')
                        ->select('accession_number', 'provenance1', 'provenance2', 'designator', 'side', 'skeletal_bones.name as bone', 'mito_sequence_number as sequence', 'mito_sequence_subgroup as subgroup')
                        ->get();
        
        return $results;
    }
    
    public function getSearchParams($searchBy, $value) 
    {
        switch ($searchBy) {
            case self::ACCESSIONNUM:
                $searchParams = [
                  'field'=>'accession_number', 
                    'operator'=>'=', 
                    'value'=>$value  
                ];
                break;
            case self::PROV1:
                $searchParams = [
                  'field' => 'provenance1', 
                    'operator' => '=', 
                    'value' => $value  
                ];
                break;
            case self::PROV2:
                $searchParams = [
                  'field'=>'provenance2', 
                    'operator'=>'=', 
                    'value'=>$value  
                ];
                break;
            case self::DESIGNATOR:
                $searchParams = [
                  'field'=>'designator', 
                    'operator'=>'=', 
                    'value'=>$value  
                ];
                break;
                
        }
        return $searchParams;
    }
}
