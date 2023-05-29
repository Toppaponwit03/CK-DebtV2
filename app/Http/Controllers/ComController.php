<?php

namespace App\Http\Controllers;
use App\Models\tbl_traceEmployee;
use App\Models\tbl_target;

use App\Models\tbl_staticCom;
use App\Models\CK_Model\tbl_contract;
use Illuminate\Http\Request;

class ComController extends Controller
{
    private $SDueDate,$LDueDate;

    public function __construct() // วันดีล
    {
        $this->SDueDate = '2023-04-01';
        $this->LDueDate = '2023-04-30';
    }
    public function index(Request $request)
    {
        if($request->type == 1){
            $dataBranch = tbl_traceEmployee::where('IdCK','!=','')
            ->with(['EmptoCon' => function($query) { 
                $query->whereBetween('Date_monetary', [$this->SDueDate, $this->LDueDate])
                ->where('UserZone',20)
                ->select('Date_monetary','BranchSent_Con','DataTag_id');
            }])
            ->get();
 
            return view('data_Commission.section-view.view',compact('dataBranch'));
        }
        elseif($request->type == 2){
            return view('data_Commission.section-dashboard.view-dashboard');
        }
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        if($request->type == 1){
            $data = new tbl_target;
            $data->EmpId = $request->EmpId;
            $data->EmpName = $request->EmpName;
            $data->Target = $request->Targets;
            $data->save();
            return 200;
        }
    }


    public function show(Request $request,$id)
    {
        
        if($request->type == 1){
            $dataBranch = tbl_traceEmployee::where('IdCK','!=','')
            ->with(['EmptoTarget' => function($query) { 
                $query;
            }])
            ->get();
    
            $contract = tbl_contract::whereBetween('Date_monetary', [$this->SDueDate, $this->LDueDate])
            ->where('UserZone',20)
            ->with(['ConToCal' => function($query) { 
                $query->select('DataTag_id','Cash_Car','Process_Car','Buy_PA','Include_PA','Insurance_PA','Process_Car','Process_Car');
            }])
            ->select('Date_monetary','BranchSent_Con','DataTag_id')
            ->get();
    
            return response()->json([$dataBranch,$contract]);
        }
        elseif($request->type == 2){
            $dataBranch = tbl_traceEmployee::where('IdCK','!=','')
            ->with(['EmptoTarget' => function($query) { 
                $query;
            }])
            ->with(['EmptoCon' => function($query) { 
                $query->with(['ConToCal' => function($query) { 
                    $query->select('Profit_Rate','DataTag_id','Cash_Car','Process_Car','Buy_PA','Include_PA','Insurance_PA','Process_Car','Process_Car','Tax2_Rate');
                }])
                ->whereBetween('Date_monetary', [$this->SDueDate, $this->LDueDate])
                ->select('Contract_Con','Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con');
            }])
            ->get();

            $contract = tbl_contract::whereBetween('Date_monetary', [$this->SDueDate, $this->LDueDate])
            ->where('UserZone',20)
            ->with(['ConToCal' => function($query) { 
                $query->select('DataTag_id','Cash_Car','Process_Car','Buy_PA','Include_PA','Insurance_PA','Process_Car','Process_Car','Tax2_Rate');
            }])
            ->select('Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con','Date_Checkers')
            ->get();
    
            return response()->json([$dataBranch,$contract]);
        }
        elseif($request->type == 3){
            if($request->CodeLoan_Con == 04 || $request->CodeLoan_Con == 03){
                $totalInt = 0;
            }else{

                $totalInt = @$request->totalInt;
            }
           $data =  tbl_staticCom::where('TypeLoans',@$request->CodeLoan_Con)
            ->whereRaw('? between StotalInterest and TtotalInterest', [@$totalInt])
            ->whereRaw('? between SPercents and TPercents', [@$request->percent])
            ->where('Pa',@$request->checkPA)
            ->select('Commission','TypeLoans')
            ->first();

            return response()->json([$data,'Branch' => $request->employeeName]);
        }
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        if($request->type == 1){
            $data = tbl_target::where('EmpId',$request->EmpId)->first();
            if($data != null){
                $data->Target = @$request->Targets;
                $data->update();
            }
            else{
                $data = new tbl_target;
                $data->EmpId = $request->EmpId;
                $data->EmpName = $request->EmpName;
                $data->Target = $request->Targets;
                $data->save();
            }
            return 200;
        }
    }


}
