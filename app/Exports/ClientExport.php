<?php

namespace App\Exports;

use App\Client;
use App\Pic;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $all_clients = Client::select('id', 'name', 'office_address', 'office_address_code', 'office_tel', 'office_fax')->get();
        $all_key_person = Pic::where('supplement', '1')->select('client_id', 'name')->get();
        $export_data = array();
        $i = 0;
        foreach($all_clients as $client){

            $key = 0;
            foreach($all_key_person as $key_person){
                if($client->id == $key_person->client_id){
                    $export_data[$i] = array([
                        'name' => $client->name,
                        'office_address' => $client->office_address,
                        'office_address_code' => $client->office_address_code,
                        'office_tel' => $client->office_tel,
                        'office_fax' => $client->ocffice_fax,
                        'key_person' => $key_person->name,
                    ]);
                    $key = 1;
                    $i = $i +1;
                }
            }
            if($key == 0){
                $export_data[$i] = array([
                    'name' => $client->name,
                    'office_address' => $client->office_address,
                    'office_address_code' => $client->office_address_code,
                    'office_tel' => $client->office_tel,
                    'office_fax' => $client->ocffice_fax,
                    'key_person' => '',
                ]);
                $i = $i +1;
            } 
        }
        $export_data_col = collect($export_data);

        return $export_data_col;
    }

    public function headings():array
    {
        return [
            '会社名',
            '住所',
            '郵便番号',
            'TEL',
            'FAX',
            'キーマン'
        ];
    }
}
