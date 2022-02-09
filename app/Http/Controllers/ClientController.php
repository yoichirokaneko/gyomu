<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\ClientFile;
use App\Association;
use App\Pic;
use App\ActualModel;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function create(){
        $associations = Association::all();
        return view('client.create', ['associations' => $associations]);
    }

    public function store(Request $request){
       
        $client = Client::create([
            'name' => $request->client_name,
            'name_kana' => $request->name_kana,
            'rank' => $request->rank,
            'office_address' => $request->addr11,
            'office_address_code' => $request->zip11,
            'office_tel' => $request->office_tel,
            'office_fax' => $request->office_fax,
            'place_address' => $request->addr12,
            'place_address_code' => $request->zip12,
            'place_tel' => $request->place_tel,
            'place_fax' => $request->place_fax,
            'sales_channel' => $request->sales_channel,
            'sales_channel_company_name' => $request->sales_channel_company_name,
            'note' => $request->note,
        ]);
       
        //客先ファイルのアップロード
        if(!empty($request->file('client_file'))){
            $client_id = $client->id;
            $file_original_name = $request->file('client_file')->getClientOriginalName();
            $filename_no_extension = pathinfo($file_original_name, PATHINFO_FILENAME);
            $extension = $request->file('client_file')->getClientOriginalExtension();
            $filename = $filename_no_extension . '_' . time() . '.' . $extension;
            $request->file('client_file')->storeAs('client_files/' . $client_id, $filename);
            ClientFile::create([
                'client_id' => $client_id,
                'path' => $filename,
            ]);
        }

        //協会_顧客テーブルへの上書き
        $update_this_client_associations = [
            $request->association1,
            $request->association2,
            $request->association3,
            $request->association4,
            $request->association5,
        ];
        $UTCA_filter = array_filter($update_this_client_associations);
        $client->associations()->sync($UTCA_filter);

        //担当者の作成
        //担当者1～6の各行が全てnullの場合
        for($i = 1; $i < 7;$i ++){
            if(empty( $request->input("department_name" . $i)) 
                    && empty($request->input("pic_name" . $i)) && empty($request->input("supplement" . $i)) && empty($request->input("position" . $i)) 
                    && empty($request->input("cellphone_number" . $i)) && empty($request->input("email" . $i))){
                //何もしない
            //1か所でも入力値がある場合、新規登録
            }else{
                $pic = Pic::create([
                    'client_id' => $client->id,
                    'department_name' => $request->input("department_name" . $i),
                    'name' => $request->input("pic_name" . $i),
                    'supplement' => $request->input("supplement" . $i),
                    'position' => $request->input("position" . $i),
                    'cellphone_number' => $request->input("cellphone_number" . $i),
                    'email' => $request->input("email" . $i),
                ]);
            }
        }

        //実績型式の登録
        if(empty($request->actual_model) && empty($request->date) && empty($request->amount)){
            //何もしない
        //新規欄に何か記載があれば、新規挿入
        }else{
            $actual_model = ActualModel::create([
                'client_id' => $client->id,
                'actual_model' => $request->actual_model,
                'date' => $request->date,
                'amount' => $request->amount,
            ]);
        }
        return redirect()->route('index')->with('flash_message', '新規顧客情報を登録しました');
    }
    
    public function edit($client_id){
        $client = Client::findOrFail($client_id);
        $this_client_files = ClientFile::where('client_id', $client->id)->latest()->get();
        $associations = Association::all();
        $this_client_associations = $client->associations()->oldest()->get();
        $this_client_pics = Pic::where('client_id', $client->id)->oldest()->get();
        $this_client_actual_models =ActualModel::where('client_id', $client->id)->orderBy('date', 'desc')->get();
        return view('client.edit',[
            'client' => $client,
            'this_client_files' => $this_client_files,
            'associations' => $associations,
            'this_client_associations' => $this_client_associations,
            'this_client_pics' => $this_client_pics,
            'this_client_actual_models' => $this_client_actual_models,
        ]);
    }

    public function upsert(Request $request, $client_id){
        $client = Client::findOrFail($client_id);
       //顧客テーブルへの上書き
        $client->update([
            'name' => $request->client_name,
            'name_kana' => $request->name_kana,
            'rank' => $request->rank,
            'office_address' => $request->addr11,
            'office_address_code' => $request->zip11,
            'office_tel' => $request->office_tel,
            'office_fax' => $request->office_fax,
            'place_address' => $request->addr12,
            'place_address_code' => $request->zip12,
            'place_tel' => $request->place_tel,
            'place_fax' => $request->place_fax,
            'sales_channel' => $request->sales_channel,
            'sales_channel_company_name' => $request->sales_channel_company_name,
            'note' => $request->note,
        ]);
        //協会_顧客テーブルへの上書き
        $update_this_client_associations = [
            $request->association1,
            $request->association2,
            $request->association3,
            $request->association4,
            $request->association5,
        ];
        $UTCA_filter = array_filter($update_this_client_associations);
        $client->associations()->sync($UTCA_filter);
        
        //担当者テーブルへの上書き
        //pic_id1がある場合、更新とみなす
        if(!empty($request->pic_id1)){
            $pic = Pic::where('id', $request->pic_id1)->first();
            $pic->update([
                'department_name' => $request->department_name1,
                'name' => $request->pic_name1,
                'supplement' => $request->supplement1,
                'position' => $request->position1,
                'cellphone_number' => $request->cellphone_number1,
                'email' => $request->email1,
            ]);
        //担当者単位で全てのマスの値がnullの場合、データ登録も更新も行わない
        }elseif(empty($request->pic_id1) && empty($request->department_name1) 
                && empty($request->pic_name1) && empty($request->supplement1) && empty($request->position1) 
                && empty($request->cellphone_number1) && empty($request->email1)){
                //何もしない
        //pic_idが無い場合、1か所でも入力があれば、新規登録とみなす
        }else{
            $pic = Pic::create([
                'client_id' => $client_id,
                'department_name' => $request->department_name1,
                'name' => $request->pic_name1,
                'supplement' => $request->supplement1,
                'position' => $request->position1,
                'cellphone_number' => $request->cellphone_number1,
                'email' => $request->email1,
            ]);
        }

        //pic_id2がある場合、更新とみなす
        if(!empty($request->pic_id2)){
            $pic = Pic::where('id', $request->pic_id2)->first();
            $pic->update([
                'department_name' => $request->department_name2,
                'name' => $request->pic_name2,
                'supplement' => $request->supplement2,
                'position' => $request->position2,
                'cellphone_number' => $request->cellphone_number2,
                'email' => $request->email2,
            ]);
        //担当者単位で全てのマスの値がnullの場合、データ登録も更新も行わない
        }elseif(empty($request->pic_id2) && empty($request->department_name2) 
                && empty($request->pic_name2) && empty($request->supplement2) && empty($request->position2) 
                && empty($request->cellphone_number2) && empty($request->email2)){
                //何もしない
        //pic_idが無い行に、1か所でも入力があれば、新規登録とみなす
        }else{
            $pic = Pic::create([
                'client_id' => $client_id,
                'department_name' => $request->department_name2,
                'name' => $request->pic_name2,
                'supplement' => $request->supplement2,
                'position' => $request->position2,
                'cellphone_number' => $request->cellphone_number2,
                'email' => $request->email2,
            ]);
        }

        //pic_id3がある場合、更新とみなす
        if(!empty($request->pic_id3)){
            $pic = Pic::where('id', $request->pic_id3)->first();
            $pic->update([
                'department_name' => $request->department_name3,
                'name' => $request->pic_name3,
                'supplement' => $request->supplement3,
                'position' => $request->position3,
                'cellphone_number' => $request->cellphone_number3,
                'email' => $request->email3,
            ]);
        //担当者単位で全てのマスの値がnullの場合、データ登録も更新も行わない
        }elseif(empty($request->pic_id3) && empty($request->department_name3) 
                && empty($request->pic_name3) && empty($request->supplement3) && empty($request->position3) 
                && empty($request->cellphone_number3) && empty($request->email3)){
                //何もしない
        //pic_idが無い行に、1か所でも入力があれば、新規登録とみなす
        }else{
            $pic = Pic::create([
                'client_id' => $client_id,
                'department_name' => $request->department_name3,
                'name' => $request->pic_name3,
                'supplement' => $request->supplement3,
                'position' => $request->position3,
                'cellphone_number' => $request->cellphone_number3,
                'email' => $request->email3,
            ]);
        }

        //pic_id4がある場合、更新とみなす
        if(!empty($request->pic_id4)){
            $pic = Pic::where('id', $request->pic_id4)->first();
            $pic->update([
                'department_name' => $request->department_name4,
                'name' => $request->pic_name4,
                'supplement' => $request->supplement4,
                'position' => $request->position4,
                'cellphone_number' => $request->cellphone_number4,
                'email' => $request->email4,
            ]);
        //担当者単位で全てのマスの値がnullの場合、データ登録も更新も行わない
        }elseif(empty($request->pic_id4) && empty($request->department_name4) 
                && empty($request->pic_name4) && empty($request->supplement4) && empty($request->position4) 
                && empty($request->cellphone_number4) && empty($request->email4)){
                //何もしない
        //pic_idが無い行に、1か所でも入力があれば、新規登録とみなす
        }else{
            $pic = Pic::create([
                'client_id' => $client_id,
                'department_name' => $request->department_name4,
                'name' => $request->pic_name4,
                'supplement' => $request->supplement4,
                'position' => $request->position4,
                'cellphone_number' => $request->cellphone_number4,
                'email' => $request->email4,
            ]);
        }

         //pic_id5がある場合、更新とみなす
         if(!empty($request->pic_id5)){
            $pic = Pic::where('id', $request->pic_id5)->first();
            $pic->update([
                'department_name' => $request->department_name5,
                'name' => $request->pic_name5,
                'supplement' => $request->supplement5,
                'position' => $request->position5,
                'cellphone_number' => $request->cellphone_number5,
                'email' => $request->email5,
            ]);
        //担当者単位で全てのマスの値がnullの場合、データ登録も更新も行わない
        }elseif(empty($request->pic_id5) && empty($request->department_name5) 
                && empty($request->pic_name5) && empty($request->supplement5) && empty($request->position5) 
                && empty($request->cellphone_number5) && empty($request->email5)){
                //何もしない
        //pic_idが無い行に、1か所でも入力があれば、新規登録とみなす
        }else{
            $pic = Pic::create([
                'client_id' => $client_id,
                'department_name' => $request->department_name5,
                'name' => $request->pic_name5,
                'supplement' => $request->supplement5,
                'position' => $request->position5,
                'cellphone_number' => $request->cellphone_number5,
                'email' => $request->email5,
            ]);
        }
           
          //pic_id6がある場合、更新とみなす
          if(!empty($request->pic_id6)){
            $pic = Pic::where('id', $request->pic_id6)->first();
            $pic->update([
                'department_name' => $request->department_name6,
                'name' => $request->pic_name6,
                'supplement' => $request->supplement6,
                'position' => $request->position6,
                'cellphone_number' => $request->cellphone_number6,
                'email' => $request->email6,
            ]);
        //担当者単位で全てのマスの値がnullの場合、データ登録も更新も行わない
        }elseif(empty($request->pic_id6) && empty($request->department_name6) 
                && empty($request->pic_name6) && empty($request->supplement6) && empty($request->position6) 
                && empty($request->cellphone_number6) && empty($request->email6)){
                //何もしない
        //pic_idが無い行に、1か所でも入力があれば、新規登録とみなす
        }else{
            $pic = Pic::create([
                'client_id' => $client_id,
                'department_name' => $request->department_name6,
                'name' => $request->pic_name6,
                'supplement' => $request->supplement6,
                'position' => $request->position6,
                'cellphone_number' => $request->cellphone_number6,
                'email' => $request->email6,
            ]);
        }
        
        $this_client_actual_models = ActualModel::where('client_id', $client_id)->orderBy('date', 'desc')->get();
        //登録済みデータがある場合、既存データを更新
        if(isset($this_client_actual_models)) {
            $num = 1;
            foreach($this_client_actual_models as $this_client_actual_model){
                //カンマ区切りの数値をカンマ無に戻す処理2行
                $turn_amount = $request->input('amount' . $num);
                $amount = str_replace(',','',$turn_amount);
                $this_client_actual_model->update([
                    'actual_model' => $request->input('actual_model' . $num),
                    'date' => $request->input('date' . $num),
                    'amount' => $amount,
                ]);
                $num = $num + 1;
            }
        }

        if(empty($request->actual_model_new) && empty($request->date_new) && empty($request->amount_new)){
            //何もしない
            //新規欄に何か記載があれば、新規挿入
        }else{
            $actual_model = ActualModel::create([
                'client_id' => $client_id,
                'actual_model' => $request->actual_model_new,
                'date' => $request->date_new,
                'amount' => $request->amount_new,
            ]);
        }
        return redirect()->route('client.edit',['client_id' => $client_id])->with('flash_message', 'データを更新しました');
    }

    public function delete($client_id){
        $delete_file_path = 'client_files/' . $client_id;
        Storage::deleteDirectory($delete_file_path);
        $client = Client::findOrFail($client_id);
        $client->delete();
        return redirect()->route('index')->with('flash_message', '顧客情報を削除しました');
    }
}
