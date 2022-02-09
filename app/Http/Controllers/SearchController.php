<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Pic;
use App\ActivityHistory;
use App\Property;
use Carbon\Carbon;
use App\SalesStaff;
use App\EstimateFile;

class SearchController extends Controller
{
    // メニュー画面表示
    public function index(){
        return view('index');
    }

    //会社検索ボタン押下後の処理
    //会社名検索実行時
    public function client_name(Request $request){
        $client_name = $request->client_name_search;
        $client = Client::where('name', '=', $client_name)->first();
        $client_id = $client->id;
        return redirect()->route('client.edit',['client_id' => $client_id]);
    }

    // 会社名欄入力時のajax処理 
    public function client_name_search(Request $request){
        if($request->ajax()){
            $text = "";
            $text = $request->client_name_search;
            $clients = Client::where('name', 'LIKE', "%$text%")->get();
            return response()->json($clients);
        }else{
            $text = $request->input('client_name_serach');
        }
    }

    //担当名検索実行時
    public function client_pic(Request $request){
        $client_name = $request->client_pic_search_list;
        $client = Client::where('name', '=', $client_name)->first();
        $client_id = $client->id;
        return redirect()->route('client.edit',['client_id' => $client_id]);
    }

    // 担当者名欄入力時のajax処理 
    public function client_pic_search(Request $request){
        if($request->ajax()){
            $text = "";
            $text = $request->client_pic_search;
            $pics = Pic::where('name', 'LIKE', "%$text%")->get();
            $clients = array();
            $i = 0;
            foreach($pics as $pic){
                $clients[$i] = array(
                    'name' => $pic->client->name,
                );
                $i++;
            }
            return response()->json($clients);
        }else{
            $text = $request->input('client_pic_serach');
        }
    }

    //TEL番号検索実行時
    public function client_tel(Request $request){
        $client_name = $request->client_tel_search_list;
        $client = Client::where('name', '=', $client_name)->first();
        $client_id = $client->id;
        return redirect()->route('client.edit',['client_id' => $client_id]);
    }

    //TEL番号欄入力時のajax処理 
    public function client_tel_search(Request $request){
        if($request->ajax()){
            $text = "";
            $text = $request->client_tel_search;
            $pics = Pic::where('cellphone_number', 'LIKE', "%$text%")->get();
            $clients_cel_ary = array();
            $i = 0;
            foreach($pics as $pic){
                $clients_cel_ary[$i] = $pic->client->name;
                $i++;
                }
            $clients_tels = Client::where('office_tel','LIKE', "%$text%")->orWhere('place_tel','LIKE', "%$text%")->get('name');
            $clients_tel_ary = array();
            $ii = 0;
            foreach($clients_tels as $client_tel){
                $clients_tel_ary[$ii] = $client_tel->name;
                $ii++;
            }
            $clients_merge = array_merge($clients_cel_ary, $clients_tel_ary);
            $clients = array_unique($clients_merge);
            return response()->json($clients);
        }else{
            $text = $request->input('client_pic_serach');
        }
    }


    //履歴検索実行時
    public function client_activity(Request $request){
        $client_name = $request->client_activity_search_list;
        $client = Client::where('name', '=', $client_name)->first();
        $client_id = $client->id;
        return redirect()->route('activity_history.edit',['client_id' => $client_id]);
    }


    //履歴検索欄入力時のajax処理 
    public function client_activity_search(Request $request){
        if($request->ajax()){
            $text = "";
            $text = $request->client_activity_search;
            $activity_histories = ActivityHistory::where('detail', 'LIKE', "%$text%")->get();
            $clients = array();
            $i = 0;
            foreach($activity_histories as $activity_history){
                $clients[$i] = array(
                    'name' => $activity_history->client->name,
                );
                $i++;
            }
            return response()->json($clients);
        }else{
            $text = $request->input('client_pic_serach');
        }
    }

     //商談検索実行時
     public function property(Request $request){
        $search_word = $request->property_search;
        $properties = Property::where('name', 'LIKE', "%$search_word%")
        ->orwhereHas('client', function($query) use($search_word){
            $query->where('name', 'LIKE',  "%$search_word%");
        })
        ->with('activity_history')
        ->get();
        $dt = new Carbon('now');
        $pics = Pic::all();
        $sales_staff = SalesStaff::all();
        $estimate_files = EstimateFile::all();
        return view('property.edit',[
            'properties' => $properties,
            'now_time' => $dt,
            'pics' => $pics,
            'all_sales_staff' => $sales_staff,
            'estimate_files' => $estimate_files,
        ]);

    }
}