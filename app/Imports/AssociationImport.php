<?php

namespace App\Imports;

use App\Association;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssociationImport implements OnEachRow, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function OnRow(Row $row)
    {  
       $row=$row->toArray();
       Association::updateOrCreate(
            // 既存DB内に同じnameがある場合、更新。無ければ新規
            [   'name'=>$row['協会名']],
            // データベースのカラムとエクセルのカラムを紐づけ
            [
                'address' => $row['住所'],
                'address_code' => $row['郵便番号'],
                'pic_name' => $row['担当者'],
                'tel' => $row['TEL'],
                'fax' => $row['FAX'],
            ]
        );
    }

    // public function model(array $row)
    // {
    //     $DB_association = Association::all();
    //     if
    //     new Association([
    //         'name' => $row['association'],
    //         'address' => $row['address'],
    //         'address_code' => $row['address_code'],
    //         'pic_name' => $row['pic_name'],
    //         'tel' => $row['tel'],
    //         'fax' => $row['fax'],

    //     ]);
    // }

    // public function uniqueBy()
    // {
    //     return 'name';
    // }

    // public function rules(): array
    // {
    //     return [
    //         'name' => 'required|unique:associations',
    //     ];
    // }
}
