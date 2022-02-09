<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PicImport;
use App\Imports\ClientImport;
use App\Imports\AssociationImport;
use App\Exports\AssociationExport;
use App\Exports\ClientExport;
use Illuminate\Http\Request;

class CSVController extends Controller
{
    public function index(){
        return view('csv.index');
    }

    public function client_import(Request $request){
        Excel::import(new ClientImport, $request->file('client_import'));
        Excel::import(new PicImport, $request->file('client_import'));
        return back()->with('flash_message', '顧客リストをインポートしました');
    }

    public function association_import(Request $request){
        Excel::import(new AssociationImport, $request->file('association_import'));
        return back()->with('flash_message', '協会リストをインポートしました');
    }

    public function client_export(){
        return Excel::download(new ClientExport, 'client.xlsx');
    }

    public function association_export(){
        return Excel::download(new AssociationExport, 'association.xlsx');
    }
}
