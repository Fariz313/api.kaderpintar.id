<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RecordPtmExport implements FromCollection, WithHeadings
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->get();
    }

    public function headings(): array
    {
        return [
            'ID PTM',
            'ID User',
            'Nama',
            'PKM',
            'Berat',
            'Tinggi',
            'BP',
            'BP2',
            'GDS',
            'GDP',
            'created_at',
            'updated_at'
        ];
    }
}