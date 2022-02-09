<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClientFile;
use App\Client;

class ClientFileUploadController extends Controller
{
    public function store(Request $request, $client_id){
        $file_original_name = $request->file('client_file')->getClientOriginalName();
        $filename_no_extension = pathinfo($file_original_name, PATHINFO_FILENAME);
        $extension = $request->file('client_file')->getClientOriginalExtension();
        $filename = $filename_no_extension . '_' . time() . '.' . $extension;
        $request->file('client_file')->storeAs('client_files/' . $client_id, $filename);
        ClientFile::create([
            'client_id' => $client_id,
            'path' => $filename,
        ]);
        return redirect()->route('client.edit',['client_id' => $client_id])->with('flash_message', 'ファイルをアップロードしました');
    }

    
}
