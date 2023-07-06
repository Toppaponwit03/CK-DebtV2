<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_user;
use App\Models\User;
use App\Models\tbl_privilege;
use App\Models\tbl_traceEmployee;
use Illuminate\Support\Facades\Hash;

class StaticController extends Controller
{

    public function index(Request $request)
    {
        if($request->type == 1){
            $users = tbl_user::get();
            return view('data_User.view',compact('users'));
          }
          elseif($request->type == 2){ // กำหนดสิทธื์
            $dataBranch = tbl_traceEmployee::getBranch();
            $teamAlists = tbl_traceEmployee::where('teamGroup','=','1')->get();
            $teamBlists = tbl_traceEmployee::where('teamGroup','=','2')->get();
            $teamClists = tbl_traceEmployee::where('teamGroup','=','3')->get();
            $dataUser = User::find($request->id);
            return view('data_User.ViewPrivilege',compact('dataBranch','teamAlists','teamBlists','teamClists','dataUser'));
          }
    }

    public function create(Request $request){
        if($request->func == 'addUser'){
        $dataBranch = tbl_traceEmployee::getBranch();
            return view('data_User.section-createUser.view',compact('dataBranch'));
        }
    }

    public function edit(Request $request,$id)
    {
        $user = tbl_user::find($id);
        $dataBranch = tbl_traceEmployee::getBranch();
        if($request->type == 1){ //แก้ไขข้อมูลผู้ใช้งาน
            return view('data_User.section-editUser.editUser',compact('user','dataBranch'));
        }
    }
    public function store(Request $request){
        if($request->func == 'createUser'){
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->password_val = $request->password;
            $user->Branch = $request->Branch;
            $user->position = $request->position;
            // dd($user);
            $user->save();
            
        }
    }

    public function update(Request $request, $id)
    {
       $check = tbl_privilege::where('user_id',$request->idUser)->first() ;
            if($check == NULL){
                $data  = new tbl_privilege;
            }else{
                $data  = tbl_privilege::where('user_id',$request->idUser)->first() ;
            }
        if($request->type==1){

            $data->user_id = $request->idUser;
            $data->branch = $request->emp;
            $data->save();
        }
        elseif($request->type==2){
            $data->user_id = @$request->idUser;
            $data->UpdatePay = @$request->UpdatePay;
            $data->datafilter = @$request->datafilter;
            $data->editstatus = @$request->editstatus;
            $data->imex = @$request->imex;
            $data->dataCus = @$request->dataCus;
            $data->dashboard = @$request->dashboard;
            $data->teamA = @$request->teamA;
            $data->teamB = @$request->teamB;
            $data->teamC = @$request->teamC;
            $data->createTag = @$request->CreateCustag;

            $data->ComSystem = @$request->ComSystem;
            $data->ViewTarget = @$request->ViewTarget;
            $data->ComBranch = @$request->ComBranch;
            $data->assignTarget = @$request->assignTarget;
            $data->exportComm = @$request->exportComm;
            $data->save();
        }
        elseif($request->func == 'editUser'){

                $user = User::find($request->userID);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->password_val = $request->password;
                $user->Branch = $request->Branch;
                $user->position = $request->position;
                // dd($user);
                $user->save();
                
            
        }
        elseif($request->func == 'removeUser'){
            $user = User::find($request->userID);
            $user->password = 'NULL';
            $user->save();
        }
    }

    public function destroy($id)
    {
        //
    }
}
