<?php

namespace App\Exports;

use App\SkeletalElement;
use Doctrine\DBAL\Types\BooleanType;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class FileExports implements FromCollection, WithHeadings, WithStrictNullComparison, WithMapping
{
    use Exportable;
    private $selectedColumns;
    private $selectedTable;


    public function __construct($selectedTable, $selectedColumns)
    {
        $this->selectedTable = $selectedTable;
        $this->selectedColumns = $selectedColumns;
    }

    public function collection()
    {
       return DB::table($this->selectedTable)->select($this->selectedColumns)->get()->map(function ($item) {
            return get_object_vars($item);
        });
    }

    public function headings(): array
    {
        return $this->selectedColumns;
    }

    public function map($object) :array
    {
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
}
