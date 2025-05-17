<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RecordPregnantExport implements FromCollection, WithHeadings
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
            'ID Record',
            'ID User',
            'Nama',
            'PKM',
            'Berat',
            'Tinggi',
            'Usia Ibu Saat Hamil',
            'Terlalu Muda Hamil di Usia ≤ 16 Tahun',
            'Terlalu Tua, Hamil di Usia ≥ 35',
            'Kehamilan lebih bulan',
            'Terlalu Lambat Hamil, kawin ≥ 4 Tahun',
            'erlalu Cepat Hamil Lagi, < 2 Tahun',
            'Terlalu Banyak Anak ≥ 4',
            'Pernah Keguguran',
            'Tarikan Tang/Vacum',
            'Uri Dirogoh',
            'Diberi infus/Tranfusi',
            'Cesar',
            'Anemia',
            'Malaria',
            'TBC',
            'Pernah gagal jantung',
            'Penyakit Menular Seksual (PMS)',
            'Hyper Tensi (Tekanan Darah Tinggi)',
            'Kehamilan Kembar',
            'Hydranion',
            'Hamil Lagi Terlalu Lama ≥ 10 Tahun',
            'Bayi Meninggal Dalam Kandungan',
            'Sungsang',
            'Lintang',
            'Preeklampsia Berat / Kejang-kejang',
            'Diabetes',
            'created_at',
            'updated_at'
        ];
    }
}