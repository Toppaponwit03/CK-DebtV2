<?php

namespace App\Http\Controllers;
use App\Events\DataLogStatus;
use App\Events\MessageChat;
use App\Models\tbl_appointment;
use App\Models\tbl_DataLogStatus;
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
use App\Models\tbl_historydashboard;
use App\Models\tbl_duedate;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DB;
use Datatables;

use App\Exports\exportSFHP;
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

                  if (Auth::user()->UserToPrivilege->EditDataDebt == 'yes'){
                    $btnStat = '
                    <button type="button" id="SearchBtn" class="btn btn-warning rounded-circle btn-sm" data-bs-toggle="modal" data-bs-target="#modal-fullscreen" data-link="'. route("Cus.edit",$data->id) .'?type=1 "><i class="fa-regular fa-pen-to-square"></i> </button>
                    <button type="button" id="SearchBtn" class="btn btn-secondary rounded-circle btn-sm" data-bs-toggle="modal" data-bs-target="#modal-xl" data-link="'. route("Cus.edit",$data->id) .'?type=2 "><i class="fa-solid fa-user-pen"></i> </button>
                    ';
                  } else{
                    $btnStat = '
                    <button type="button" id="SearchBtn" class="btn btn-warning rounded-circle btn-sm" data-bs-toggle="modal" data-bs-target="#modal-xl" data-link="'. route("Cus.edit",$data->id) .'?type=1 "><i class="fa-regular fa-pen-to-square"></i> </button>
                    ';
                  }
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
                  $today = Carbon::now();
                  $dataDate = Carbon::parse($data->paymentDate);
                  $thaidate = (@$data->paymentDate != NULL) ? thaidate::simpleDateFormat($data->paymentDate) : '-';

                  if(@$data->paymentDate != NULL){
                    if(@$today > @$dataDate && @$data->CustoStatus->details != 'ผ่าน'){
                      $tagHtml = '<div class="" title="เลยวันชำระ"  style="border-radius: 50px; background:   linear-gradient(90deg, rgba(255,238,159,1) 0%, rgba(255,241,106,1) 18%, rgba(255,243,0,1) 100%); color: #34495e;font-size:0.87rem;" ">
                      <div >
                      <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                      <lord-icon
                          src="https://cdn.lordicon.com/wdqztrtx.json"
                          trigger="loop"
                          colors="primary:#121331"
                          style="width:20px;height:20px">
                      </lord-icon>
                      </div> ' .$thaidate.'
                      </div> <span class="badge rounded-pill text-bg-warning bg-opacity-50 text-dark">จำนวนผิดนัด :</span>';
                    }else {
                      $tagHtml = '<div> '.$thaidate.' </div> <span class="badge rounded-pill text-bg-warning bg-opacity-50 text-dark">จำนวนผิดนัด : </span>' ;
                    }
                  }else{
                    $tagHtml = '<div> '.$thaidate.' </div> <span class="badge rounded-pill text-bg-warning bg-opacity-50 text-dark">จำนวนผิดนัด : </span>' ;
                  }

                  return $tagHtml;
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
                ->rawColumns(['paymentDateTH','copyCon','btnStaus'])
                ->make(true);
    }

    public function index(Request $request)
    {
      $getdue = tbl_duedate::getDuedate();
      $positionUser = Auth::user()->position;
      $groupDebt = tbl_groupdebt::getGroupdebt();
      $statuslist = tbl_statustype::getstatus();
      $non = tbl_non::getNon();
      $dataBranch = tbl_traceEmployee::getBranch();
      $BranchList = Auth::user()->UserToPrivilege->branch;
      $teamAlists = tbl_traceEmployee::where('teamGroup','=','1')->get();
      $teamBlists = tbl_traceEmployee::where('teamGroup','=','2')->get();
      $teamClists = tbl_traceEmployee::where('teamGroup','=','3')->get();
      $teamDlists = tbl_traceEmployee::where('teamGroup','=','4')->get();
      $BranchWork = tbl_traceEmployee::whereIn('employeeName',explode(",",$BranchList))->get();
      $type = $request->get('type');

      $countPass = DB::select("SELECT
      traceEmployee,
      sum(CASE WHEN traceEmployee != '' THEN 1 ELSE 0  END ) as totalEmp,
      sum(CASE WHEN traceEmployee != '' and typeLoan = '1'  THEN 1 ELSE 0  END ) as totalEmpPLM,
      sum(CASE WHEN traceEmployee != '' and typeLoan = '2'  THEN 1 ELSE 0  END ) as totalEmpCKM,
      sum(CASE WHEN traceEmployee != '' and typeLoan = '3'  THEN 1 ELSE 0  END ) as totalEmpLoan,
      sum(CASE WHEN traceEmployee != '' and typeLoan = '4'  THEN 1 ELSE 0  END ) as totalEmp12More,
      sum(CASE WHEN traceEmployee != '' and typeLoan = '5'  THEN 1 ELSE 0  END ) as totalEmpMiss,
      sum(CASE WHEN status = 'STS-005' THEN 1 ELSE 0  END ) as totalPass,
      sum(CASE WHEN typeLoan = '1' and status = 'STS-005' THEN 1 ELSE 0  END ) as totalPassPLM,
      sum(CASE WHEN typeLoan = '2' and status = 'STS-005' THEN 1 ELSE 0  END ) as totalPassCKM,
      sum(CASE WHEN typeLoan = '3' and status = 'STS-005' THEN 1 ELSE 0  END ) as totalPassLoan,
      sum(CASE WHEN typeLoan = '4' and status = 'STS-005' THEN 1 ELSE 0  END ) as totalPass12More,
      sum(CASE WHEN typeLoan = '5' and status = 'STS-005' THEN 1 ELSE 0  END ) as totalPassMiss
      FROM tbl_customers where dealday between '".$getdue->datedueStart."' and '".$getdue->datedueEnd."' GROUP BY traceEmployee");


      $getdue = tbl_duedate::getDuedate();
      $dateStart = date('Y-').date_format(date_create($getdue->datedueStart),'m-d');
      $dateEnd = date('Y-').date_format(date_create($getdue->datedueEnd),'m-d');


       return view('data_Customer.view', compact('positionUser','groupDebt','statuslist','non','dataBranch','teamAlists','teamBlists' ,'teamClists','teamDlists','countPass','getdue','BranchWork'));



    }
    public function getData(Request $request){
      $BranchList = Auth::user()->UserToPrivilege->branch;
      $getdue = tbl_duedate::getDuedate();
      if($request->type == 1){ // ดึงข้อมูล
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->whereBetween('dealDay',[$getdue->datedueStart , $getdue->datedueEnd])
        ->orderBy('dealDay', 'ASC')->get();


        return static::getTB($customers);
      }
      elseif($request->type == 2){
        $customers = tbl_customer::where('traceEmployee',$request->branch)
        ->whereBetween('dealDay',[$getdue->datedueStart , $getdue->datedueEnd])
        ->orderBy('dealDay', 'ASC')->get();

        return static::getTB($customers);
      }
      elseif($request->type == 3){
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->whereBetween('dealDay',[$getdue->datedueStart , $getdue->datedueEnd])
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
        ->whereBetween('dealDay',[$getdue->datedueStart , $getdue->datedueEnd])
        ->whereIn('groupDebt',['4.Past 2','5.Past 3'])
        ->where('typeLoan',1)
        ->orderBy('dealDay', 'ASC')->get();

        return static::getTB($customers);
      }
      elseif($request->type == 5){ //ส่งหัวหน้า PLM
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->whereBetween('dealDay',[$getdue->datedueStart , $getdue->datedueEnd])
        ->whereIn('status',['STS-009','STS-008'])
        ->where('typeLoan',1)
        ->orderBy('dealDay', 'ASC')->get();

        return static::getTB($customers);
      }
      elseif($request->type == 6){
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->whereBetween('dealDay',[$getdue->datedueStart , $getdue->datedueEnd])
        ->whereIn('status',['STS-009','STS-008'])
        ->where('typeLoan',2)
        ->orderBy('dealDay', 'ASC')->get();

        return static::getTB($customers);
      }
      elseif($request->type == 7){ // วันชำระวันนี้
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->whereBetween('dealDay',[$getdue->datedueStart , $getdue->datedueEnd])
        ->where('status','=','STS-001')
        ->whereIn('traceEmployee',explode(",",$BranchList))
        ->where('paymentDate','=',Carbon::today()->format('Y-m-d'))
        ->orderBy('dealDay', 'ASC')->get();
        return static::getTB($customers);
      }
      elseif($request->type == 8){ // ดีลวันนี้
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->whereBetween('dealDay',[$getdue->datedueStart , $getdue->datedueEnd])
        ->where('status','!=','STS-005')
        ->whereIn('traceEmployee',explode(",",$BranchList))
        ->where('dealDay','=',Carbon::today()->format('Y-m-d'))
        ->orderBy('dealDay', 'ASC')->get();
        return static::getTB($customers);
      }
      elseif($request->type == 9){ // ดีลเมื่อวาน
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->whereBetween('dealDay',[$getdue->datedueStart , $getdue->datedueEnd])
        ->where('status','!=','STS-005')
        ->whereIn('traceEmployee',explode(",",$BranchList))
        ->where('dealDay','=',Carbon::yesterday()->format('Y-m-d'))
        ->orderBy('dealDay', 'ASC')->get();
        return static::getTB($customers);
      }
      elseif($request->type == 10){ // ติดตามวันนี้
        $customers = tbl_customer::whereIn('traceEmployee',explode(",",$BranchList))
        ->whereBetween('dealDay',[$getdue->datedueStart , $getdue->datedueEnd])
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
        $data_Tag->Status = 'STS-010';
        $data_Tag->userInsert = Auth::user()->id;
        $data_Tag->save();


        $data_cus = tbl_customer::where('contractNumber',$request->contractNumber)->first();
        $data_cus->status = 'STS-010';
        $data_cus->update();

        $statuslist = tbl_statustype::getstatus();
        $data = tbl_customer::where('contractNumber',$request->contractNumber)->first();
        return response()->view('data_Customer.section-Cus.ShowCusDetails',compact('data','statuslist'));
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
        broadcast(new MessageChat( $request->addaction,Auth::user()->name, @$data->tag_id, @$data->updated_at) )->toOthers();
        return response()->json($data);
      }

    }

    public function receive(Request $request){ // chat
        return response()->json([
            'message' => $request->message ,
            'UserInsert' => $request->UserInsert,
            'tag_id' => $request->tag_id,
            'updated_at' => $request->updated_at
            ]);

    }

    public function show(Request $request, $id)
    {
      if($request->type == 1){ // โชว์โหลดตอนกดอัพเดทการจ่ายเงิน
        return view('data_Customer.section-onload.load-updateTotalPay');
      }
      elseif($request->type == 2){
        $traceEmployee = $request->traceEmployee;
        $countPass = DB::select("SELECT
        traceEmployee,
        sum(CASE WHEN traceEmployee  != '' THEN 1 ELSE 0  END ) as totalEmp,
        sum(CASE WHEN traceEmployee  != '' and  typeLoan  = '1'  THEN 1 ELSE 0  END ) as totalEmpPLM,
        sum(CASE WHEN traceEmployee  != '' and  typeLoan  = '2'  THEN 1 ELSE 0  END ) as totalEmpCKM,
        sum(CASE WHEN status  = 'STS-005' THEN 1 ELSE 0  END ) as totalPass,
        sum(CASE WHEN typeLoan  = '1' and  status  = 'STS-005' THEN 1 ELSE 0  END ) as totalPassPLM,
        sum(CASE WHEN typeLoan  = '2' and  status  = 'STS-005' THEN 1 ELSE 0  END ) as totalPassCKM
        FROM  tbl_customers  where traceEmployee = '".$traceEmployee."' GROUP BY traceEmployee");

      $dataHistory = DB::select("SELECT
      traceEmployee,duedateEnd,
      sum(CASE WHEN traceEmployee  != '' THEN 1 ELSE 0  END ) as totalEmp,
      sum(CASE WHEN traceEmployee  != '' and  typeLoan  = '1'  THEN 1 ELSE 0  END ) as totalEmpPLM,
      sum(CASE WHEN traceEmployee  != '' and  typeLoan  = '2'  THEN 1 ELSE 0  END ) as totalEmpCKM,
      sum(CASE WHEN status  = 'STS-005' THEN 1 ELSE 0  END ) as totalPass,
      sum(CASE WHEN typeLoan  = '1' and  status  = 'STS-005' THEN 1 ELSE 0  END ) as totalPassPLM,
      sum(CASE WHEN typeLoan  = '2' and  status  = 'STS-005' THEN 1 ELSE 0  END ) as totalPassCKM
      FROM  tbl_historydashboard  where traceEmployee = '".$traceEmployee."' GROUP BY duedateEnd ORDER BY duedateEnd ASC");

      $arrChartsPLM = array();
      $arrChartsCKM = array();
      $datecharts = array();
      foreach($dataHistory as $countHis){

        $countHisper = ( $countHis->totalPass / ($countHis->totalEmp != 0 ? $countHis->totalEmp : 1 )) * 100;
        $countHisPLM = ( $countHis->totalPassPLM / ($countHis->totalEmpPLM != 0 ? $countHis->totalEmpPLM : 1 )) * 100;
        $countHisCKM = ( $countHis->totalPassCKM / ($countHis->totalEmpCKM != 0 ? $countHis->totalEmpCKM : 1 )) * 100;

        array_push($arrChartsPLM,floatval(number_format($countHisPLM,2)) );
        array_push($arrChartsCKM,floatval(number_format($countHisCKM,2)) );
        array_push($datecharts,$countHis->duedateEnd);
      }
        return view('data_Customer.section-dashboard.dashboardBranch',compact('countPass','traceEmployee','arrChartsPLM','arrChartsCKM','datecharts'));
      }
      elseif($request->type == 3){
        $data_Tag = tbl_custag::where('id',$request->id)->first();
        $getdue = tbl_duedate::getDuedate();
        $statuslist = tbl_statustype::getstatus();

        $dataHis = tbl_DataLogStatus::where('TagID',$request->id)->get();
        $html = view('data_Customer.section-Cus.MesDetails',compact('data_Tag','getdue','statuslist','dataHis'))->render();
        return response()->json(['html'=>$html]);
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
        if($data->teamGroup == 4){
          $datapay = DB::connection('ibmi2')->select("
          SELECT
          SFHP.CHQTRAN.LOCATRECV,
          SFHP.CHQTRAN.TMBILDT,
          SFHP.CHQTRAN.TMBILL,
          SFHP.CHQTRAN.PAYFOR,
          SFHP.CHQTRAN.PAYTYP,
          SFHP.CHQTRAN.PAYAMT,
          SFHP.CHQTRAN.PAYINT,
          SFHP.CHQTRAN.DSCINT,
          SFHP.CHQTRAN.NETPAY
          FROM SFHP.ARMAST
          LEFT JOIN SFHP.CHQTRAN  ON SFHP.CHQTRAN.CONTNO = SFHP.ARMAST.CONTNO
          WHERE SFHP.ARMAST.CONTNO = '${contract}' ORDER BY TMBILDT DESC");
        } else {
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
        }
        $getdue = tbl_duedate::getDuedate();
        $dateStart = date('Y-').date_format(date_create($getdue->datedueStart),'m-d');
        $dateEnd = date('Y-').date_format(date_create($getdue->datedueEnd),'m-d');

        return view('data_Customer.section-Cus.viewModal',compact('data','statuslist','datapay','getdue'));
      }
      elseif($request->type == 2){
        $data = tbl_customer::find($id);
        $groupDebt = tbl_groupdebt::getGroupdebt();
        $non = tbl_non::getNon();
        $dataBranch = tbl_traceEmployee::getBranch();
        return view('data_Customer.section-Cus.editDataCus',compact('data','groupDebt','non','dataBranch'));
      }
    }

    public function update(Request $request, $id)
    {
      $getdue = tbl_duedate::getDuedate();
      $dateStart = $getdue->datedueStart;
      $dateEnd = $getdue->datedueEnd;

    //   $dateStart = '2023-10-07';
    //   $dateEnd = '2023-11-06';


      if($request->type == 1){ //อัพเดทสถานะ

        $data_Tag = tbl_custag::where('ContractID',$request->contractNumber)->orderBy('id','desc')->first();
        $data_Tag->Status = $request->statuschecks;
        $data_Tag->update();

        $data_status = tbl_customer::where('contractNumber',$request->contractNumber)->first();
        $data_status->status = $request->statuschecks;
        $data_status->update();

        $data_plan = new tbl_actionplan;
        $data_plan->tag_id = $data_Tag->id;
        $data_plan->date_plan = date('Y-m-d');
        $data_plan->ContractID = $request->contractNumber;
        $data_plan->detail = 'ได้อัพเดทสถานะเป็น '.@$data_status->CustoStatus->details;
        $data_plan->userInsert = Auth::user()->id;
        $data_plan->userInsertname = Auth::user()->name;
        $data_plan->save();

        event(new DataLogStatus($data_Tag->id,Auth::user()->id,Auth::user()->name,$data_plan->detail,'',$request->statuschecks));



          $searchApp = tbl_appointment::where('ContractNumber',$request->contractNumber)->where('DateApp',$request->payment_date)->first();
          if(@$searchApp == NULL){
            $appointment = new tbl_appointment;
            $appointment->ContractNumber= $request->contractNumber;
            $appointment->Status	= @$request->statuschecks;
            $appointment->DateApp	= $request->payment_date; // วันนีดชำระ
            $appointment->date	= date('Y-m-d');
            $appointment->save();
          }


        $data = tbl_customer::where('contractNumber',$request->contractNumber)->first();
        $statuslist = tbl_statustype::getstatus();
        $chatBox = view('data_Customer.section-Cus.ChatDetails',compact('data_Tag','statuslist'))->render();
        return response()->json(['chatBox' => $chatBox]);
      }

      elseif($request->type == 2){ // อัพเดทการจ่าย

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
        where PSFHP.CHQTRAN.TMBILDT >= '${dateStart}' and PSFHP.CHQTRAN.TMBILDT <= '${dateEnd}' and PSFHP.CHQTRAN.FLAG <> 'C'
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
        where RSFHP.CHQTRAN.TMBILDT >= '${dateStart}' and RSFHP.CHQTRAN.TMBILDT <= '${dateEnd}' and RSFHP.CHQTRAN.FLAG <> 'C'
        group BY RSFHP.ARMAST.CONTNO ) CalQ  ON CalQ.CONTNO = OD.CONTNO
        UNION
        SELECT OD.CONTNO,  CalQ.TOTALP, OD.TOTALC,OD.TMBILDT ,OD.PAYFOR ,OD.DEBT_BALANCE FROM
        (select DISTINCT SFHP.ARMAST.CONTNO,
        SFHP.CHQTRAN.TMBILDT ,
        SFHP.ARMAST.NPROFIT as TOTALC,
        SFHP.CHQTRAN.PAYFOR,
        SFHP.CHQTRAN.DEBT_BALANCE
        from SFHP.ARMAST
        left join SFHP.CHQTRAN on SFHP.CHQTRAN.CONTNO = SFHP.ARMAST.CONTNO
        where SFHP.CHQTRAN.TMBILDT <= '${dateEnd}' AND SFHP.CHQTRAN.TMBILDT >= '${dateStart}'
        ORDER BY SFHP.CHQTRAN.TMBILDT DESC ) OD
        INNER JOIN (select SFHP.ARMAST.CONTNO,  SUM(SFHP.CHQTRAN.PAYAMT) as TOTALP from SFHP.ARMAST
        left join SFHP.CHQTRAN on SFHP.CHQTRAN.CONTNO = SFHP.ARMAST.CONTNO
        where SFHP.CHQTRAN.TMBILDT >= '${dateStart}' and SFHP.CHQTRAN.TMBILDT <= '${dateEnd}' and SFHP.CHQTRAN.FLAG <> 'C'
        group BY SFHP.ARMAST.CONTNO ) CalQ  ON CalQ.CONTNO = OD.CONTNO");

        foreach ($dataPay as $key => $value){
          tbl_customer::where('contractNumber',trim($value->CONTNO))
          ->whereBetween('dealDay',[$dateStart , $dateEnd])
          ->update([
              'TotalPay' => $value->TOTALP,
              'balanceDebt' => $value->DEBT_BALANCE,
              'lastPaymentdate' => $value->TMBILDT,
          ]);
        }

        tbl_customer::whereRaw('TotalPay >= minimumPayout')
        ->whereBetween('dealDay',[$dateStart , $dateEnd])
        ->orWhereRaw("CAST( replace(arrears,',','') as float) = 0")
        ->orWhereRaw("CAST( replace(arrears,',','') as float) < minimumPayout  and TotalPay >= CAST( replace(arrears,',','') as float)")
        ->where('status','!=','STS-005')
        ->update([
          'status' => 'STS-005',
          'flag' => 'yes'
        ]);

        // ชำระแล้วไม่พอ
        tbl_customer::whereRaw('TotalPay > 0 and TotalPay < minimumPayout')
        ->whereBetween('dealDay',[$dateStart , $dateEnd])
        ->orWhereRaw("CAST( replace(arrears,',','') as float) < minimumPayout and TotalPay < CAST( replace(arrears,',','') as float) and TotalPay > 0")
        ->where('status','!=','STS-005')
        ->update([
          'status' => 'STS-006'
        ]);
        return 200;
      }
      elseif($request->type == 3){  //อัพเดทการติดตาม
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
      elseif($request->type == 4){  // backup

        // $inserts = [];
        // $data = tbl_customer::get();
        // foreach($data as $val) {
        //   tbl_historydashboard::create([
        //         "traceEmployee" => $val->traceEmployee,
        //         "groupDebt" => $val->groupDebt,
        //         "status" => $val->status,
        //         "teamGroup" =>1 ,
        //         "typeLoan" => $val->typeLoan,
        //         "TotalPay" => $val->TotalPay,
        //         "duedateStart" => $dateStart,
        //         "duedateEnd" => $dateEnd
        //         ]);
        // }

        tbl_customer::truncate(); // เคลียร์ข้อมูลเดิม
        $loanCode = ['01', 'P01', '50', '30'];
        $CheckTL = ['50', '30'];
        $teamA = ['BPRU','HYN','JN','NT1','NT2','RPHU','SING','SK','TEPA','HDY','SDAO','SDAO2','RPHU2'];
        $datenow = date("Y-m-d");

        $dataDebt = DB::connection('ibmi2')->select("
        SELECT * FROM PSFHP.VWDEBT_RPSPASTDUE
        LEFT JOIN  PSFHP.SETGRADE ON  PSFHP.VWDEBT_RPSPASTDUE.GRDCOD = PSFHP.SETGRADE.GRDCOD
        WHERE SUMARYDATE = '${datenow}' AND  EXPREAL < 4
        ");

        foreach ($dataDebt as $data){

          $SUBCONTNO_3050 = substr( trim(iconv('Tis-620', 'utf-8', $data->CONTNO)), 0, 2);
          $SUBCONTNO_P = substr( trim(iconv('Tis-620', 'utf-8', $data->CONTNO)), 0, 3);
          $SUBCONTNO_NEW = substr( trim(iconv('Tis-620', 'utf-8', $data->CONTNO)), 4, 2);

          if (in_array( $SUBCONTNO_3050, $CheckTL) ) { // check typeloan
            $typeloan = '2';
          }
          else {
            $typeloan = '1';
          }


          if (in_array( $SUBCONTNO_3050, $loanCode) || in_array( $SUBCONTNO_P, $loanCode) || in_array( $SUBCONTNO_NEW, $loanCode) ) { // check loancode
            $loancode =  '01';
          }
          else {
            $loancode = '02';
          }

          if(in_array(trim($data->SALECOD), $teamA)){ // check team group
            $teamgroup = 1;
          }
          else{
            $teamgroup = 2;
          }

          if( $loancode == '01' && trim(iconv('Tis-620', 'utf-8', $data->EXPREAL)) >= 3){
            //
          }
          else{
             tbl_customer::create( [
                 // "id" => 1,
                 "Branch" => '', // NON
                 "contractNumber" => trim(iconv('Tis-620', 'utf-8', $data->CONTNO)), // เลชสัญญา
                 "namePrefix" => trim(iconv('Tis-620', 'utf-8', $data->SNAM)), // คำนำหน้า
                 "firstname" => trim(iconv('Tis-620', 'utf-8', $data->NAME1)), // ชื่อ
                 "lastname" => trim(iconv('Tis-620', 'utf-8', $data->NAME2)), // นามสกุล
                 "phone" => trim(iconv('Tis-620', 'utf-8', $data->TELP)), // เบอร์โทร
                 "productName" => trim(iconv('Tis-620', 'utf-8', $data->MODEL)), // รุ่นสินค้า
                 "sellEmployee" => trim(iconv('Tis-620', 'utf-8', $data->SALECOD)),// พนง ขาย
                 "traceEmployee" => trim(iconv('Tis-620', 'utf-8', $data->SALECOD)), //ทีมตามใน
                 "totalInstallment" => trim(iconv('Tis-620', 'utf-8', $data->TOTPRC)), // ยอดผ่อนทั้งหมด
                 "firstInstallment" => trim(iconv('Tis-620', 'utf-8', $data->FDATE)), // วันดีลงวดแรก
                 "dealDay" => trim(iconv('Tis-620', 'utf-8', $data->DUEDATE)), // วันดีลงวด
                 "installment" => trim(iconv('Tis-620', 'utf-8', $data->DAMT)), //ผ่อนงวดละ
                 "realDebt" => trim(iconv('Tis-620', 'utf-8', $data->EXPREAL)), // ค้างจริง
                 "nextDebt" => trim(iconv('Tis-620', 'utf-8', $data->NEXT_EXPREAL)), //ค้าง Next
                 "groupDebt" => trim(iconv('Tis-620', 'utf-8', $data->SWEXPPRD)), //กลุ่มค้างงวด
                 "fromDebt" => trim(iconv('Tis-620', 'utf-8', $data->EXP_FRM)), // จากงวด
                 "toDebt" => trim(iconv('Tis-620', 'utf-8', $data->EXP_TO)), // ถึงงวด
                 "arrears" => trim(iconv('Tis-620', 'utf-8', $data->TOTLKANG)), // เงินค้างงวด
                 "lastPaymentdate" => trim(iconv('Tis-620', 'utf-8', $data->LPAYD)), //วันชำระล่าสุด
                 "lastPayment" => trim(iconv('Tis-620', 'utf-8', $data->LPAYA)), //ยอดชำระล่าสุด
                 "finePay" => trim(iconv('Tis-620', 'utf-8', $data->PAYINT)), // ค่าปรับ
                 "totalPayment" => trim(iconv('Tis-620', 'utf-8', $data->TOTPAY)), // รวมยอดชำระ // ** ไม่รวมค่าปรับ **
                 "balanceDebt" => trim(iconv('Tis-620', 'utf-8', $data->PARBAL)), // ลูกหนี้คงเหลือ
                 "minimumInstallment" => trim($data->GRDCAL), // งวดขั้นต่ำ // ** ยังไม่มี ** ( ตารางเกรด )
                 "minimumPayout" => floatval(trim(($data->DAMT * $data->GRDCAL))), // ยอดจ่ายขั้นต่ำ // ** ยังไม่มี ** ( ค่างวด * เกรด )
                 "contractGrade" => trim(iconv('Tis-620', 'utf-8', $data->GRDCOD)), // เกรดสัญญา
                 "status" => 'STS-010', // ผ่านเกณฑ์
                 "callDate" => NULL, // วันที่โทรติดตาม
                 "quantitycallDate" => NULL, // โทรติดตามมาแล้ว (วัน)
                 "callDateOut" => NULL, // วันที่ติดตาม (นอก)
                 "quantitycallDateOut" => NULL, // ติดตามมาแล้ว (วัน)
                 "traceTeamOut" => NULL, // ทีมตาม (นอก)
                 "paymentDate" => NULL, // วันที่นัดชำระ
                 "fieldDay" => NULL, // วันลงพื้นที่
                 "powerApp" => NULL, // วันลง POWERAPP
                 "FollowingDate" => NULL, // ติดตามต่อ
                 "note" => NULL, // action plan
                 "paymentDateQuantity" => NULL, //นัดชำระมาแล้ว (วัน)
                 "teamGroup" => $teamgroup, // ทีม
                 "typeLoan" => $typeloan, // ประเภทสัญญา 30-50 หรือ PLM
                 "Recorder" => NULL, // ผู้ลงบันทึกล่าสุด
                 "Schema" => 'PSFHP', // ตาราง
                 "TotalPay" => 0, // ยอดชำระรวมในเดือนนี้
             ]);
           }


        }



      }
      elseif($request->type == 5){
       $data = tbl_customer::find($request->id);
          // $data->Branch = $request->Branch;
          // $data->contractNumber = $request->contractNumber;
          $data->namePrefix = $request->namePrefix;
          $data->firstname = $request->firstname;
          $data->lastname = $request->lastname;
          $data->phone = $request->phone;
          $data->productName = $request->productName;
          $data->sellEmployee = $request->sellEmployee;
          $data->traceEmployee = $request->traceEmployee;
          $data->traceTeamOut  = $request->traceTeamOut;
          $data->firstInstallment = $request->firstInstallment;
          $data->dealDay = $request->dealDay;
          $data->totalInstallment = $request->totalInstallment;
          $data->paymentDate = $request->paymentDate;
          $data->installment = $request->installment;
          $data->realDebt = $request->realDebt;
          $data->arrears = $request->arrears;
          $data->lastPaymentdate = $request->lastPaymentdate;
          $data->groupDebt = $request->groupDebt;
          $data->teamGroup = $request->teamGroup;
          $data->groupDebt = $request->groupDebt;
          $data->typeLoan = $request->typeLoan;
          $data->TotalPay = $request->TotalPay;
          $data->minimumInstallment = $request->minimumInstallment;
          $data->minimumPayout = $request->minimumPayout;
          $data->nextDebt = $request->nextDebt;
          $data->groupDebt = $request->groupDebt;
       $data->update();
        return 200;
      }
    }

    public function dashboard(Request $request)
    {

      $getdue = tbl_duedate::getDuedate();
      if($request->duedateStart != NULL && $request->duedateEnd != NULL){
        $duedateStart = $request->duedateStart;
        $duedateEnd =  $request->duedateEnd;
      } else {
        $duedateStart = $getdue->datedueStart;
        $duedateEnd =  $getdue->datedueEnd;
      }
      $column = $request->get('typeloan');

      if($column == NULL) {
        $column = 1;
      }
      else {
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
          $data = DB::select("SELECT
          'traceEmployee' as traceEmployee,'typeLoan' as typeLoan,
            SUM(CASE WHEN groupDebt = '1.Befor'  THEN 1 ELSE 0 END) as totalBefor,
            SUM(CASE WHEN groupDebt = '1.Befor' and status = 'STS-005' THEN 1 ELSE 0 END) as PassBefor,

            SUM(CASE WHEN groupDebt = '2.Nomal'  THEN 1 ELSE 0 END) as totalNomal,
            SUM(CASE WHEN groupDebt = '2.Nomal' and status = 'STS-005' THEN 1 ELSE 0 END) as PassNomal,

            SUM(CASE WHEN groupDebt = '3.Past 1'  THEN 1 ELSE 0 END) as totalPast1,
            SUM(CASE WHEN groupDebt = '3.Past 1' and status = 'STS-005' THEN 1 ELSE 0 END) as PassPast1,

            SUM(CASE WHEN groupDebt = '4.Past 2'  THEN 1 ELSE 0 END) as totalPast2,
            SUM(CASE WHEN groupDebt = '4.Past 2' and status = 'STS-005' THEN 1 ELSE 0 END) as PassPast2,

            SUM(CASE WHEN groupDebt = '5.Past 3' or groupDebt = '6.Past 4'  THEN 1 ELSE 0 END) as totalPast,
            SUM(CASE WHEN groupDebt = '5.Past 3' or groupDebt = '6.Past 4' and status = 'STS-005' THEN 1 ELSE 0 END) as PassPast,

            SUM(CASE WHEN groupDebt = '5.Past 3'  THEN 1 ELSE 0 END) as totalPast3,
            SUM(CASE WHEN groupDebt = '5.Past 3' and status = 'STS-005' THEN 1 ELSE 0 END) as PassPast3,

            SUM(CASE WHEN groupDebt = '6.Past 4'  THEN 1 ELSE 0 END) as totalPast4,
            SUM(CASE WHEN groupDebt = '6.Past 4' and status = 'STS-005' THEN 1 ELSE 0 END) as PassPast4

            FROM tbl_customers WHERE typeLoan  = '${column}' and traceEmployee = '".$head."' and dealday between '".$duedateStart."' and '".$duedateEnd."' group by traceEmployee  ;
        ");
        }
        else {

          $data = DB::select("SELECT
              traceEmployee,
              SUM(CASE WHEN groupDebt = '1.Befor'  THEN 1 ELSE 0 END) as totalBefor,
              SUM(CASE WHEN groupDebt = '1.Befor' and status = 'STS-005' THEN 1 ELSE 0 END) as PassBefor,

              SUM(CASE WHEN groupDebt = '2.Nomal'  THEN 1 ELSE 0 END) as totalNomal,
              SUM(CASE WHEN groupDebt = '2.Nomal' and status = 'STS-005' THEN 1 ELSE 0 END) as PassNomal,

              SUM(CASE WHEN groupDebt = '3.Past 1'  THEN 1 ELSE 0 END) as totalPast1,
              SUM(CASE WHEN groupDebt = '3.Past 1' and status = 'STS-005' THEN 1 ELSE 0 END) as PassPast1,

              SUM(CASE WHEN groupDebt = '4.Past 2'  THEN 1 ELSE 0 END) as totalPast2,
              SUM(CASE WHEN groupDebt = '4.Past 2' and status = 'STS-005' THEN 1 ELSE 0 END) as PassPast2,

              SUM(CASE WHEN groupDebt = '5.Past 3' or groupDebt = '6.Past 4'  THEN 1 ELSE 0 END) as totalPast,
              SUM(CASE WHEN groupDebt = '5.Past 3' or groupDebt = '6.Past 4' and status = 'STS-005' THEN 1 ELSE 0 END) as PassPast,

              SUM(CASE WHEN groupDebt = '5.Past 3'  THEN 1 ELSE 0 END) as totalPast3,
              SUM(CASE WHEN groupDebt = '5.Past 3' and status = 'STS-005' THEN 1 ELSE 0 END) as PassPast3,

              SUM(CASE WHEN groupDebt = '6.Past 4'  THEN 1 ELSE 0 END) as totalPast4,
              SUM(CASE WHEN groupDebt = '6.Past 4' and status = 'STS-005' THEN 1 ELSE 0 END) as PassPast4

              FROM tbl_customers WHERE typeLoan  = '${column}' and TeamGroup = '".$head."' and dealday between '".$duedateStart."' and '".$duedateEnd."' group by traceEmployee  ;
          ");
        }

      // $datadue = tbl_historydashboard::select('duedateStart','duedateEnd')->distinct()->get();
      return view('data_Customer.section-dashboard.view',compact('data','head','column','duedateStart','duedateEnd'));
    }

    public function export(Request $request)
    {
      if($request->type == 1){
        return Excel::download(new exportDataCustomers, 'รายงานทีมติดตามหนี้.xlsx');
      }
      elseif ($request->type == 2){
        return Excel::download(new exportSFHP, 'รายงานSFHP.xlsx'); // รายงาน SFHP
      }
    }
    public function import()
    {
        Excel::import(new UsersImport,request()->file('file'));

        return response()->json(['success' => true]);
    }
}
