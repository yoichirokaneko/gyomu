<?php

namespace App\Imports;

use App\Pic;
use App\Client;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PicImport implements OnEachRow, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function OnRow(Row $row)
    {
        $row=$row->toArray();
        
        if(!empty($row['代表者名'])){
            $all_pics = Pic::all();
            $csv_client = Client::where('name', $row['会社名'])->first();
            $this_pics_count = Pic::where('client_id', $csv_client->id)->count();
            
            $key = 0;
            foreach($all_pics as $pic){
                if($pic->client_id == $csv_client->id  && $pic->name == $row['代表者名']){
                        $pic->update([
                            'position' => '1',
                        ]);
                        $key = 1;
                }else{
                    
                }
            }
            if($key == 0 && $this_pics_count < 7){
                $new_president = Pic::create([
                    'client_id' => $csv_client->id,
                    'name' => $row['代表者名'],
                    'position' => '1',
                ]);
            }
        }
    }
}