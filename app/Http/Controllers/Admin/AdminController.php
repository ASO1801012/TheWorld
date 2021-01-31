<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Language;
use App\Models\School;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admin = Admin::all();

        $school = School::all();

        $date = ["admin"=>$admin, "school"=>$school];

        return view('admin.index', $date);
    }

    public function create(Request $req){
        $admin = new Admin;
        $admin->name = $req->name;
        $admin->email = $req->email;
        $admin->password = Hash::make($req->password);
        $admin->adminsId = $req->number;
        $admin->school_id = $req->school;
        $admin->save();

        $admin = Admin::all();

        $school = School::all();

        $data = ["admin"=>$admin, "school"=>$school,];

        return view('admin.index', $data);
    }


    public function detail($id)
    {
        $admin = Admin::all()->where('id',$id)->first();

        $school = School::all();

        $data = ["admin"=>$admin, "school"=>$school];

        return view('admin.detail', $data);
    }

    public function update(Request $request)
    {
        $admin = Admin::find($request->id);
        $admin->adminsId = $request->number;
        $admin->name = $request->name;
        $admin->school_id = $request->school_id;
        $admin->email = $request->email;
        $admin->save();

        $school = School::all();

        session()->flash('message', '更新したよ');

        return view('admin/detail', compact('admin','school'))->with('status','更新したよ');
    }

    public function delete($id)
    {
        $admin = Admin::find($id);

        $admin->delete();

        return redirect('/admin/list')->with('status','削除しました');
    }
}