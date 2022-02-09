<?php

namespace App\Exports;

use App\Association;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssociationExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Association::all()->makeHidden(['id', 'email', 'note','created_at','updated_at']);
    }

    public function headings():array
    {
        return [
            '協会名',
            '住所',
            '郵便番号',
            '担当者',
            'TEL',
            'FAX'
        ];
    }
}
