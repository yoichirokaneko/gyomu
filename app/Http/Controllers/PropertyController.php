<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalesStaff;
use App\Pic;
use App\ActivityHistory;
use App\Client; 
use App\Property;
use App\EstimateFile;
use Carbon\Carbon;

class PropertyController extends Controller
{
    public function create($client_id, $activity_history_id){
        $client = Client::findOrFail($client_id);
        $sales_staff = SalesStaff::all();
        $this_client_pics = Pic::where('client_id', $client_id)->oldest()->get();
        $this_activity_history = ActivityHistory::findOrFail($activity_history_id);
        return view('client.property.create',[
            'client' => $client,
			'all_sales_staff' => $sales_staff,
			'this_client_pics' => $this_client_pics,
            'this_activity_history' => $this_activity_history,
		]);
    }

    public function store(Request $request, $client_id, $activity_history_id){
        $property = Property::create([
            'client_id' => $client_id,
            'activity_history_id' =>  $activity_history_id,
            'status' => $request->status,
            'pic_id' => $request->pic,
            'reason' => $request->reason,
            'sales_staff_id' => $request->sales_staff,
            'model' => $request->model,
            'introduction_date' => $request->introduction_date,
            'note' => $request->note,
            'answer_date' => $request->answer_date,
            'name' => $request->name,
        ]);

        if(!empty($request->file('estimate_file'))){
            $this_property = Property::orderBy('id', 'desc')->first();
            $property_id = $this_property->id;
            $file_original_name = $request->file('estimate_file')->getClientOriginalName();
            $filename_no_extension = pathinfo($file_original_name, PATHINFO_FILENAME);
            $extension = $request->file('estimate_file')->getClientOriginalExtension();
            $filename = $filename_no_extension . '_' . time() . '.' . $extension;
            $request->file('estimate_file')->storeAs('estimate_files/' . $client_id . '/'. $activity_history_id . '/'. $property_id, $filename);
            EstimateFile::create([
                'property_id' => $property_id,
                'path' => $filename,
            ]);
        }
        return redirect()->route('property.edit',['client_id' => $client_id])->with('flash_message', 'データを追加しました');
    }

    public function edit($client_id){
        $client = Client::findOrFail($client_id);
        $sales_staff = SalesStaff::all();
        $this_client_pics = Pic::where('client_id', $client_id)->oldest()->get();
        $this_client_properties = Property::where('client_id', $client_id)->latest()->with('activity_history')->get();
        $estimate_files = EstimateFile::all();
        $dt = new Carbon('now');
        return view('client.property.edit',[
            'client' => $client,
			'all_sales_staff' => $sales_staff,
			'this_client_pics' => $this_client_pics,
            'this_client_properties' => $this_client_properties,
            'estimate_files' => $estimate_files,
            'now_time' => $dt,
		]);
    }

    public function upsert(Request $request, $client_id){
        $this_client_properties = Property::where('client_id', $client_id)->latest()->get();
        foreach($this_client_properties as $this_client_property){
                $this_client_property->update([
                    'name' => $request->input('name' . $this_client_property->id),
                    'status' => $request->input('status' . $this_client_property->id),
                    'pic_id' => $request->input('pic' . $this_client_property->id),
                    'reason' => $request->input('reason' .$this_client_property->id),
                    'sales_staff_id' => $request->input('sales_staff' .$this_client_property->id),
                    'model' => $request->input('model' .$this_client_property->id),
                    'introduction_date' => $request->input('introduction_date' .$this_client_property->id),
                    'note' => $request->input('note' .$this_client_property->id),
                    'answer_date' => $request->input('answer_date' .$this_client_property->id),
                ]);
            }

        return back()->with('flash_message', 'データを更新しました');

    }
       
}