<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Language;
use App\Models\School;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $admin = Admin::orderBy('adminsId')->paginate(15);

            $school = School::all();

            $date = ["admin"=>$admin, "school"=>$school];

            return view('admin.index', $date);
        }else{
            return view('admin.auth.login');
        }
    }

    public function search(Request $req)
    {
        if($req->number == null){
            $admin = Admin::orderBy('adminsId')->paginate(15);
        }else{
            $admin = Admin::where('adminsId',$req->number)->paginate(15);
        }

        $school = School::all();

        $data = ["admin"=>$admin, "school"=>$school,];

        return view('admin.index', $data);
    }

    public function create(AdminRequest $req){
        $admin = new Admin;
        $admin->name = $req->name;
        $admin->email = $req->email;
        $admin->password = Hash::make($req->password);
        $admin->adminsId = $req->number;
        $admin->school_id = $req->school;
        $admin->save();

        $admin = Admin::orderBy('adminsId')->paginate(15);

        $school = School::all();

        $data = ["admin"=>$admin, "school"=>$school,];

        return redirect('/admin/list');
    }


    public function detail($id)
    {
        $admin = Admin::all()->where('id',$id)->first();

        $school = School::all();

        $data = ["admin"=>$admin, "school"=>$school];

        return view('admin.detail', $data);
    }

    public function update(AdminRequest $request){

        if(isset($_POST['kousin'])){
        $admin = Admin::find($request->id);
        $admin->adminsId = $request->number;
        $admin->name = $request->name;
        $admin->school_id = $request->school;
        $admin->email = $request->email;
        $admin->save();

        $school = School::all();

        session()->flash('message', '更新しました');

        return view('admin/detail', compact('admin','school'))->with('status','更新しました');
        }

        else{
            $admin = Admin::find($request->id);

            $admin->delete();

            return redirect('/admin/list')->with('status','削除しました');
        }
    }
}