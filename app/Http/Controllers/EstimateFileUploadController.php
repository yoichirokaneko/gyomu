<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstimateFile;

class EstimateFileUploadController extends Controller
{
    public function store(Request $request, $client_id, $activity_history_id, $property_id){
        $file_original_name = $request->file('estimate_file'. $property_id)->getClientOriginalName();
        $filename_no_extension = pathinfo($file_original_name, PATHINFO_FILENAME);
        $extension = $request->file('estimate_file'. $property_id)->getClientOriginalExtension();
        $filename = $filename_no_extension . '_' . time() . '.' . $extension;
        $request->file('estimate_file'. $property_id)->storeAs('estimate_files/' . $client_id . '/'. $activity_history_id . '/'. $property_id, $filename);
        EstimateFile::create([
            'property_id' => $property_id,
            'path' => $filename,
        ]);
        return back()->with('flash_message', 'ファイルをアップロードしました');
    }
}
