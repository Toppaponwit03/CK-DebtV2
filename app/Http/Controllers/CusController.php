<?php

namespace App\Http\Controllers;
use Auth;
use App\datethai\thaidate;
use Illuminate\Http\Request;
use App\Models\tbl_customer;
use App\Models\tbl_groupdebt;
use App\Models\tbl_statustype;
use App\Models\tbl_traceEmployee;
use App\Models\tbl_custag;
use App\Models\tbl_actionplan;
use App\Models\tbl_non;
use App\Models\tbl_user;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DB;
use Datatables;

use App\Imports\UsersImport;
use App\Exports\exportDataCustomers;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;


class CusController extends Controller
{
    public static function getTB($query)
    {
      $dataTB = $query;
      return   Datatables()->of($dataTB)
                ->addIndexColumn()
                ->addColumn('btnStaus', function ($data) {
                  $btnStat = '<button type="button" id="SearchBtn" class="btn btn-warning rounded-circle" data-bs-toggle="modal" data-bs-target="#modal-xl" data-link="'. route("Cus.edit",$data->id) .'?type=1 "><i class="fa-regular fa-pen-to-square"></i> </button>';
                  return $btnStat;
                })
                ->addColumn('statusname', function ($data) {
                  return $data->CustoStatus->details;
                })
                ->addColumn('fullname', function ($data) {
                  return $data->firstname.' '.$data->lastname;
                })
                ->addColumn('dealDayTH', function ($data) {
                  return thaidate::simpleDateFormat($data->dealDay);
                })
                ->addColumn('paymentDateTH', function ($data) {
                  return (@$data->paymentDate != NULL) ? thaidate::simpleDateFormat(@$data->paymentDate) : '-';
                })
                ->addColumn('fieldDayTH', function ($data) {
                  return (@$data->fieldDay != NULL) ? thaidate::simpleDateFormat($data->fieldDay) : '-';
                })
                ->addColumn('powerAppTH', function ($data) {
                  return (@$data->powerApp != NULL) ? thaidate::simpleDateFormat($data->powerApp) : '-';
                })
                ->addColumn('lastPaymentdateTH', function ($data) {
                  return thaidate::simpleDateFormat($data->lastPaymentdate);
                })
                ->addColumn('FollowingDate', function ($data) {
                  return (@$data->FollowingDate != NULL) ? thaidate::simpleDateFormat($data->FollowingDate) : '-';
                })
                ->addColumn('copyCon', function ($data) {
                  $btnHtml = '<button onclick="myFunction('."'".$data->contractNumber."'".')" class="btn btn-light" style="border-radius: 50px;  background: linear-gradient(180deg, #F2AEB7 0%, #FDE8D4 100%); color: #34495e;font-size:0.87rem;">'.$data->contractNumber.'</button><div style="display:none;"><input type="text" value="'.$data->contractNumber.'" id="'.$data->contractNumber.'"></div>' ;
                  return $btnHtml;
                })
                ->rawColumns(['copyCon','btnStaus'])
                ->make(true);
    }

    public function index(Request $request)
    {
      $positionUser = Auth::user()->position;
      $groupDebt = tbl_groupdebt::getGroupdebt();
      $statuslist = tbl_statustype::getstatus();
      $non = tbl_non::getNon();
      $dataBranch = tbl_traceEmployee::getBranch();

      $teamAlists = tbl_traceEmployee::where('teamGroup','=','1')->get();
      $teamBlists = tbl_traceEmployee::where('teamGroup','=','2')->get();
      $teamClists = tbl_traceEmployee::where('teamGroup','=','3')->get();
      $type = $request->get('type');

      $countPass = DB::select("SELECT 
      traceEmployee,
      sum(CASE WHEN`traceEmployee` != '' THEN 1 ELSE 0  END ) as totalEmp,
      sum(CASE WHEN`traceEmployee` != '' and `typeLoan` = '1'  THEN 1 ELSE 0  END ) as totalEmpPLM,
      sum(CASE WHEN`traceEmployee` != '' and `typeLoan` = '2'  THEN 1 ELSE 0  END ) as totalEmpCKM,
      sum(CASE WHEN`status` = 'STS-005' THEN 1 ELSE 0  END ) as totalPass,
      sum(CASE WHEN`typeLoan` = '1' and `status` = 'STS-005' THEN 1 ELSE 0  END ) as totalPassPLM,
      sum(CASE WHEN`typeLoan` = '2' and `status` = 'STS-005' THEN 1 ELSE 0  END ) as totalPassCKM
      FROM `tbl_customers` GROUP BY traceEmployee");


       return view('data_Customer.view', compact('positionUser','groupDebt','statuslist','non','dataBranch','teamAlists','teamBlists' ,'teamClists','countPass'));
      

  
    }
    public function getData(Request $request){
      $BranchList = Auth::user()->UserToPrivilege->branch;
      if($request->type == 1){ // ดึงข้อมูล
        
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->orderBy('dealDay', 'ASC')->get();

    
        return static::getTB($customers);
      }
      elseif($request->type == 2){
        $customers = tbl_customer::where('traceEmployee',$request->branch)
        ->orderBy('dealDay', 'ASC')->get();

        return static::getTB($customers);
      }
      elseif($request->type == 3){
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->when($request->input('traceEmployee'), function ($query, $traceEmployee) {
          return $query->whereIn('traceEmployee',$traceEmployee);
        })
        ->when($request->input('searchstatus'), function ($query, $status) {
          return $query->whereIn('status', $status);
        })
        ->when($request->input('groupDebt'), function ($query, $groupDebt) {
          return $query->whereIn('groupDebt', $groupDebt);
        })
        ->when($request->input('typeLoan'), function ($query, $typeLoan) {
          return $query->whereIn('typeLoan', $typeLoan);
        })
        ->when($request->input('Branch'), function ($query, $Branch) {
          return $query->whereIn('Branch', $Branch);
        })
        
        ->orderBy('dealDay', 'ASC')->get();  
          return static::getTB($customers);

         
      }
      elseif($request->type == 4){
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->whereIn('groupDebt',['4.Past 2','5.Past 3'])
        ->where('typeLoan',1)
        ->orderBy('dealDay', 'ASC')->get();

        return static::getTB($customers);
      }
      elseif($request->type == 5){ //ส่งหัวหน้า PLM
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->whereIn('status',['STS-009','STS-008'])
        ->where('typeLoan',1)
        ->orderBy('dealDay', 'ASC')->get();

        return static::getTB($customers);
      }
      elseif($request->type == 6){
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->whereIn('status',['STS-009','STS-008'])
        ->where('typeLoan',2)
        ->orderBy('dealDay', 'ASC')->get();

        return static::getTB($customers);
      }
      elseif($request->type == 7){ // วันชำระวันนี้
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->where('status','=','STS-001')
        ->whereIn('traceEmployee',explode(",",$BranchList))
        ->where('paymentDate','=',Carbon::today()->format('Y-m-d'))
        ->orderBy('dealDay', 'ASC')->get();
        return static::getTB($customers);
      }
      elseif($request->type == 8){ // ดีลวันนี้
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->where('status','!=','STS-005')
        ->whereIn('traceEmployee',explode(",",$BranchList))
        ->where('dealDay','=',Carbon::today()->format('Y-m-d'))
        ->orderBy('dealDay', 'ASC')->get();
        return static::getTB($customers);
      }
      elseif($request->type == 9){ // ดีลเมื่อวาน
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->where('status','!=','STS-005')
        ->whereIn('traceEmployee',explode(",",$BranchList))
        ->where('dealDay','=',Carbon::yesterday()->format('Y-m-d'))
        ->orderBy('dealDay', 'ASC')->get();
        return static::getTB($customers);
      }
      elseif($request->type == 10){ // ติดตามวันนี้
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->where('status','!=','STS-005')
        ->whereIn('traceEmployee',explode(",",$BranchList))
        ->where('FollowingDate','=',Carbon::today()->format('Y-m-d'))
        ->orderBy('FollowingDate', 'ASC')->get();
        return static::getTB($customers);
      }

    }
    public function create(Request $request)
    {
      if($request->type == 1){
        return view('data_Customer.section-ManageData.view');
      }
      elseif($request->type == 2){
        return view('data_Customer.section-permissions.view');
      }
    }

    public function store(Request $request)
    {
      if($request->type == 1){  //เพิ่มการติดตาม
        $data_Tag = new tbl_custag;
        $data_Tag->ContractID = $request->contractNumber;
        $data_Tag->date_Tag = date('Y-m-d');
        $data_Tag->detail = $request->note;
        $data_Tag->payment_date = $request->payment_date;
        $data_Tag->visitArea_date = $request->visitArea_date;
        $data_Tag->PowerApp_date = $request->PowerApp_date;
        $data_Tag->Following_Date = $request->Following_date;
        $data_Tag->userInsert = Auth::user()->id;
        $data_Tag->save();


        $data_cus = tbl_customer::where('contractNumber',$request->contractNumber)->first();
        $data_cus->paymentDate = $request->payment_date;
        $data_cus->fieldDay = $request->visitArea_date;
        $data_cus->powerApp = $request->PowerApp_date;
        $data_cus->FollowingDate = $request->Following_date;
        $data_cus->update();


        $data = tbl_customer::where('contractNumber',$request->contractNumber)->first();
        return response()->view('data_Customer.section-Cus.ShowCusDetails',compact('data'));
      }
      elseif($request->type == 2){  //เพิ่ม action plan
        $data_plan = new tbl_actionplan;

        $data_plan->tag_id = $request->tag_id;
        $data_plan->date_plan = date('Y-m-d');
        $data_plan->ContractID = $request->ContractID;
        $data_plan->detail = $request->addaction;
        $data_plan->userInsert = Auth::user()->id;
        $data_plan->userInsertname = Auth::user()->name;
        $data_plan->save();

        $data = tbl_actionplan::where('tag_id', $request->tag_id)->orderBy('created_At', 'desc')->first();
        return response()->json($data);
      }

    }

    public function show(Request $request, $id)
    {
      if($request->type == 1){ // โชว์โหลดตอนกดอัพเดทการจ่ายเงิน
        return view('data_Customer.section-onload.load-updateTotalPay');
      }
    }

    public function edit(Request $request,$id)
    {
      if($request->type == 1){

        $subdate = date('Y-m-d',strtotime("-2 months")) ;
        $datenow = date('Y-m-d');
        $statuslist = tbl_statustype::getstatus();
        $data = tbl_customer::find($id);
        $contract = $data->contractNumber;

        $datapay = DB::connection('ibmi2')->select("
          SELECT 
          RSFHP.CHQTRAN.LOCATRECV,
          RSFHP.CHQTRAN.TMBILDT,
          RSFHP.CHQTRAN.TMBILL,
          RSFHP.CHQTRAN.PAYFOR,
          RSFHP.CHQTRAN.PAYTYP,
          RSFHP.CHQTRAN.PAYAMT,
          RSFHP.CHQTRAN.PAYINT,
          RSFHP.CHQTRAN.DSCINT,
          RSFHP.CHQTRAN.NETPAY
          FROM RSFHP.ARMAST 
          LEFT JOIN RSFHP.CHQTRAN  ON RSFHP.CHQTRAN.CONTNO = RSFHP.ARMAST.CONTNO
          WHERE RSFHP.ARMAST.CONTNO = '${contract}'  
          UNION
          SELECT 
          PSFHP.CHQTRAN.LOCATRECV,
          PSFHP.CHQTRAN.TMBILDT,
          PSFHP.CHQTRAN.TMBILL,
          PSFHP.CHQTRAN.PAYFOR,
          PSFHP.CHQTRAN.PAYTYP,
          PSFHP.CHQTRAN.PAYAMT,
          PSFHP.CHQTRAN.PAYINT,
          PSFHP.CHQTRAN.DSCINT,
          PSFHP.CHQTRAN.NETPAY
          FROM PSFHP.ARMAST 
          LEFT JOIN PSFHP.CHQTRAN  ON PSFHP.CHQTRAN.CONTNO = PSFHP.ARMAST.CONTNO
          WHERE PSFHP.ARMAST.CONTNO = '${contract}' ORDER BY TMBILDT DESC
        ");

        return view('data_Customer.section-Cus.viewModal',compact('data','statuslist','datapay'));
      }
    }

    public function update(Request $request, $id)
    {

      if($request->type == 1){ //อัพเดทสถานะ
        $data_status = tbl_customer::where('contractNumber',$request->contractNumber)->first();
        $data_status->status = $request->statuschecks;
        $data_status->update();

        $data = tbl_customer::where('contractNumber',$request->contractNumber)->first();
        $statuslist = tbl_statustype::getstatus();
        return response()->view('data_Customer.section-Cus.CardCusDetail',compact('data','statuslist'));
      }
      else if($request->type == 2){ // อัพเดทการจ่าย

        $subdate = substr(date('Y-m-d',strtotime("-1 months")), 0, 7) ;
        $datenow = date('Y-m-d');
          
        //
        // $dataPay = DB::connection('ibmi2')->select("SELECT OD.CONTNO,  CalQ.TOTALP, OD.TOTALC,OD.TMBILDT ,OD.PAYFOR ,OD.DEBT_BALANCE FROM
        // (select DISTINCT PSFHP.ARMAST.CONTNO,
        // PSFHP.CHQTRAN.TMBILDT ,
        // PSFHP.ARMAST.NPROFIT as TOTALC,
        // PSFHP.CHQTRAN.PAYFOR,
        // PSFHP.CHQTRAN.DEBT_BALANCE
        // from PSFHP.ARMAST 
        // left join PSFHP.CHQTRAN on PSFHP.CHQTRAN.CONTNO = PSFHP.ARMAST.CONTNO  
        // where PSFHP.CHQTRAN.TMBILDT < '${datenow}'   
        // ORDER BY PSFHP.CHQTRAN.TMBILDT DESC ) OD 
        // INNER JOIN (select PSFHP.ARMAST.CONTNO,  SUM(PSFHP.CHQTRAN.PAYAMT) as TOTALP from PSFHP.ARMAST  
        // left join PSFHP.CHQTRAN on PSFHP.CHQTRAN.CONTNO = PSFHP.ARMAST.CONTNO 
        // where PSFHP.CHQTRAN.TMBILDT > '${subdate}-07' and PSFHP.CHQTRAN.FLAG <> 'C'  
        // group BY PSFHP.ARMAST.CONTNO ) CalQ  ON CalQ.CONTNO = OD.CONTNO 
        // ORDER BY OD.TMBILDT ASC ");

        // ประกาศตัวแปร วีนดีล เริ่ม สิ้นสุด s 07/05/2023 e 06/06/2023

        $dateStart = '2023-05-07'; // วันดีลเริ่มต้น
        $dateEnd = '2023-06-06'; // วันสิ้นสุด

        $dataPay = DB::connection('ibmi2')->select("SELECT OD.CONTNO,  CalQ.TOTALP, OD.TOTALC,OD.TMBILDT ,OD.PAYFOR ,OD.DEBT_BALANCE FROM
        (select DISTINCT PSFHP.ARMAST.CONTNO,
        PSFHP.CHQTRAN.TMBILDT ,
        PSFHP.ARMAST.NPROFIT as TOTALC,
        PSFHP.CHQTRAN.PAYFOR,
        PSFHP.CHQTRAN.DEBT_BALANCE
        from PSFHP.ARMAST 
        left join PSFHP.CHQTRAN on PSFHP.CHQTRAN.CONTNO = PSFHP.ARMAST.CONTNO  
        where PSFHP.CHQTRAN.TMBILDT <= '${dateEnd}' AND PSFHP.CHQTRAN.TMBILDT >= '${dateStart}'
        ORDER BY PSFHP.CHQTRAN.TMBILDT DESC ) OD 
        INNER JOIN (select PSFHP.ARMAST.CONTNO,  SUM(PSFHP.CHQTRAN.PAYAMT) as TOTALP from PSFHP.ARMAST  
        left join PSFHP.CHQTRAN on PSFHP.CHQTRAN.CONTNO = PSFHP.ARMAST.CONTNO 
        where PSFHP.CHQTRAN.TMBILDT >= '${dateStart}' and PSFHP.CHQTRAN.FLAG <> 'C'  
        group BY PSFHP.ARMAST.CONTNO ) CalQ  ON CalQ.CONTNO = OD.CONTNO 
        UNION
        SELECT OD.CONTNO,  CalQ.TOTALP, OD.TOTALC,OD.TMBILDT ,OD.PAYFOR ,OD.DEBT_BALANCE FROM
        (select DISTINCT RSFHP.ARMAST.CONTNO,
        RSFHP.CHQTRAN.TMBILDT ,
        RSFHP.ARMAST.NPROFIT as TOTALC,
        RSFHP.CHQTRAN.PAYFOR,
        RSFHP.CHQTRAN.DEBT_BALANCE
        from RSFHP.ARMAST 
        left join RSFHP.CHQTRAN on RSFHP.CHQTRAN.CONTNO = RSFHP.ARMAST.CONTNO  
        where RSFHP.CHQTRAN.TMBILDT <= '${dateEnd}' AND RSFHP.CHQTRAN.TMBILDT >= '${dateStart}'  
        ORDER BY RSFHP.CHQTRAN.TMBILDT DESC ) OD 
        INNER JOIN (select RSFHP.ARMAST.CONTNO,  SUM(RSFHP.CHQTRAN.PAYAMT) as TOTALP from RSFHP.ARMAST  
        left join RSFHP.CHQTRAN on RSFHP.CHQTRAN.CONTNO = RSFHP.ARMAST.CONTNO 
        where RSFHP.CHQTRAN.TMBILDT >= '${dateStart}' and RSFHP.CHQTRAN.FLAG <> 'C'  
        group BY RSFHP.ARMAST.CONTNO ) CalQ  ON CalQ.CONTNO = OD.CONTNO ");

        foreach ($dataPay as $key => $value){
          tbl_customer::where('contractNumber',trim($value->CONTNO))
          ->update([
              'TotalPay' => $value->TOTALP,
              'balanceDebt' => $value->DEBT_BALANCE,
              'lastPaymentdate' => $value->TMBILDT,
          ]);
        }

        tbl_customer::whereRaw('TotalPay >= minimumPayout')
        ->orWhereRaw("CAST( replace(arrears,',','') as float) = 0")
        ->orWhereRaw("CAST( replace(arrears,',','') as float) < minimumPayout  and TotalPay >= CAST( replace(arrears,',','') as float)")
        ->where('status','!=','STS-005')
        ->update([
          'status' => 'STS-005',
          'flag' => 'yes'
        ]);
        return 200;
      }
      else if($request->type == 3){  //อัพเดทการติดตาม
        $data_Tag = tbl_custag::where('id',$request->tag_id)->first();
        $name = $request->note[$request->tag_id];
        $data_Tag->ContractID = $request->contractNumber;
        $data_Tag->date_Tag = date('Y-m-d');
        $data_Tag->detail = $name;
        $data_Tag->payment_date = $request->payment_date;
        $data_Tag->visitArea_date = $request->visitArea_date;
        $data_Tag->PowerApp_date = $request->PowerApp_date;
        $data_Tag->Following_Date = $request->Following_date;
        $data_Tag->userInsert = Auth::user()->id;
        $data_Tag->update();

        $data_cus = tbl_customer::where('contractNumber',$request->contractNumber)->first();
        $data_cus->paymentDate = $request->payment_date;
        $data_cus->fieldDay = $request->visitArea_date;
        $data_cus->powerApp = $request->PowerApp_date;
        $data_cus->FollowingDate = $request->Following_date;
        $data_cus->update();

        $data = tbl_customer::where('contractNumber',$request->contractNumber)->first();
        return response()->view('data_Customer.section-Cus.ShowCusDetails',compact('data'));

      }


    }

    public function dashboard(Request $request)
    {
      $column = $request->get('typeloan');

      if($column == NULL){
        $column = 1;
      }
      else{
        $column = $request->get('typeloan');
      }

      if(Auth::user()->position == 'admin' || Auth::user()->position == 'audit' ){
        $head = $request->get('tablehead') ;
        if($head == NULL){
          $head  = 1;
        }else{
          $head = $request->get('tablehead') ;
        }
      }
      elseif(Auth::user()->position == 'headA'){
        $head = 1 ;
      }
      elseif(Auth::user()->position == 'headB'){
        $head = 2 ;
      }
      else{
        $head = Auth::user()->Branch ;
      }

        if(Auth::user()->position == 'user'){
          $data = DB::select("
          SELECT 
            traceEmployee,typeLoan,
            SUM(CASE WHEN groupDebt = '1.Befor'  THEN 1 ELSE 0 END) as 'totalBefor',
            SUM(CASE WHEN groupDebt = '1.Befor' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassBefor',
  
            SUM(CASE WHEN groupDebt = '2.Nomal'  THEN 1 ELSE 0 END) as 'totalNomal',
            SUM(CASE WHEN groupDebt = '2.Nomal' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassNomal',
  
            SUM(CASE WHEN groupDebt = '3.Past 1'  THEN 1 ELSE 0 END) as 'totalPast1',
            SUM(CASE WHEN groupDebt = '3.Past 1' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassPast1',
  
            SUM(CASE WHEN groupDebt = '4.Past 2'  THEN 1 ELSE 0 END) as 'totalPast2',
            SUM(CASE WHEN groupDebt = '4.Past 2' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassPast2',
  
            SUM(CASE WHEN groupDebt = '5.Past 3'  THEN 1 ELSE 0 END) as 'totalPast3',
            SUM(CASE WHEN groupDebt = '5.Past 3' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassPast3'
  
            FROM tbl_customers WHERE`typeLoan` = '".$column."' and traceEmployee = '".$head."' group by traceEmployee  ;
        ");
        }
        else {
          $data = DB::select("
            SELECT 
              traceEmployee,typeLoan,
              SUM(CASE WHEN groupDebt = '1.Befor'  THEN 1 ELSE 0 END) as 'totalBefor',
              SUM(CASE WHEN groupDebt = '1.Befor' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassBefor',
    
              SUM(CASE WHEN groupDebt = '2.Nomal'  THEN 1 ELSE 0 END) as 'totalNomal',
              SUM(CASE WHEN groupDebt = '2.Nomal' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassNomal',
    
              SUM(CASE WHEN groupDebt = '3.Past 1'  THEN 1 ELSE 0 END) as 'totalPast1',
              SUM(CASE WHEN groupDebt = '3.Past 1' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassPast1',
    
              SUM(CASE WHEN groupDebt = '4.Past 2'  THEN 1 ELSE 0 END) as 'totalPast2',
              SUM(CASE WHEN groupDebt = '4.Past 2' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassPast2',
    
              SUM(CASE WHEN groupDebt = '5.Past 3'  THEN 1 ELSE 0 END) as 'totalPast3',
              SUM(CASE WHEN groupDebt = '5.Past 3' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassPast3'
    
              FROM tbl_customers WHERE`typeLoan` = '".$column."' and TeamGroup = '".$head."' group by traceEmployee  ;
          ");
        }

    return view('data_Customer.section-dashboard.view',compact('data','head','column'));

    }

    public function export() 
    {

       return Excel::download(new exportDataCustomers, 'รายงานทีมติดตามหนี้.xlsx');
    }
    public function import() 
    {
        Excel::import(new UsersImport,request()->file('file'));
               
        return response()->json(['success' => true]);
    }
}
