<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_user;
use App\Models\User;
use App\Models\tbl_groupdebt;
use App\Models\tbl_statustype;
use App\Models\tbl_privilege;
use App\Models\tbl_traceEmployee;
use Illuminate\Support\Facades\Hash;

class StaticController extends Controller
{

    public function index(Request $request)
    {
        $dataBranch = tbl_traceEmployee::getBranch();
        $groupDebt = tbl_groupdebt::getGroupdebt();
        $status = tbl_statustype::get();
        if($request->type == 1){
            $users = tbl_user::get();
            return view('data_User.view',compact('users','dataBranch','groupDebt','status'));
          }
          elseif($request->type == 2){ // กำหนดสิทธื์
            $dataBranch = tbl_traceEmployee::getBranch();
            $teamAlists = tbl_traceEmployee::where('teamGroup','=','1')->get();
            $teamBlists = tbl_traceEmployee::where('teamGroup','=','2')->get();
            $teamClists = tbl_traceEmployee::where('teamGroup','=','3')->get();
            $teamDlists = tbl_traceEmployee::where('teamGroup','=','4')->get();
            $dataUser = User::find($request->id);
            return view('data_User.ViewPrivilege',compact('dataBranch','teamAlists','teamBlists','teamClists','teamDlists','dataUser'));
          }
    }

    public function create(Request $request){
        if($request->func == 'addUser'){
        $dataBranch = tbl_traceEmployee::getBranch();
            return view('data_User.section-createUser.view',compact('dataBranch'));
        }
        elseif($request->func == 'addEmp'){
            return view('data-static.section-modal.create-employee');
        }
        elseif($request->func == 'addGroupdebt'){
            return view('data-static.section-modal.create-groupdebt');
        }
        elseif($request->func == 'addStatus'){
            return view('data-static.section-modal.create-status');
        }
    }

    public function edit(Request $request,$id)
    {

        
        if($request->type == 1){ //แก้ไขข้อมูลผู้ใช้งาน
            $user = tbl_user::find($id);
            $dataBranch = tbl_traceEmployee::getBranch();
            return view('data_User.section-editUser.editUser',compact('user','dataBranch'));
        }
        elseif($request->func == 'editEmp'){
            $data = tbl_traceEmployee::where('id',$id)->first();
            return view('data-static.section-modal.edit-employee',compact('data'));
        }
        elseif($request->func == 'editGroupdebt'){
            $data = tbl_groupdebt::find($id);
            return view('data-static.section-modal.edit-groupdebt',compact('data'));
        }
        elseif($request->func == 'editStatus'){
            $data = tbl_statustype::where('id',$id)->first();
            return view('data-static.section-modal.edit-status',compact('data'));
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
        elseif($request->func == 'createEmp'){ // เพิ่มสาขา
            $data = new tbl_traceEmployee;
            $data->employeeName = $request->nameEng;
            $data->nameThai = $request->nameTh;
            $data->Details = $request->detail;
            $data->IdCK = $request->IdCK;
            $data->teamGroup = $request->team;
            $data->save();

            $dataBranch = tbl_traceEmployee::getBranch();
            $html = view('data-static.section-append.data-employee',compact('dataBranch'))->render();
            return response()->json(['html' => $html]);
        }
        elseif($request->func == 'createGroupdebt'){ // เพิ่มกลุ่มค้างงวด
            $data = new tbl_groupdebt;
            $data->nameGroup = $request->nameGroup;
            $data->Groupdebt_Code = $request->Groupdebt_Code;
            $data->detail = $request->detail;
            $data->save();

            $groupDebt = tbl_groupdebt::getGroupdebt();
            $html = view('data-static.section-append.data-groupdebt',compact('groupDebt'))->render();
            return response()->json(['html' => $html]);
        }
        elseif($request->func == 'createStatus'){ // เพิ่มสถานะ
            $data = new tbl_statustype;
            $data->Status_code = $request->Status_code;
            $data->details = $request->details;
            $data->status = $request->status != NULL ?  $request->status : 'inactive' ;
            $data->save();

            $status = tbl_statustype::getstatus();
            $html = view('data-static.section-append.data-status',compact('status'))->render();
            return response()->json(['html' => $html]);
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
            $data->teamD = @$request->teamD;
            $data->createTag = @$request->CreateCustag;

            $data->ComSystem = @$request->ComSystem;
            $data->ViewTarget = @$request->ViewTarget;
            $data->ComBranch = @$request->ComBranch;
            $data->assignTarget = @$request->assignTarget;
            $data->exportComm = @$request->exportComm;
            $data->save();
        }
        elseif($request->func == 'editUser'){ //แก้ไข User

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
        elseif($request->func == 'removeUser'){ // ลบ user
            $user = User::find($request->userID);
            $user->password = 'NULL';
            $user->save();
        }
        elseif($request->func == 'updateEmp'){ // แก้ไขสาขา
            $dataEmp = tbl_traceEmployee::where('id',$request->id)->first();
            $dataEmp->employeeName = $request->nameEng;
            $dataEmp->nameThai = $request->nameTh;
            $dataEmp->Details = $request->detail;
            $dataEmp->IdCK = $request->IdCK;
            // $dataEmp->IdCK_UserSent = @$request->IdCK_UserSent;
            $dataEmp->teamGroup = $request->team;
            $dataEmp->save();

            $dataBranch = tbl_traceEmployee::getBranch();
            $html = view('data-static.section-append.data-employee',compact('dataBranch'))->render();
            return response()->json(['html' => $html]);
        }
        elseif($request->func == 'updateGroupdebt'){ // แก้ไขกลุ่มค้างงวด
            $data = tbl_groupdebt::find($request->id);
            $data->nameGroup = $request->nameGroup;
            $data->Groupdebt_Code = $request->Groupdebt_Code;
            $data->detail = $request->detail;
            $data->save();

            $groupDebt = tbl_groupdebt::getGroupdebt();
            $html = view('data-static.section-append.data-groupdebt',compact('groupDebt'))->render();
            return response()->json(['html' => $html]);
        }
        elseif($request->func == 'updateStatus'){ // แก้ไขสถานะ
            $data = tbl_statustype::where('id',$request->id)->first();
            $data->Status_code = $request->Status_code;
            $data->details = $request->details;
            $data->status = $request->status != NULL ?  $request->status : 'inactive' ;
            $data->save();

            $status = tbl_statustype::getstatus();
            $html = view('data-static.section-append.data-status',compact('status'))->render();
            return response()->json(['html' => $html]);
        }
    }

    public function destroy($id)
    {
        //
    }
}
