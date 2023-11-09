<?php

namespace App\Http\Controllers;


use App\Exports\exportCom3050;
use App\Exports\exportComFN;
use App\Exports\exportComPLM;
use App\Models\tbl_traceEmployee;
use App\Models\tbl_target;
use App\Models\tbl_staticcommission;
use App\Models\CK_Model\tbl_contract;
use App\Models\CK_Model\tbl_userck;
use Illuminate\Http\Request;

use App\Exports\exportCom;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use DB;


class ComController extends Controller
{
    private $SDueDate,$LDueDate;

    public function __construct() // วันดีล
    {
        $this->SDueDate = '2023-10-01';
        $this->LDueDate = '2023-10-31';
    }
    public function index(Request $request)
    {
        if($request->type == 1){
            $dataBranch = tbl_traceEmployee::where('IdCK','!=','')
            ->with(['EmptoCon' => function($query) {
                $query->WhereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"),[ $this->SDueDate,$this->LDueDate])
                ->where('UserZone',20)
                ->select('Date_monetary','BranchSent_Con','DataTag_id');
            }])
            ->get();

            return view('data_Commission.section-view.view',compact('dataBranch'));
        }
        elseif($request->type == 2){
            return view('data_Commission.section-dashboard.view-dashboard-Branch');
        }
    }


    public function store(Request $request)
    {
        if($request->type == 1){
             tbl_target::updateOrCreate([
                // 'id' => $request->id,
                // 'EmpId' => $request->id,
                'EmpName' => $request->EmpName,
            ],[
                'Target' => $request->Targets,
                // 'EmpId' => $request->id,

            ]);

            return 200;
        }
    }


    public function show(Request $request,$id)
    {
        if($request->type == 1){
            $dataBranch = tbl_traceEmployee::whereNotNULL('IdCK')
            ->with(['EmptoTarget' => function($query) {
                $query;
            }])
            ->with(['EmptoCon' => function($query) {
                $query->with(['ConToCal' => function($query) {
                    $query->select('Profit_Rate','DataTag_id','Cash_Car','Process_Car','Buy_PA','Include_PA','Insurance_PA','Process_Car','Process_Car','Tax2_Rate');
                }])
                ->WhereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"),[ $this->SDueDate,$this->LDueDate])
                ->orderBy('UserSent_Con','ASC')
                ->select('Contract_Con','Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con','UserSent_Con');
            }])
            ->get();

            $contract = tbl_contract::WhereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"),[ $this->SDueDate,$this->LDueDate])
            ->where('UserZone',20)
            ->with(['ConToCal' => function($query) {
                $query->select('DataTag_id','Cash_Car','Process_Car','Buy_PA','Include_PA','Insurance_PA','Process_Car','Process_Car','Tax2_Rate');
            }])
            ->select('Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con','Date_Checkers','UserSent_Con')
            ->orderBy('UserSent_Con','ASC')
            ->get();


            return response()->json([$dataBranch,$contract]);
        }

        elseif($request->type == 2){

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
        //
    }

    public function export()
    {
        return Excel::download(new exportComFN, 'รายงานค่าคอมมิชชั่นงานปล่อย.xlsx');
        // return Excel::download(new exportCom, 'รายงานค่าคอมมิชชั่นงานปล่อย.xlsx');
        //  return Excel::download(new exportComPLM, 'รายงานค่าคอมมิชชั่นPLM.xlsx');
        // return Excel::download(new exportCom3050, 'รายงานค่าคอมมิชชั่น30-50.xlsx');

    }


}
