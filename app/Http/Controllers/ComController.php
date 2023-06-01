<?php

namespace App\Http\Controllers;
use App\Models\tbl_traceEmployee;
use App\Models\tbl_target;
use App\Models\tbl_staticcommission;
use App\Models\CK_Model\tbl_contract;
use Illuminate\Http\Request;
use DB;


class ComController extends Controller
{
    private $SDueDate,$LDueDate;

    public function __construct() // วันดีล
    {
        $this->SDueDate = '2023-05-01';
        $this->LDueDate = '2023-05-31';
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
            $dataBranch = tbl_traceEmployee::where('IdCK','!=','')
            ->with(['EmptoCon' => function($query) { 
                $query->whereBetween('Date_monetary', [$this->SDueDate, $this->LDueDate])
                ->where('UserZone',20)
                ->with(['ConToCal' => function($query) { 
                    $query->select('Cash_Car');
                }])
                ->select('Date_monetary','BranchSent_Con','DataTag_id','Contract_Con');
            }])
            ->get();
            return view('data_Commission.section-dashboard.view-dashboard',compact('dataBranch'));
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
                ->orderBy('UserSent_Con','ASC')
                ->select('Contract_Con','Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con','UserSent_Con');
            }])
            ->get();

            $contract = tbl_contract::whereBetween('Date_monetary', [$this->SDueDate, $this->LDueDate])
            ->where('UserZone',20)
            ->with(['ConToCal' => function($query) { 
                $query->select('DataTag_id','Cash_Car','Process_Car','Buy_PA','Include_PA','Insurance_PA','Process_Car','Process_Car','Tax2_Rate');
            }])
            ->select('Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con','Date_Checkers','UserSent_Con')
            ->orderBy('UserSent_Con','ASC')
            ->get();


            $query = DB::connection('ck')->select("select a.BranchSent_Con, a.UserSent_Con,
            sum(case when a.CodeLoan_Con = '01' and b.Buy_PA ='Yes' then 1 else 0 end )  as YPA01,
            sum(case when a.CodeLoan_Con = '01' and (b.Buy_PA ='NO' OR b.Buy_PA is null) then 1 else 0 end )  as NPA01,
            sum(case when a.CodeLoan_Con = '02' and b.Buy_PA ='Yes' then 1 else 0 end )  as YPA02,
            sum(case when a.CodeLoan_Con = '02' and (b.Buy_PA ='NO' OR b.Buy_PA is null) then 1 else 0 end )  as NPA02,
            sum(case when a.CodeLoan_Con = '03' and b.Buy_PA ='Yes' then 1 else 0 end )  as YPA03,
            sum(case when a.CodeLoan_Con = '03' and (b.Buy_PA ='NO' OR b.Buy_PA is null) then 1 else 0 end )  as NPA03,
            sum(case when a.CodeLoan_Con = '04' and b.Buy_PA ='Yes' then 1 else 0 end )  as YPA04,
            sum(case when a.CodeLoan_Con = '04' and (b.Buy_PA ='NO' OR b.Buy_PA is null) then 1 else 0 end )  as NPA04,
            sum(case when a.CodeLoan_Con = '05' and b.Buy_PA ='Yes' then 1 else 0 end )  as YPA05,
            sum(case when a.CodeLoan_Con = '05' and (b.Buy_PA ='NO' OR b.Buy_PA is null) then 1 else 0 end )  as NPA05,
            sum(case when a.CodeLoan_Con = '06' and b.Buy_PA ='Yes' then 1 else 0 end )  as YPA06,
            sum(case when a.CodeLoan_Con = '06' and (b.Buy_PA ='NO' OR b.Buy_PA is null) then 1 else 0 end )  as NPA06,
            sum(case when a.CodeLoan_Con = '07' and b.Buy_PA ='Yes' then 1 else 0 end )  as YPA07,
            sum(case when a.CodeLoan_Con = '07' and (b.Buy_PA ='NO' OR b.Buy_PA is null) then 1 else 0 end )  as NPA07,
        
            sum(b.Profit_Rate-b.Tax2_Rate),
        
            sum (case when b.Include_PA = 'Yes' and b.Buy_PA = 'Yes' then b.Cash_Car+b.Process_Car+b.Insurance_PA else b.Cash_Car+b.Process_Car end)
            
          from Pact_Contracts a
          left join Data_CusTagCalculates b on a.DataTag_id = b.DataTag_id
          where a.UserZone = 20 and a.Date_monetary between '2023-04-01' and '2023-04-30' group by a.BranchSent_Con , a.UserSent_Con");

            return response()->json([$dataBranch,$contract,$query]);
        }
        elseif($request->type == 3){
                
            if($request->CodeLoan_Con == 04 || $request->CodeLoan_Con == 03){
                $totalInt = 0;
            }else{

                $totalInt = @$request->totalInt;
            }

            if(@$request->checkPA =='Yes'){
                $pa = 'YPA';
            }else{
                $pa = 'NPA';
            }

       
           $data =  tbl_staticcommission::where('TypeLoans',$request->CodeLoan_Con)
            ->whereRaw('? between StotalInterest and TtotalInterest', $totalInt)
            ->selectRaw('case when '.$request->percent.' < 80 then '.$pa.'70  
            when '.$request->percent.' < 100 then '.$pa.'80  
            when '.$request->percent.' < 120 then '.$pa.'100  
            else  '.$pa.'120 end as Commission, TypeLoans,Gas')
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
