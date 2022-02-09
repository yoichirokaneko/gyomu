<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalesStaff;

class SalesStaffController extends Controller
{
    public function create(){
        $all_sales_staff = SalesStaff::all();
        return view('sales_staff.create',[
            'all_sales_staff' => $all_sales_staff,
		]);
    }

    public function store(Request $request){
        $sales_staff = SalesStaff::create([
            'name' => $request->name,
        ]);
        return back()->with('flash_message', 'データを更新しました');
    }

    public function delete($sales_staff_id){
        $sales_staff = SalesStaff::findOrFail($sales_staff_id);
        $sales_staff->delete();
        return redirect()->route('sales_staff.create')->with('flash_message', '営業担当者を削除しました');
    }
}
