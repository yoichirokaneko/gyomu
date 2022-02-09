<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClientFile;
use Illuminate\Support\Facades\Storage;

class ClientFileDownloadController extends Controller
{
    public function index($client_id, $client_file_id){
        $client_file = ClientFile::findOrFail($client_file_id);
        $download_filename = $client_file->path;
        $download_path = 'client_files/' . $client_id . '/' .$download_filename;
        return Storage::download($download_path);
        
    }

    public function delete($client_id, $client_file_id){
        $client_file = ClientFile::findOrFail($client_file_id);
        $delete_filename = $client_file->path;
        $delete_file_path = 'client_files/' . $client_id . '/' .$delete_filename;
        Storage::delete($delete_file_path);
        $client_file->delete();
        return redirect()->route('client.edit',['client_id' => $client_id])->with('flash_message', 'ファイルを削除しました');
    }
}
