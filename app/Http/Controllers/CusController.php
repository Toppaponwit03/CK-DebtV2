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
                  return thaidate::simpleDateFormat($data->paymentDate);
                })
                ->addColumn('fieldDayTH', function ($data) {
                  return thaidate::simpleDateFormat($data->fieldDay);
                })
                ->addColumn('powerAppTH', function ($data) {
                  return thaidate::simpleDateFormat($data->powerApp);
                })
                ->addColumn('lastPaymentdateTH', function ($data) {
                  return thaidate::simpleDateFormat($data->lastPaymentdate);
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

      if($type == 1){
        return view('data_Customer.view', compact('positionUser','groupDebt','statuslist','non','dataBranch','teamAlists','teamBlists' ,'teamClists'));
      }

  
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
        $customers = tbl_customer::whereIn('groupDebt',['4.Past 2','5.Past 3'])
        ->where('typeLoan',1)
        ->orderBy('dealDay', 'ASC')->get();

        return static::getTB($customers);
      }
      elseif($request->type == 5){ //ส่งหัวหน้า PLM
        $customers = tbl_customer::whereIn('status',['STS-009','STS-008'])
        ->where('typeLoan',1)
        ->orderBy('dealDay', 'ASC')->get();

        return static::getTB($customers);
      }
      elseif($request->type == 6){
        $customers = tbl_customer::whereIn('status',['STS-009','STS-008'])
        ->where('typeLoan',2)
        ->orderBy('dealDay', 'ASC')->get();

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
        $data_Tag->actionPlan = $request->actionPlan;
        $data_Tag->payment_date = $request->payment_date;
        $data_Tag->visitArea_date = $request->visitArea_date;
        $data_Tag->PowerApp_date = $request->PowerApp_date;
        $data_Tag->userInsert = Auth::user()->id;
        $data_Tag->save();

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
        $statuslist = tbl_statustype::getstatus();
        $data = tbl_customer::find($id);

        return view('data_Customer.section-Cus.viewModal',compact('data','statuslist'));
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

      $dataPay = DB::connection('ibmi2')->select("SELECT OD.CONTNO,  CalQ.TOTALP, OD.TOTALC,OD.TMBILDT ,OD.PAYFOR ,OD.DEBT_BALANCE FROM
      (select DISTINCT PSFHP.ARMAST.CONTNO,
      PSFHP.CHQTRAN.TMBILDT ,
      PSFHP.ARMAST.NPROFIT as TOTALC,
      PSFHP.CHQTRAN.PAYFOR,
      PSFHP.CHQTRAN.DEBT_BALANCE
      from PSFHP.ARMAST 
      left join PSFHP.CHQTRAN on PSFHP.CHQTRAN.CONTNO = PSFHP.ARMAST.CONTNO  
      where PSFHP.CHQTRAN.TMBILDT < '${datenow}' AND PSFHP.CHQTRAN.TMBILDT > '${subdate}-07'
      ORDER BY PSFHP.CHQTRAN.TMBILDT DESC ) OD 
      INNER JOIN (select PSFHP.ARMAST.CONTNO,  SUM(PSFHP.CHQTRAN.PAYAMT) as TOTALP from PSFHP.ARMAST  
      left join PSFHP.CHQTRAN on PSFHP.CHQTRAN.CONTNO = PSFHP.ARMAST.CONTNO 
      where PSFHP.CHQTRAN.TMBILDT > '${subdate}-07' and PSFHP.CHQTRAN.FLAG <> 'C'  
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
      where RSFHP.CHQTRAN.TMBILDT < '${datenow}' AND RSFHP.CHQTRAN.TMBILDT > '${subdate}-07'  
      ORDER BY RSFHP.CHQTRAN.TMBILDT DESC ) OD 
      INNER JOIN (select RSFHP.ARMAST.CONTNO,  SUM(RSFHP.CHQTRAN.PAYAMT) as TOTALP from RSFHP.ARMAST  
      left join RSFHP.CHQTRAN on RSFHP.CHQTRAN.CONTNO = RSFHP.ARMAST.CONTNO 
      where RSFHP.CHQTRAN.TMBILDT > '${subdate}-07' and RSFHP.CHQTRAN.FLAG <> 'C'  
      group BY RSFHP.ARMAST.CONTNO ) CalQ  ON CalQ.CONTNO = OD.CONTNO ");



        foreach ($dataPay as $key => $value){
          tbl_customer::where('contractNumber',trim($value->CONTNO))
          ->update([
              'TotalPay' => $value->TOTALP,
              'balanceDebt' => $value->DEBT_BALANCE
          ]);
        }

        tbl_customer::whereRaw('TotalPay >= minimumPayout')
        ->orWhereRaw("CAST( replace(arrears,',','') as float) = 0")
        ->orWhereRaw("CAST( replace(arrears,',','') as float) < minimumPayout  and TotalPay >= CAST( replace(arrears,',','') as float)")
        ->where('status','!=','STS-005')
        ->update([
            'status' => 'STS-005'
        ]);


        return 200;

      }


    }

    public function dashboard(Request $request)
    {
        $head = $request->get('tablehead') ;
        $column = $request->get('typeloan');
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


    return view('data_Customer.section-dashboard.view',compact('data','head','column'));

      // $positionUser = Auth::user()->position;
      // $branchUser = Auth::user()->Branch;
  
      //   $getnum = $request->get('tablehead') ;
      //   $typeLoan = $request->get('typeloan');

      // if($getnum !='KAI')
      // {
      //   if($getnum == ''&&$typeLoan == ''&& Auth::user()->position == 'headA'){
      //     $getnum=1;
      //     $typeLoan=1;
      //     $head = 'ทีม A';
      //     $column = 'PLM';
        
      //   }else if($getnum == ''&&$typeLoan == ''&& Auth::user()->position == 'headB'){
      //     $getnum=2;
      //     $typeLoan=1;
      //     $head = 'ทีม B';
      //     $column = 'PLM';
      //   }else if($getnum == ''&&$typeLoan == ''&& Auth::user()->position == 'admin'){
      //     $getnum=1;
      //     $typeLoan=1;
      //     $head = 'ทีม A';
      //     $column = 'PLM';
      //   }else if($getnum == '1'&&$typeLoan == '1'){
      //     $column = 'PLM';
      //     $head = 'ทีม A';
      //   }else if($getnum == '1'&&$typeLoan == '2'){
      //     $getnum= $getnum;
      //     $typeLoan=$typeLoan;
      //     $head = 'ทีม A';
      //     $column = '50/30';
      //   }else if($getnum == '2'&&$typeLoan == '1'){
      //     $getnum= $getnum;
      //     $typeLoan=$typeLoan;
      //     $head = 'ทีม B';
      //     $column = 'PLM';
      //   }else if($getnum == '2'&&$typeLoan == '2'){
      //     $getnum= $getnum;
      //     $typeLoan=$typeLoan;
      //     $head = 'ทีม B';
      //     $column = '50/30';
      //   }else if($getnum == '3'&&$typeLoan == '1'){
      //     $getnum= $getnum;
      //     $typeLoan=$typeLoan;
      //     $head = 'ทีม C';
      //     $column = 'PLM';
      //   }else if($getnum == '3'&&$typeLoan == '2'){
      //     $getnum= $getnum;
      //     $typeLoan=$typeLoan;
      //     $head = 'ทีม C';
      //     $column = '50/30';
      //   }else{
      //     $head = 'อื่นๆ';
      //   }
        
      //   $num = tbl_customer::distinct()->where('teamGroup','=',$getnum)->count('traceEmployee');
      //   $traceEmployee = tbl_customer::where('teamGroup','=',$getnum)->distinct()->get('traceEmployee');  
      //   $traceEmployeecount = count($traceEmployee);
      //   for($i = 0; $i < $num ; $i++){

      //     /*-- ตรวจสอบคอลัมน์ รวม ค่าว่าเป็น 0 หรือไม่ --*/ 

      //     $count[$i] = tbl_customer::where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
      //     $pass[$i] =  tbl_customer::where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //     if($count[$i]==0 || $pass[$i]==0)  {
      //       $count[$i] = $count[$i];
      //       $pass[$i] = '-';
      //       $resultpercent[$i] = '-';
      //     }else{
      //       $resultpercent[$i] = number_format(($pass[$i]/$count[$i])*100,2);
      //     }
  
      //     /*-- ตรวจสอบคอลัมน์ Befor ค่าว่าเป็น 0 หรือไม่ --*/ 
      //     $countBefor[$i] = tbl_customer::where('groupDebt','=','1.Befor')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
      //     $passBefor[$i] =  tbl_customer::where('groupDebt','=','1.Befor')->where('status','=','STS-005')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
      //     if($countBefor[$i]==0 || $passBefor[$i]==0)  {
      //       $countBefor[$i] =  $countBefor[$i];
      //       $passBefor[$i] =  '-';
      //       $passpercenBefor[$i] =  '-';
      //     }else{
      //       $passpercenBefor[$i] = number_format(($passBefor[$i]) /($countBefor[$i])*100,2);
      //     }
      //     /*-- ตรวจสอบคอลัมน์ Normal ค่าว่าเป็น 0 หรือไม่ --*/ 
      //     $countNomal[$i]= tbl_customer::where('groupDebt','=','2.Nomal')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
      //     $passNomal[$i] = tbl_customer::where('groupDebt','=','2.Nomal')->where('status','=','STS-005')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
      //     if($countNomal[$i]==0 || $passNomal[$i] ==0)  {
      //       $countNomal[$i]=  $countNomal[$i];
      //       $passNomal[$i] = '-';
      //       $passpercenNomal[$i] =  '-';
      //     }else{
      //       $passpercenNomal[$i] = number_format(($passNomal[$i]) /($countNomal[$i])*100,2);
      //     }
      //     /*-- ตรวจสอบคอลัมน์ Past1 ค่าว่าเป็น 0 หรือไม่ --*/ 
      //     $countPast1[$i]= tbl_customer::where('groupDebt','=','3.Past 1')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
      //     $passPast1[$i] = tbl_customer::where('groupDebt','=','3.Past 1')->where('status','=','STS-005')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
      //     if($countPast1[$i]==0 || $passPast1[$i] ==0)  {
      //       $countPast1[$i]=  $countPast1[$i];
      //       $passPast1[$i] = '-';
      //       $passpercenPast1[$i] =  '-';
      //     }else{
      //       $passpercenPast1[$i] = number_format(($passPast1[$i]) /($countPast1[$i])*100,2);
      //     }
      //     /*-- ตรวจสอบคอลัมน์ Past2 ค่าว่าเป็น 0 หรือไม่ --*/ 
      //     $countPast2[$i]= tbl_customer::where('groupDebt','=','4.Past 2')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
      //     $passPast2[$i] = tbl_customer::where('groupDebt','=','4.Past 2')->where('status','=','STS-005')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
      //     if($countPast2[$i]==0 || $passPast2[$i] ==0)  {
      //       $countPast2[$i]=  $countPast2[$i];
      //       $passPast2[$i] = '-';
      //       $passpercenPast2[$i] =  '-';
      //     }else{
      //       $passpercenPast2[$i] = number_format(($passPast2[$i]) /($countPast2[$i])*100,2);
      //     }
      //     /*-- ตรวจสอบคอลัมน์ Past3 ค่าว่าเป็น 0 หรือไม่ --*/ 
      //     $countPast3[$i]= tbl_customer::where('groupDebt','=','5.Past 3')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
      //     $passPast3[$i] = tbl_customer::where('groupDebt','=','5.Past 3')->where('status','=','STS-005')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
      //     if($countPast3[$i]==0 || $passPast3[$i] ==0)  {
      //       $countPast3[$i]=  $countPast3[$i];
      //       $passPast3[$i] =  '-';
      //       $passpercenPast3[$i] = '-';
      //     }else{
      //       $passpercenPast3[$i] = number_format(($passPast3[$i]) /($countPast3[$i])*100,2);
      //     }
      //     /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นรวม ค่าว่าเป็น 0 หรือไม่ --*/ 
      //     $followCustomers[$i] = intval($countPast1[$i])+intval($countPast2[$i])+intval($countPast3[$i]);
      //     $totalpass[$i]= intval($passPast1[$i])+intval($passPast2[$i])+intval($passPast3[$i]);
      //     if($followCustomers[$i]==0 || $totalpass[$i] ==0)  {
      //       $followCustomers[$i] =  $followCustomers[$i];
      //       $totalpass[$i]=  '-';
      //       $totalpercen[$i] = '-';
      //     }else{
      //       $totalpercen[$i] = number_format(($totalpass[$i]) /($followCustomers[$i])*100,2);
      //     }

      //    /*-- ตรวจสอบคอลัมน์ ไม่ผ่าน ค่าว่าเป็น 0 หรือไม่ --*/ 
      //     $totalnotpass[$i] =  intval($followCustomers[$i]) - intval($totalpass[$i]);
      //     if($totalnotpass[$i] == 0){
      //       $totalnotpass[$i] = '-';
      //     }

      //       // เก็บค่าใน dataDashboard
      //     $dataDashboard[$i] = [
               
      //         "ทีมตาม" => $traceEmployee[$i]->traceEmployee,

      //             // คอลัมน์รวม
      //           "รวม (รวม)" => $count[$i],
      //           "รวม (ผ่าน)" =>  $pass[$i],
      //           "รวม (%)" => $resultpercent[$i],
             
      //            // คอลัมน์Befor
      //            "Befor (รวม)" => $countBefor[$i],
      //            "Befor (ผ่าน)" => $passBefor[$i],
      //            "Befor (%)"  => $passpercenBefor[$i], 
                  
      //            // คอลัมน์Nomal
      //            "Nomal (รวม)" => $countNomal[$i],
      //            "Nomal (ผ่าน)" =>  $passNomal[$i] ,
      //            "Nomal (%)"   => $passpercenNomal[$i],
                 
      //            // คอลัมน์Past 1
      //            "Past1 (รวม)" =>  $countPast1[$i],
      //            "Past1 (ผ่าน)" =>  $passPast1[$i],
      //            "Past1 (%)" =>  $passpercenPast1[$i],
                  
      //            // คอลัมน์Past 2
      //            "Past2 (รวม)" =>  $countPast2[$i],
      //            "Past2 (ผ่าน)" =>  $passPast2[$i] ,
      //            "Past2 (%)" =>  $passpercenPast2[$i],
                
      //            // คอลัมน์Past 3
               
      //            "Past3 (รวม)" =>  $countPast3[$i],
      //            "Past3 (ผ่าน)" =>  $passPast3[$i] ,
      //            "Past3 (%)" =>  $passpercenPast3[$i],

      //             //คอลัมน์จำนวนลูกค้าที่ต้องตาม
      //             "จำนวนลูกค้าที่ต้องตาม"=> $followCustomers[$i],
                     
      //            //คอลัมน์ผ่าน
      //            "ผ่าน"=> $totalpass[$i],
                     
      //            //คอลัมน์ไม่ผาน
      //            "ไม่ผาน"=>  $totalnotpass[$i],
                     
                     
      //            //คอลัมน์เปอร์เซ็นทั้งหมด
                     
      //            "เปอร์เซ็นทั้งหมด" =>  $totalpercen[$i] , 

    
      //     ];

         
      //     /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นแถว รวม ค่าว่าเป็น 0 หรือไม่ --*/ 
      //       $total[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('typeLoan','=',$typeLoan)->count();
      //       $totalpass[$i] = tbl_customer:: where('teamGroup','=',$getnum)->where('typeLoan','=',$typeLoan) ->where('status','=','STS-005')->count();
            
      //       if($total[$i]==0 || $totalpass[$i] ==0)  {
      //         $total[$i]=  $total[$i];
      //         $totalpass[$i] = '-';
      //         $totalpercen[$i] =  '-';
      //       }else{
      //         $totalpercen[$i] = number_format(($totalpass[$i]) /($total[$i])*100,2);
      //       }
      //       /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นแถว Befor ค่าว่าเป็น 0 หรือไม่ --*/ 
      //      $totalBefor[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','1.Befor')->where('typeLoan','=',$typeLoan)->count();
      //      $totalBeforpass[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','1.Befor')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //      if($totalBefor[$i]==0 || $totalBeforpass[$i] ==0)  {
      //       $totalBeforpass[$i] =   $totalBeforpass[$i];
      //       $totalBefor[$i] =  '-';
      //       $totalpercen[$i] = '-';
      //     }else{
      //       $percenBefor[$i] = number_format(($totalBeforpass[$i]) /($totalBefor[$i])*100,2);
      //     }
      //       /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นแถว Nomal ค่าว่าเป็น 0 หรือไม่ --*/ 
      //      $totalNomal[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','2.Nomal')->where('typeLoan','=',$typeLoan)->count();
      //      $totalNomalPass[$i] = tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','2.Nomal')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //      if($totalNomal[$i]==0 || $totalNomalPass[$i] ==0)  {
      //       $totalNomal[$i] = $totalNomal[$i];
      //       $totalNomalPass[$i] = '-';
      //       $totalpercen[$i] =  '-';
      //     }else{
      //       $percenNomal[$i] = number_format(($totalNomalPass[$i]) /($totalNomal[$i])*100,2);
      //     }
      //      /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นแถว Past1 ค่าว่าเป็น 0 หรือไม่ --*/ 
      //    $totalPast1[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('typeLoan','=',$typeLoan)->count();
      //    $totalPast1Pass[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1') ->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //    if($totalPast1[$i]==0 || $totalPast1Pass[$i] ==0)  {
      //     $totalPast1[$i] =  $totalPast1[$i] ;
      //     $totalPast1Pass[$i] = '-';
      //     $percenPast1[$i] =  '-';
      //   }else{
      //     $percenPast1[$i] = number_format(($totalPast1Pass[$i]) /($totalPast1[$i])*100,2);
      //   }   
      //     /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นแถว Past2 ค่าว่าเป็น 0 หรือไม่ --*/ 
      //    $totalPast2[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('typeLoan','=',$typeLoan)->count();
      //    $totalPast2Pass[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2') ->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //    if($totalPast2[$i]==0 || $totalPast2Pass[$i] ==0)  {
      //     $totalPast2[$i] = $totalPast2[$i];
      //     $totalPast2Pass[$i] = '-';
      //     $percenPast2[$i] =  '-';
      //   }else{
      //     $percenPast2[$i] = number_format(($totalPast2Pass[$i]) /($totalPast2[$i])*100,2);
      //   }  
          
      //     /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นแถว Past3 ค่าว่าเป็น 0 หรือไม่ --*/ 
      //    $totalPast3[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('typeLoan','=',$typeLoan)->count();
      //    $totalPast3Pass[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3') ->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //    if($totalPast3[$i]==0 || $totalPast3Pass[$i] ==0)  {
      //     $totalPast3Pass[$i] =  '-';
      //     $totalPast3[$i] =  $totalPast3[$i];
      //     $percenPast3[$i] =  '-';
      //   }else{
      //     $percenPast3[$i] = number_format(($totalPast3Pass[$i]) /($totalPast3[$i])*100,2);
      //   }    
        
      //    /*-- ตรวจสอบคอลัมน์ % ค่าว่าเป็น 0 หรือไม่ --*/
      //    $totalfollowCus[$i] = 
      //    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('typeLoan','=',$typeLoan)->count() +
      //    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('typeLoan','=',$typeLoan)->count() +
      //    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('typeLoan','=',$typeLoan)->count() ;

      //     $totalfollowCusPass[$i] = 
      //    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count() +
      //    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count() +
      //    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count() ;

      //    if($totalfollowCus[$i]==0 || $totalfollowCusPass[$i] ==0)  {
      //     $totalfollowCusPass[$i] = '-';
      //     $totalfollowCus[$i] =  $totalfollowCus[$i];
      //     $percenPast3[$i] = '-';
      //   }else{
      //     $totalPercen[$i] = number_format(($totalfollowCusPass[$i]) /($totalfollowCus[$i])*100,2);
      //   }  
      //    /*-- ตรวจสอบคอลัมน์ ไม่ผ่าน ค่าว่าเป็น 0 หรือไม่ --*/
      //    $totalfollowCusnotPass[$i] = 
      //   tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('status','=','STS-010')->where('typeLoan','=',$typeLoan)->count() +
      //   tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('status','=','STS-010')->where('typeLoan','=',$typeLoan)->count() +
      //   tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('status','=','STS-010')->where('typeLoan','=',$typeLoan)->count() ;
          
      //   if($totalfollowCusnotPass[$i]==0)  {
      //     $totalfollowCusnotPass[$i] = '-';
      //   } 
      //   else {
      //     $totalfollowCusnotPass[$i] =  $totalfollowCusnotPass[$i] ;
      //   }

      //      // สรุปรวมในตาราง
      //       $result = [
                  
      //           "total" => $total[$i] ,
      //           "totalpass" => $totalpass[$i],
      //           "totalpercen" => $totalpercen[$i],
                  
      //           "totalBefor" => $totalBefor[$i] ,
      //           "totalBeforpass" => $totalBeforpass[$i],
      //           "percenBefor" => @$percenBefor[$i],

      //           "totalNomal" =>  $totalNomal[$i],
      //           "totalNomalPass" => $totalNomalPass[$i],
      //           "percenNomal"=> @$percenNomal[$i],

      //           "totalPast1" =>  $totalPast1[$i],
      //           "totalPast1Pass" => $totalPast1Pass[$i],
      //           "percenPast1"=> @$percenPast1[$i],

      //            "totalPast2" =>  $totalPast2[$i],
      //            "totalPast2Pass" => $totalPast2Pass[$i],
      //            "percenPast2"=> @$percenPast2[$i],

      //           "totalPast3" =>  $totalPast3[$i],
      //           "totalPast3Pass" => $totalPast3Pass[$i],
      //           "percenPast3"=> @$percenPast3[$i],

      //            // จำนวนลูกค้าที่ต้องตาม
      //            "totalfollowCus" => $totalfollowCus[$i],
      //            //ผ่าน
      //            "totalfollowCusPass" => $totalfollowCusPass[$i],
      //            //ไม่ผ่าน
      //            "totalfollowCusnotPass" => $totalfollowCusnotPass[$i],  
      //            //เปอร์เซ็นทั้งหมด
      //            "totalPercen"=> @$totalPercen[$i],
      //       ];
       
      //   }  
        
      //               //chart
      //               $beforAll =     tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','1.Befor')->where('typeLoan','=',$typeLoan)->count();
      //               $befor =        tbl_customer:: where('teamGroup','=',$getnum) ->where('groupDebt','=','1.Befor')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //               $beforNotpass = $beforAll - $befor;
                  
      //               $nomalAll =     tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','2.Nomal')->where('typeLoan','=',$typeLoan)->count();
      //               $nomal =        tbl_customer:: where('teamGroup','=',$getnum) ->where('groupDebt','=','2.Nomal')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //               $nomalNotpass = $nomalAll - $nomal ; 
                  
      //               $past1All =     tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('typeLoan','=',$typeLoan)->count();
      //               $past1 =        tbl_customer:: where('teamGroup','=',$getnum) ->where('groupDebt','=','3.Past 1')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //               $past1Notpass =  $past1All - $past1 ; 
                  
      //               $past2All =     tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('typeLoan','=',$typeLoan)->count();
      //               $past2 =        tbl_customer:: where('teamGroup','=',$getnum) ->where('groupDebt','=','4.Past 2')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //               $past2Notpass =  $past2All - $past2 ; 
                  
      //               $past3All =     tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('typeLoan','=',$typeLoan)->count();
      //               $past3 =        tbl_customer:: where('teamGroup','=',$getnum) ->where('groupDebt','=','5.Past 3')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //               $past3Notpass =  $past3All - $past3 ; 
      //               $emplist = tbl_traceEmployee::whereIn('teamGroup',['1','2','3'])->orderBy('teamGroup', 'ASC')->get();

      //              // $emplist = tbl_traceEmployee::where('teamGroup','=',$getnum)->orderBy('teamGroup', 'ASC')->get();
      //               $countupdatetoday = count(tbl_customer::whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'ASC')->get());
      //               $countdateline = count(tbl_customer::where('status','=','นัดชำระ')->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->get());
           
      //               //Calculate percent

      //                $totalCus = tbl_customer::where('teamGroup','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); // ลูกค้าทั้งหมด
      //                $totalCusPass = tbl_customer::where('status','=','STS-005')->where('teamGroup','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); // ลูกค้าทั้งหมดที่ผ่าน
      //                $totalCusNotPass = tbl_customer::whereNot('status','=','STS-005')->where('teamGroup','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); // ลูกค้าทั้งหมดยกเว้นคนที่ผ่าน
      //                $totalpowerApp = tbl_customer::where('powerApp','!=','')->where('teamGroup','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); //จำนวนการลง power app
      //                   if($totalCus==0 || $totalpowerApp==0){
      //                     $percenfiled = 0;
      //                   }else{
      //                     $percenfiled = number_format(($totalpowerApp/$totalCus) * 100,2); // เปอร์เซ็นการลงพื้นที่  
      //                   }
      //                   if($totalCus==0 || $totalCusNotPass==0){
      //                     $percenNotPass = 0;
      //                   }else{
      //                     $percenNotPass = number_format(($totalCusNotPass/$totalCus)*100,2); //เปอร์เซ็นลูกค้าทั้งหมดที่ไม่ผ่าน
      //                   }
      //                   if($totalCus==0 || $totalCusPass==0){
      //                     $percenPass = 0;
      //                   }else{
      //                     $percenPass = number_format(($totalCusPass/$totalCus)*100,2); //เปอร์เซ็นลูกค้าที่ผ่านทั้งหมด
      //                   }

      //   return view('data_Customer.section-dashboard.view',compact('befor','beforNotpass','nomal','nomalNotpass','past1','past1Notpass','past2','past2Notpass','past3','past3Notpass','count','pass','countBefor','passBefor','countNomal','passNomal', 'countPast1',
      //   'passPast1','countPast2' ,'passPast2','countPast3','passPast3','dataDashboard','traceEmployeecount','num','result','head','column','emplist','countupdatetoday','countdateline','percenfiled','percenNotPass','percenPass'
      //   ));
      // }
      // else{
      //   if($typeLoan == 1){
      //       $totalKAIPLM =  tbl_customer::where('traceEmployee','=',$getnum)->where('typeloan','=',$typeLoan)->count();
      //       $totalKAIPassPLM =  tbl_customer::where('traceEmployee','=',$getnum)->where('typeloan','=',$typeLoan)->where('status','=','STS-005')->count();
            
      //       if($totalKAIPassPLM == 0 || $totalKAIPLM == 0){
      //         $totalPercenKAIPLM =0;
      //       }else {
      //         $totalPercenKAIPLM = number_format((($totalKAIPassPLM+0.0001) / ($totalKAIPLM+0.0001))*100,2);
      //       }
            
      //       $column= 'PLM';
      //       $head = 'ทีม C';

      //               //Calculate percent

      //               $totalCus = tbl_customer::where('traceEmployee','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); // ลูกค้าทั้งหมด
      //               $totalCusPass = tbl_customer::where('status','=','STS-005')->where('traceEmployee','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); // ลูกค้าทั้งหมดที่ผ่าน
      //               $totalCusNotPass = tbl_customer::whereNot('status','=','STS-005')->where('traceEmployee','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); // ลูกค้าทั้งหมดยกเว้นคนที่ผ่าน
      //               $totalpowerApp = tbl_customer::where('powerApp','!=','')->where('traceEmployee','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); //จำนวนการลง power app
      //                  if($totalCus==0 || $totalpowerApp==0){
      //                    $percenfiled = 0;
      //                  }else{
      //                    $percenfiled = number_format(($totalpowerApp/$totalCus) * 100,2); // เปอร์เซ็นการลงพื้นที่  
      //                  }
      //                  if($totalCus==0 || $totalCusNotPass==0){
      //                    $percenNotPass = 0;
      //                  }else{
      //                    $percenNotPass = number_format(($totalCusNotPass/$totalCus)*100,2); //เปอร์เซ็นลูกค้าทั้งหมดที่ไม่ผ่าน
      //                  }
      //                  if($totalCus==0 || $totalCusPass==0){
      //                    $percenPass = 0;
      //                  }else{
      //                    $percenPass = number_format(($totalCusPass/$totalCus)*100,2); //เปอร์เซ็นลูกค้าที่ผ่านทั้งหมด
      //                  }
      //                    //chart
      //                    $beforAll =     tbl_customer::where('traceEmployee','=',$getnum)->where('groupDebt','=','1.Befor')->where('typeLoan','=',$typeLoan)->count();
      //                    $befor =        tbl_customer:: where('traceEmployee','=',$getnum) ->where('groupDebt','=','1.Befor')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //                    $beforNotpass = $beforAll - $befor;
                       
      //                    $nomalAll =     tbl_customer::where('traceEmployee','=',$getnum)->where('groupDebt','=','2.Nomal')->where('typeLoan','=',$typeLoan)->count();
      //                    $nomal =        tbl_customer:: where('traceEmployee','=',$getnum) ->where('groupDebt','=','2.Nomal')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //                    $nomalNotpass = $nomalAll - $nomal ; 
                       
      //                    $past1All =     tbl_customer::where('traceEmployee','=',$getnum)->where('groupDebt','=','3.Past 1')->where('typeLoan','=',$typeLoan)->count();
      //                    $past1 =        tbl_customer:: where('traceEmployee','=',$getnum) ->where('groupDebt','=','3.Past 1')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //                    $past1Notpass =  $past1All - $past1 ; 
                       
      //                    $past2All =     tbl_customer::where('traceEmployee','=',$getnum)->where('groupDebt','=','4.Past 2')->where('typeLoan','=',$typeLoan)->count();
      //                    $past2 =        tbl_customer:: where('traceEmployee','=',$getnum) ->where('groupDebt','=','4.Past 2')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //                    $past2Notpass =  $past2All - $past2 ; 
                       
      //                    $past3All =     tbl_customer::where('traceEmployee','=',$getnum)->where('groupDebt','=','5.Past 3')->where('typeLoan','=',$typeLoan)->count();
      //                    $past3 =        tbl_customer:: where('traceEmployee','=',$getnum) ->where('groupDebt','=','5.Past 3')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //                    $past3Notpass =  $past3All - $past3 ; 
      
      //       $emplist = tbl_traceEmployee::where('teamGroup','=','1')->orWhere('teamGroup','=','2')->orwhere('teamGroup','=','2')->orWhere('employeeName','=','KAI')->orderBy('teamGroup', 'ASC')->get();
      //      // $befor=''; $beforNotpass=''; $nomal=''; $nomalNotpass=''; $past1=''; $past1Notpass=''; $past2=''; $past2Notpass =''; $past3=''; $past3Notpass ='';
      //       $countupdatetoday = count(tbl_customer::whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'ASC')->get());
      //       $countdateline = count(tbl_customer::where('status','=','นัดชำระ')->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->get());
        
      //       return view('data_Customer.section-dashboard.view',compact('befor','beforNotpass','nomal','nomalNotpass','past1','past1Notpass','past2','past2Notpass','past3','past3Notpass','head','column','totalKAIPLM','totalKAIPassPLM','totalPercenKAIPLM','typeLoan'
      //       ,'totalCus','totalCusPass','totalCusNotPass','totalpowerApp','percenfiled','percenNotPass','percenPass','emplist','countupdatetoday','countdateline'));

      //   }
      //   else if($typeLoan == 2){
      //       $totalKAI50=  tbl_customer::where('traceEmployee','=',$getnum)->where('typeloan','=',$typeLoan)->count();
      //       $totalKAIPass50 =  tbl_customer::where('traceEmployee','=',$getnum)->where('status','=','STS-005')->count();
      //       $totalPercenKAI50 =  number_format((($totalKAIPass50+0.0001) / ($totalKAI50+0.0001))*100,2);
      //       $column = '50-30';
            
      //       $head = 'ทีม C';

      //               //Calculate percent

      //               $totalCus = tbl_customer::where('traceEmployee','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); // ลูกค้าทั้งหมด
      //               $totalCusPass = tbl_customer::where('status','=','STS-005')->where('traceEmployee','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); // ลูกค้าทั้งหมดที่ผ่าน
      //               $totalCusNotPass = tbl_customer::whereNot('status','=','STS-005')->where('traceEmployee','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); // ลูกค้าทั้งหมดยกเว้นคนที่ผ่าน
      //               $totalpowerApp = tbl_customer::where('powerApp','!=','')->where('traceEmployee','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); //จำนวนการลง power app
      //                  if($totalCus==0 || $totalpowerApp==0){
      //                    $percenfiled = 0;
      //                  }else{
      //                    $percenfiled = number_format(($totalpowerApp/$totalCus) * 100,2); // เปอร์เซ็นการลงพื้นที่  
      //                  }
      //                  if($totalCus==0 || $totalCusNotPass==0){
      //                    $percenNotPass = 0;
      //                  }else{
      //                    $percenNotPass = number_format(($totalCusNotPass/$totalCus)*100,2); //เปอร์เซ็นลูกค้าทั้งหมดที่ไม่ผ่าน
      //                  }
      //                  if($totalCus==0 || $totalCusPass==0){
      //                    $percenPass = 0;
      //                  }else{
      //                    $percenPass = number_format(($totalCusPass/$totalCus)*100,2); //เปอร์เซ็นลูกค้าที่ผ่านทั้งหมด
      //                  }

      //                //chart
      //               $beforAll =     tbl_customer::where('traceEmployee','=',$getnum)->where('groupDebt','=','1.Befor')->where('typeLoan','=',$typeLoan)->count();
      //               $befor =        tbl_customer:: where('traceEmployee','=',$getnum) ->where('groupDebt','=','1.Befor')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //               $beforNotpass = $beforAll - $befor;
                  
      //               $nomalAll =     tbl_customer::where('traceEmployee','=',$getnum)->where('groupDebt','=','2.Nomal')->where('typeLoan','=',$typeLoan)->count();
      //               $nomal =        tbl_customer:: where('traceEmployee','=',$getnum) ->where('groupDebt','=','2.Nomal')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //               $nomalNotpass = $nomalAll - $nomal ; 
                  
      //               $past1All =     tbl_customer::where('traceEmployee','=',$getnum)->where('groupDebt','=','3.Past 1')->where('typeLoan','=',$typeLoan)->count();
      //               $past1 =        tbl_customer:: where('traceEmployee','=',$getnum) ->where('groupDebt','=','3.Past 1')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //               $past1Notpass =  $past1All - $past1 ; 
                  
      //               $past2All =     tbl_customer::where('traceEmployee','=',$getnum)->where('groupDebt','=','4.Past 2')->where('typeLoan','=',$typeLoan)->count();
      //               $past2 =        tbl_customer:: where('traceEmployee','=',$getnum) ->where('groupDebt','=','4.Past 2')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //               $past2Notpass =  $past2All - $past2 ; 
                  
      //               $past3All =     tbl_customer::where('traceEmployee','=',$getnum)->where('groupDebt','=','5.Past 3')->where('typeLoan','=',$typeLoan)->count();
      //               $past3 =        tbl_customer:: where('traceEmployee','=',$getnum) ->where('groupDebt','=','5.Past 3')->where('status','=','STS-005')->where('typeLoan','=',$typeLoan)->count();
      //               $past3Notpass =  $past3All - $past3 ; 
      
      //             $countupdatetoday = count(tbl_customer::whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'ASC')->get());
      //             $countdateline = count(tbl_customer::where('status','=','นัดชำระ')->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->get());

      //             $emplist = tbl_traceEmployee::where('teamGroup','=','1')->orWhere('teamGroup','=','2')->orwhere('teamGroup','=','2')->orWhere('employeeName','=','KAI')->orderBy('teamGroup', 'ASC')->get();
      //             //$befor=''; $beforNotpass=''; $nomal=''; $nomalNotpass=''; $past1=''; $past1Notpass=''; $past2=''; $past2Notpass =''; $past3=''; $past3Notpass ='';

      //       return view('data_Customer.section-dashboard.view',compact('befor','beforNotpass','nomal','nomalNotpass','past1','past1Notpass','past2','past2Notpass','past3','past3Notpass','head','column','totalKAI50','totalKAIPass50','totalPercenKAI50','typeLoan'
      //       ,'totalCus','totalCusPass','totalCusNotPass','totalpowerApp','percenfiled','percenNotPass','percenPass','emplist','countupdatetoday','countdateline'
      //     ));

      //   }
      // }     
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
