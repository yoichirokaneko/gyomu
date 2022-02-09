<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RepairFile;

class RepairFileUploadController extends Controller
{
    public function store(Request $request, $client_id,$activity_history_id){
        $file_original_name = $request->file('repair_file'. $activity_history_id)->getClientOriginalName();
        $filename_no_extension = pathinfo($file_original_name, PATHINFO_FILENAME);
        $extension = $request->file('repair_file'. $activity_history_id)->getClientOriginalExtension();
        $filename = $filename_no_extension . '_' . time() . '.' . $extension;
        $request->file('repair_file'. $activity_history_id)->storeAs('repair_files/' . $client_id . '/'. $activity_history_id, $filename);
        RepairFile::create([
            'activity_history_id' => $activity_history_id,
            'path' => $filename,
        ]);
        return redirect()->route('activity_history.edit',['client_id' => $client_id])->with('flash_message', 'ファイルをアップロードしました');
    }
}
