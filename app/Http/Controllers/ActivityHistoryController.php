<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Pic;
use App\SalesStaff;
use App\ActivityHistory;
use App\RepairFile;

class ActivityHistoryController extends Controller
{
    public function edit($client_id){
        $client = Client::findOrFail($client_id);
        $this_client_pics = Pic::where('client_id', $client_id)->oldest()->get();
        $sales_staff = SalesStaff::all();
        $this_client_activity_histories = ActivityHistory::where('client_id', $client_id)->latest()->get();
        $repair_files = RepairFile::all();
        return view('client.activity_history',[
            'client' => $client,
            'this_client_pics' => $this_client_pics,
            'all_sales_staff' => $sales_staff,
            'this_client_activity_histories' => $this_client_activity_histories,
            'repair_files' => $repair_files,
        ]);
    }

    public function upsert(Request $request, $client_id){
        $this_client_activity_histories = ActivityHistory::where('client_id', $client_id)->latest()->get();
         //登録済みデータがある場合、既存データを更新
         if(isset($this_client_activity_histories)) {
            foreach($this_client_activity_histories as $this_client_activity_history){
                $this_client_activity_history->update([
                    'date' => $request->input('date' . $this_client_activity_history->id),
                    'pic_id' => $request->input('pic' . $this_client_activity_history->id),
                    'reason' => $request->input('reason' . $this_client_activity_history->id),
                    'sales_staff_id' => $request->input('sales_staff' . $this_client_activity_history->id),
                    'detail' => $request->input('detail' . $this_client_activity_history->id),
                ]);
            }
        }

        if(empty($request->date_new) && empty($request->pic_new) && empty($request->reason_new)
            && empty($request->sales_staff_new) && empty($request->detail_new)){
            //何もしない
            //新規欄に何か記載があれば、新規挿入
        }else{
            $activity_history = ActivityHistory::create([
                'client_id' => $client_id,
                'date' => $request->date_new,
                'pic_id' => $request->pic_new,
                'reason' => $request->reason_new,
                'sales_staff_id' => $request->sales_staff_new,
                'detail' => $request->detail_new,
            ]);
        }
        return redirect()->route('activity_history.edit',['client_id' => $client_id])->with('flash_message', 'データを更新しました');
    }
}
