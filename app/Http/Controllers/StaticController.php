<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_user;
use App\Models\tbl_traceEmployee;

class StaticController extends Controller
{

    public function index(Request $request)
    {
        if($request->type == 1){
            $users = tbl_user::get();
            return view('data_User.view',compact('users'));
          }
    }

    public function edit(Request $request,$id)
    {
        $user = tbl_user::find($id);
        $dataBranch = tbl_traceEmployee::getBranch();
        if($request->type == 1){ //แก้ไขข้อมูลผู้ใช้งาน
            return view('data_User.section-editUser.editUser',compact('user','dataBranch'));
        }
        elseif($request->type == 2){ //กำหนดสิทธื์
            return view('data_User.section-editUser.setPrivilege');
        }
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
