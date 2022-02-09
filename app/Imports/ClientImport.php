<?php

namespace App\Imports;

use App\Client;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientImport implements  OnEachRow, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function OnRow(Row $row)
    {
        $row=$row->toArray();
        Client::updateOrCreate(
            // 既存DB内に同じnameがある場合、更新。無ければ新規
            [   'name'=>$row['会社名']],
            // データベースのカラムとエクセルのカラムを紐づけ
            [
                'office_address' => $row['住所'],
                'office_address_code' => $row['郵便番号'],
                'office_tel' => $row['TEL'],
                'office_fax' => $row['FAX'],
            ]
        );
    }
}
