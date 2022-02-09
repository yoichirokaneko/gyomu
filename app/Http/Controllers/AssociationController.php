<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Association;
use App\Pic;

class AssociationController extends Controller
{
    public function create(){
        return view('association.create');
    }

    public function store(Request $request){
        $association = Association::create([
            'name' => $request->name,
            'address' => $request->addr11,
            'address_code' => $request->zip11,
            'pic_name' => $request->pic_name,
            'tel' => $request->tel,
            'email' => $request->email,
            'fax' => $request->fax,
            'note' => $request->note,
        ]);
        return redirect()->route('index')->with('flash_message', '新規協会情報を登録しました');
    }

    public function show(){
        $associations = Association::all();
        return view('association.show', ['associations' => $associations]);
    } 

    public function edit($association_id){
        $association = Association::findOrFail($association_id);
        $this_association_clients = $association->clients;
        $presidents = Pic::where('position', '1')->get();
        return view('association.edit', [
            'association' => $association,
            'this_association_clients' => $this_association_clients,
            'presidents' => $presidents,
        ]);
    }
    
    public function update(Request $request, $association_id){
        $association = Association::findOrFail($association_id);
        $association->update([
            'name' => $request->name,
            'address' => $request->addr11,
            'address_code' => $request->zip11,
            'pic_name' => $request->pic_name,
            'tel' => $request->tel,
            'email' => $request->email,
            'fax' => $request->fax,
            'note' => $request->note,
        ]);
        return redirect()->route('association.edit', $association_id)->with('flash_message', '協会情報を更新しました');
    }

    public function delete($association_id){
        $association = Association::findOrFail($association_id);
        $association->delete();
        return redirect()->route('association.show')->with('flash_message', '協会情報を削除しました');
    }
}
