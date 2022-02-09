<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RepairFile;
use Illuminate\Support\Facades\Storage;

class RepairFileDownloadController extends Controller
{
    public function index($client_id, $activity_history_id, $repair_file_id){
        $repair_file = RepairFile::findOrFail($repair_file_id);
        $download_filename = $repair_file->path;
        $download_path = 'repair_files/' . $client_id . '/' . $activity_history_id  . '/' . $download_filename;
        return Storage::download($download_path);
    }

    public function delete($client_id, $activity_history_id, $repair_file_id){
        $repair_file = RepairFile::findOrFail($repair_file_id);
        $delete_filename = $repair_file->path;
        $delete_file_path = 'repair_files/' . $client_id . '/' . $activity_history_id  . '/' . $delete_filename;
        Storage::delete($delete_file_path);
        $repair_file->delete();
        return redirect()->route('activity_history.edit',['client_id' => $client_id])->with('flash_message', 'ファイルを削除しました');
    }
}
