<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;

class AllPropertyController extends Controller
{
    public function upsert(Request $request){
        $this_properties_id = $request->hidden_id;
        $properties = Property::whereIn('id', $this_properties_id)->get();
        $i = 0;
        foreach($properties as $property){
            $property->update([
                'name' => $request->name[$i],
                'status' => $request->status[$i],
                'pic_id' => $request->pic[$i],
                'reason' => $request->reason[$i],
                'sales_staff_id' => $request->sales_staff[$i],
                'model' => $request->model[$i],
                'introduction_date' => $request->introduction_date[$i],
                'note' => $request->note[$i],
                'answer_date' => $request->answer_date[$i],
            ]);
            $i = $i + 1;
        }
        return back()->with('flash_message', 'データを更新しました');
    }
}
