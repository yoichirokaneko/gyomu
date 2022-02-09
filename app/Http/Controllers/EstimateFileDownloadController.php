<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstimateFile;
use Illuminate\Support\Facades\Storage;

class EstimateFileDownloadController extends Controller
{
    public function index($client_id, $activity_history_id, $property_id, $estimate_file_id){
        $estimate_file = EstimateFile::findOrFail($estimate_file_id);
        $download_filename = $estimate_file->path;
        $download_path = 'estimate_files/' . $client_id . '/' . $activity_history_id  . '/' . $property_id . '/' . $download_filename;
        return Storage::download($download_path);
    }

    public function delete($client_id, $activity_history_id, $property_id, $estimate_file_id){
        $estimate_file = EstimateFile::findOrFail($estimate_file_id);
        $delete_filename = $estimate_file->path;
        $delete_file_path = 'estimate_files/' . $client_id . '/' . $activity_history_id  . '/' . $property_id . '/' . $delete_filename;
        Storage::delete($delete_file_path);
        $estimate_file->delete();
        return back()->with('flash_message', 'ファイルを削除しました');
    }
}
