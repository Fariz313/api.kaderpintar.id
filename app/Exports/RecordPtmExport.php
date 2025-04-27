<?php

namespace App\Exports;

use App\Models\RecordPtm;
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
            'ID',
            'User ID',
            'Address',
            'Phone',
            'Created At',
            'Updated At',
            'User Name',
        ];
    }
}
