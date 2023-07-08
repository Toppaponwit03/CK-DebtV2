<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\tbl_customer;
use App\Models\tbl_groupdebt;
use App\Models\tbl_statustype;
use App\Models\tbl_traceEmployee;
use App\Models\tbl_non;
use Carbon\Carbon;

class headcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $positionUser = Auth::user()->position;
        if($positionUser == 'headA'){
          $numteam = '1';
        }else{
          $numteam = '2';
        }
        $type = $request->get('type');
        if($type == 0){
           $customers = tbl_customer::where('teamGroup','=',$numteam )->orderBy('dealDay', 'ASC')->paginate();
           $numhead = $numteam ;
           $typename = 'ลูกค้าทั้งหมด';
           $links = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
           $customers->withPath($links);
           $countresulttype =  tbl_customer::where('teamGroup','=',$numteam )->orderBy('dealDay', 'ASC')->count();
        }
        elseif($type == 6){ //อัพเดทล่าสุดวันนี้
          $customers = tbl_customer::where('teamGroup','=',$numteam )->whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'DESC')->paginate();
          $numhead = $numteam ;
          $typename = 'อัพเดทล่าสุดวันนี้';
          $links = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
          $customers->withPath($links);
          $countresulttype = tbl_customer::where('teamGroup','=',$numteam )->whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'DESC')->count();
        }
        elseif($type == 7){ //นัดชำระวันนี้
          $customers = tbl_customer::where('status','=','นัดชำระ')->where('teamGroup','=',$numteam )->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->orderBy('dealDay', 'ASC')->paginate();
          $numhead = $numteam ;
          $typename = 'นัดชำระวันนี้';
          $links = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
          $customers->withPath($links);
          $countresulttype = tbl_customer::where('status','=','นัดชำระ')->where('teamGroup','=',$numteam )->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->count();
        }

        $groupDebt = tbl_groupdebt::orderby('groupDebtID', 'ASC')->get();
        $statuslist = tbl_statustype::orderBy('id', 'ASC')->get();
        $non = tbl_non::orderBy('id', 'ASC')->get();
        $branch = tbl_customer::select('Branch')->distinct()->get();
        $emplist = tbl_traceEmployee::where('teamGroup','=',$numteam)->orderBy('teamGroup', 'ASC')->get();
        $teamtumlists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','1')->get();
        $teamtonglists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','2')->get();
        $countresult = count(tbl_customer::where('teamGroup','=',$numteam )->orderBy('dealDay', 'ASC')->get());
        $countdateline = count(tbl_customer::where('status','=','นัดชำระ')->where('teamGroup','=',$numteam )->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->get());
        $countupdatetoday = count(tbl_customer::where('teamGroup','=',$numteam )->whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'ASC')->get());
        $countresultPass = count(tbl_customer::where('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('teamGroup','=',$numteam )->get());
        $countresultfoll = count(tbl_customer::whereNot('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('teamGroup','=',$numteam )->get());
        $tag = 1;
        return view('data_head.view_head', compact('customers','groupDebt','statuslist','emplist','non','branch','teamtumlists','teamtonglists','countresult','countresultPass','countresultfoll','countupdatetoday','type','countdateline','tag','typename','countresulttype')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return response()->json(tbl_customer::find($id));
        return tbl_customer::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(request $request)
    {  
      $positionUser = Auth::user()->position;
      if($positionUser == 'headA'){
        $numteam = '1';
      }else{
        $numteam = '2';
      }
      //-- Request --//
        $type = $request->get('type');
        $tab = $request->get('tab');
        $teamtumlists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','1')->get();
        $teamtonglists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','2')->get();
        $countresultPass = count(tbl_customer::where('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('teamGroup','=',$numteam)->get());
        $countresultfoll = count(tbl_customer::whereNot('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('teamGroup','=',$numteam)->get());
        $teamGroup = $request->get('teamGroup');
        $traceEmployee = $request->get('traceEmployee');
        $searchtype = $request->get('searchtype');
        $searchstatus = $request->get('searchstatus');
        $searchtracknumber = $request->get('searchtracknumber');
        $groupDebtlist = $request->get('groupDebt');
        $nonlist = $request->get('nonlist');
        $groupDebt = tbl_groupdebt::orderby('groupDebtID', 'ASC')->get();
        $statuslist = tbl_statustype::orderBy('id', 'ASC')->get();
        $non = tbl_non::orderBy('id', 'ASC')->get();
        $branch = tbl_customer::select('Branch')->distinct()->get();
        $emplist = tbl_traceEmployee::where('teamGroup','=',$numteam)->orderBy('teamGroup', 'ASC')->get();
        $customer = tbl_customer::query();
      //
        if($traceEmployee == NULL){ 
          $traceEmployee = ["-"];
          $traceEmployee_condition =  'whereNot';
        }else{
          $traceEmployee_condition =  'where';
        }

        if($groupDebtlist == NULL) {
          $groupDebtlist = ["-"];
          $groupDebtlist_condition =  'whereNot';
        }else{
          $groupDebtlist_condition =  'where';
        }

        if($searchstatus == NULL){
          $searchstatus = ["-"];
          $searchstatus_condition = 'whereNot';
        }else{
          $searchstatus_condition =  'where';
        }

        if($nonlist == NULL){
          $nonlist = ["-"];
          $nonlist_condition =  'whereNot';
        }else{
          $nonlist_condition =  'where';
        }

        if($searchtype == NULL){
          $searchtype_condition =  'whereNot';
        }else{
          $searchtype_condition =  'where';
        }


         if ($type == 0){
          $typename = 'ลูกค้าทั้งหมด';
          foreach ($traceEmployee as $select){
            foreach ($groupDebtlist as $selects){
              foreach ($searchstatus as $selectss){
                   $customer->orWhere
                   ->$traceEmployee_condition('traceEmployee', '=', $select)
                   ->$nonlist_condition('Branch','=',$nonlist)
                   ->$groupDebtlist_condition('groupDebt','=',$selects)
                   ->$searchstatus_condition('status','=',$selectss)
                   ->$searchtype_condition('typeLoan','=',$searchtype)
                   ->where('contractNumber','LIKE','%'.$searchtracknumber.'%')
                   ->where('teamGroup','=',$numteam);
  
              }
            } 
          }
          $customers = $customer->orderBy('dealDay', 'ASC');   
          $countresulttype = $customers->count();
         }
         else if ($type == 1){ // ค้นหาหน้าหัวหน้า (PAST2,PAST3 รวม)
          $typename = 'PAST2,PAST3 PLM';

          foreach ($traceEmployee as $select){
            foreach ($groupDebtlist as $selects){
              foreach ($searchstatus as $selectss){
                   $customer->orWhere
                   ->$traceEmployee_condition('traceEmployee', '=', $select)
                   ->$nonlist_condition('Branch','=',$nonlist)
                   ->$groupDebtlist_condition('groupDebt','=',$selects)
                   ->$searchstatus_condition('status','=',$selectss)
                   ->$searchtype_condition('typeLoan','=',$searchtype)
                   ->where('contractNumber','LIKE','%'.$searchtracknumber.'%')
                   ->where('teamGroup','=',$numteam)
                   ->whereIn('groupDebt',['4.PAST 2','5.PAST 3'])->where('typeLoan','=', '1')
                   ->where('teamGroup','=', $numteam);
                    
              }
            } 
          }
           $customers = $customer->orderBy('dealDay', 'ASC'); 
           $countresulttype = $customers->count();
         }
         else if ($type == 2){ // ค้นหาหน้าหัวหน้า สัญญา PLM ส่งรายงานหัวหน้า ,ส่งรายงาน GM
          $typename = 'สัญญา PLM ส่งรายงานหัวหน้า ,ส่งรายงาน GM (ไม่รวม Past2,Past3)';

          foreach ($traceEmployee as $select){
            foreach ($groupDebtlist as $selects){
              foreach ($searchstatus as $selectss){
                   $customer->orWhere
                   ->$traceEmployee_condition('traceEmployee', '=', $select)
                   ->$nonlist_condition('Branch','=',$nonlist)
                   ->$groupDebtlist_condition('groupDebt','=',$selects)
                   ->$searchstatus_condition('status','=',$selectss)
                   ->$searchtype_condition('typeLoan','=',$searchtype)
                   ->where('contractNumber','LIKE','%'.$searchtracknumber.'%')
                   ->where('teamGroup','=',$numteam)
                   ->whereIn('status',['ส่งหัวหน้า','ส่ง GM'])->whereNotIn('groupDebt',['4.PAST 2','5.PAST 3'])->where('typeLoan','=', '1')
                   ->where('teamGroup','=', $numteam);
                    
              }
            } 
          }
           $customers = $customer->orderBy('dealDay', 'ASC'); 
           $countresulttype = $customers->count();
         }
         else if ($type == 3){ // สัญญา 50 ส่งรายงานหัวหน้า ,ส่งรายงาน GM
          $typename =  "สัญญา 50 ส่งรายงานหัวหน้า ,ส่งรายงาน GM (ไม่รวม Past2,Past3)";
          foreach ($traceEmployee as $select){
            foreach ($groupDebtlist as $selects){
              foreach ($searchstatus as $selectss){
                   $customer->orWhere
                   ->$traceEmployee_condition('traceEmployee', '=', $select)
                   ->$nonlist_condition('Branch','=',$nonlist)
                   ->$groupDebtlist_condition('groupDebt','=',$selects)
                   ->$searchstatus_condition('status','=',$selectss)
                   ->$searchtype_condition('typeLoan','=',$searchtype)
                   ->where('contractNumber','LIKE','%'.$searchtracknumber.'%')
                   ->where('teamGroup','=',$numteam)
                   ->whereIn('status',['ส่งหัวหน้า','ส่ง GM'])->whereNotIn('groupDebt',['4.PAST 2','5.PAST 3'])->where('typeLoan','=', '2')
                   ->where('teamGroup','=', $numteam);
                    
              }
            } 
          }
           $customers = $customer->orderBy('dealDay', 'ASC'); 
           $countresulttype = $customers->count();
         }
         else if ($type == 5){
          $typename = implode(',',$traceEmployee);
            foreach ($groupDebtlist as $selects){
              foreach ($searchstatus as $selectss){
                   $customer->orWhere
                   ->$traceEmployee_condition('traceEmployee', '=', $traceEmployee)
                   ->$nonlist_condition('Branch','=',$nonlist)
                   ->$groupDebtlist_condition('groupDebt','=',$selects)
                   ->$searchstatus_condition('status','=',$selectss)
                   ->$searchtype_condition('typeLoan','=',$searchtype)
                   ->where('contractNumber','LIKE','%'.$searchtracknumber.'%')
                   ->where('teamGroup','=',$numteam);
  
              }
            } 
         
          $customers = $customer->orderBy('dealDay', 'ASC');  
          $countresulttype = $customers->count(); 
         }

         else if ($type == 6){ // อัพเดทล่าสุดวันนี้
          $typename = 'อัพเดทล่าสุดวันนี้';
  
          foreach ($traceEmployee as $select){
            foreach ($groupDebtlist as $selects){
              foreach ($searchstatus as $selectss){
                   $customer->orWhere
                   ->$traceEmployee_condition('traceEmployee', '=', $select)
                   ->$nonlist_condition('Branch','=',$nonlist)
                   ->$groupDebtlist_condition('groupDebt','=',$selects)
                   ->$searchstatus_condition('status','=',$selectss)
                   ->$searchtype_condition('typeLoan','=',$searchtype)
                   ->where('contractNumber','LIKE','%'.$searchtracknumber.'%')
                   ->whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'DESC')
                   ->where('teamGroup','=',$numteam);
                  
                    
              }
            } 
          }
           $customers = $customer->orderBy('traceEmployee', 'ASC'); 
           $countresulttype = $customers->count();
         }
         else if ($type == 7){ // นัดชำระวันนี้
          $typename = 'นัดชำระวันนี้';

          foreach ($traceEmployee as $select){
            foreach ($groupDebtlist as $selects){
                   $customer->orWhere
                   ->$traceEmployee_condition('traceEmployee', '=', $select)
                   ->$nonlist_condition('Branch','=',$nonlist)
                   ->$groupDebtlist_condition('groupDebt','=',$selects)
                   ->$searchtype_condition('typeLoan','=',$searchtype)
                   ->where('contractNumber','LIKE','%'.$searchtracknumber.'%')
                   ->where('status','=','นัดชำระ')->where('paymentDate','=',Carbon::today()->format('Y-m-d'))
                   ->where('teamGroup','=',$numteam);
            } 
          }
           $customers = $customer->orderBy('traceEmployee', 'ASC'); 
           $countresulttype = $customers->count();
         }
         
         if($searchtype == 1){
          $loan = 'PLM';
        }else if($searchtype == 2){
          $loan = '30-50';
        }else{
          $loan = "-";
        }
        $result = 
        'NON : '.implode(" และ ",$nonlist).' | ประเภทสัญญา : '.$loan.' | ทีมตาม(ใน) :' .implode(" และ ",$traceEmployee).' | กลุ่มค้างงวด :'.implode(" และ ",$groupDebtlist).
        ' | สถานะ : '.implode(" และ ",$searchstatus).' | เลขที่สัญญา : '.$searchtracknumber;

        $resultChecked = array_merge($traceEmployee,$nonlist,$groupDebtlist,$searchstatus);
        $countresultChecked = count($resultChecked);
        $zone = $traceEmployee[0];
        $countresultSearch = count($customer->get());
        $countresult = count(tbl_customer::where('teamGroup','=',$numteam )->orderBy('dealDay', 'ASC')->get());
        $customers = $customers->paginate();
        $searchValue = $searchtracknumber;
        $namestatus = '';
        $namecode =  $searchtype;
        $countdateline = count(tbl_customer::where('status','=','นัดชำระ')->where('teamGroup','=',$numteam )->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->get());
        $countupdatetoday = count(tbl_customer::where('teamGroup','=',$numteam)->whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'ASC')->get());
        $links = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $customers->withPath($links);
    

        $countupdatetoday = count(tbl_customer::where('teamGroup','=',$numteam )->whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'ASC')->get());

         if ($type == 0 || $type == 5 || $type == 6 || $type == 7){
          return view('data_head.view_head',compact('customers','namecode','searchValue','namestatus','countresult','traceEmployee','groupDebt','statuslist','emplist','result','non','branch','teamtumlists','teamtonglists','countresultPass','countresultfoll','countresultSearch','countupdatetoday','countdateline','countupdatetoday','type','zone','typename','countresulttype','resultChecked','countresultChecked')) ;

         }else if ($type == 1 || $type == 2 || $type == 3){
          return view('data_head.view_Cus_head',compact('customers','namecode','searchValue','namestatus','countresult','countresulttype','traceEmployee','groupDebt','statuslist','emplist','result','non','branch','teamtumlists','teamtonglists','countresultPass','countresultfoll','countresultSearch','countupdatetoday','countdateline','countupdatetoday','type','typename','resultChecked','countresultChecked')) ;
         }
    }
    public function dashboard(Request $request)
    {
      $positionUser = Auth::user()->position;
      $branchUser = Auth::user()->Branch;
  
        $getnum = $request->get('tablehead') ;
        $typeLoan = $request->get('typeloan');

      if($getnum !='KAI')
      {
        if($getnum == ''&&$typeLoan == ''&& Auth::user()->position == 'headA'){
          $getnum=1;
          $typeLoan=1;
          $head = 'ทีม A';
          $column = 'PLM';
        
        }else if($getnum == ''&&$typeLoan == ''&& Auth::user()->position == 'headB'){
          $getnum=2;
          $typeLoan=1;
          $head = 'ทีม B';
          $column = 'PLM';
        }else if($getnum == ''&&$typeLoan == ''&& Auth::user()->position == 'admin'){
          $getnum=1;
          $typeLoan=1;
          $head = 'ทีม A';
          $column = 'PLM';
        }else if($getnum == '1'&&$typeLoan == '1'){
          $column = 'PLM';
          $head = 'ทีม A';
        }else if($getnum == '1'&&$typeLoan == '2'){
          $getnum= $getnum;
          $typeLoan=$typeLoan;
          $head = 'ทีม A';
          $column = '50/30';
        }else if($getnum == '2'&&$typeLoan == '1'){
          $getnum= $getnum;
          $typeLoan=$typeLoan;
          $head = 'ทีม B';
          $column = 'PLM';
        }else if($getnum == '2'&&$typeLoan == '2'){
          $getnum= $getnum;
          $typeLoan=$typeLoan;
          $head = 'ทีม B';
          $column = '50/30';
        }else if($getnum == '3'&&$typeLoan == '1'){
          $getnum= $getnum;
          $typeLoan=$typeLoan;
          $head = 'ทีม C';
          $column = 'PLM';
        }else if($getnum == '3'&&$typeLoan == '2'){
          $getnum= $getnum;
          $typeLoan=$typeLoan;
          $head = 'ทีม C';
          $column = '50/30';
        }else{
          $head = 'อื่นๆ';
        }
        
        $num = tbl_customer::distinct()->where('teamGroup','=',$getnum)->count('traceEmployee');
        $traceEmployee = tbl_customer::where('teamGroup','=',$getnum)->distinct()->get('traceEmployee');  
        $traceEmployeecount = count($traceEmployee);
        for($i = 0; $i < $num ; $i++){

          /*-- ตรวจสอบคอลัมน์ รวม ค่าว่าเป็น 0 หรือไม่ --*/ 

          $count[$i] = tbl_customer::where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
          $pass[$i] =  tbl_customer::where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
          if($count[$i]==0 || $pass[$i]==0)  {
            $count[$i] =  $count[$i];
            $pass[$i] = '-';
            $resultpercent[$i] = '-';
          }else{
            $resultpercent[$i] = number_format(($pass[$i]/$count[$i])*100,2);
          }
  
          /*-- ตรวจสอบคอลัมน์ Befor ค่าว่าเป็น 0 หรือไม่ --*/ 
          $countBefor[$i] = tbl_customer::where('groupDebt','=','1.Befor')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
          $passBefor[$i] =  tbl_customer::where('groupDebt','=','1.Befor')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
          if($countBefor[$i]==0 || $passBefor[$i]==0)  {
            $countBefor[$i] =  $countBefor[$i];
            $passBefor[$i] =  '-';
            $passpercenBefor[$i] =  '-';
          }else{
            $passpercenBefor[$i] = number_format(($passBefor[$i]) /($countBefor[$i])*100,2);
          }
          /*-- ตรวจสอบคอลัมน์ Normal ค่าว่าเป็น 0 หรือไม่ --*/ 
          $countNomal[$i]= tbl_customer::where('groupDebt','=','2.Nomal')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
          $passNomal[$i] = tbl_customer::where('groupDebt','=','2.Nomal')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
          if($countNomal[$i]==0 || $passNomal[$i] ==0)  {
            $countNomal[$i]=  $countNomal[$i];
            $passNomal[$i] = '-';
            $passpercenNomal[$i] =  '-';
          }else{
            $passpercenNomal[$i] = number_format(($passNomal[$i]) /($countNomal[$i])*100,2);
          }
          /*-- ตรวจสอบคอลัมน์ Past1 ค่าว่าเป็น 0 หรือไม่ --*/ 
          $countPast1[$i]= tbl_customer::where('groupDebt','=','3.Past 1')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
          $passPast1[$i] = tbl_customer::where('groupDebt','=','3.Past 1')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
          if($countPast1[$i]==0 || $passPast1[$i] ==0)  {
            $countPast1[$i]=  $countPast1[$i];
            $passPast1[$i] = '-';
            $passpercenPast1[$i] =  '-';
          }else{
            $passpercenPast1[$i] = number_format(($passPast1[$i]) /($countPast1[$i])*100,2);
          }
          /*-- ตรวจสอบคอลัมน์ Past2 ค่าว่าเป็น 0 หรือไม่ --*/ 
          $countPast2[$i]= tbl_customer::where('groupDebt','=','4.Past 2')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
          $passPast2[$i] = tbl_customer::where('groupDebt','=','4.Past 2')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
          if($countPast2[$i]==0 || $passPast2[$i] ==0)  {
            $countPast2[$i]= $countPast2[$i];
            $passPast2[$i] = '-';
            $passpercenPast2[$i] =  '-';
          }else{
            $passpercenPast2[$i] = number_format(($passPast2[$i]) /($countPast2[$i])*100,2);
          }
          /*-- ตรวจสอบคอลัมน์ Past3 ค่าว่าเป็น 0 หรือไม่ --*/ 
          $countPast3[$i]= tbl_customer::where('groupDebt','=','5.Past 3')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
          $passPast3[$i] = tbl_customer::where('groupDebt','=','5.Past 3')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
          if($countPast3[$i]==0 || $passPast3[$i] ==0)  {
            $countPast3[$i]=   $countPast3[$i];
            $passPast3[$i] =  '-';
            $passpercenPast3[$i] = '-';
          }else{
            $passpercenPast3[$i] = number_format(($passPast3[$i]) /($countPast3[$i])*100,2);
          }
          /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นรวม ค่าว่าเป็น 0 หรือไม่ --*/ 
          $followCustomers[$i] = intval($countPast1[$i])+intval($countPast2[$i])+intval($countPast3[$i]);
          $totalpass[$i]= intval($passPast1[$i])+intval($passPast2[$i])+intval($passPast3[$i]);
          if($followCustomers[$i]==0 || $totalpass[$i] ==0)  {
            $followCustomers[$i] =  $followCustomers[$i];
            $totalpass[$i]=  '-';
            $totalpercen[$i] = '-';
          }else{
            $totalpercen[$i] = number_format(($totalpass[$i]) /($followCustomers[$i])*100,2);
          }

         /*-- ตรวจสอบคอลัมน์ ไม่ผ่าน ค่าว่าเป็น 0 หรือไม่ --*/ 
          $totalnotpass[$i] =  intval($followCustomers[$i]) - intval($totalpass[$i]);
          if($totalnotpass[$i] == 0){
            $totalnotpass[$i] = '-';
          }else{
            $totalnotpass[$i] =  $totalnotpass[$i] ;
          }

            // เก็บค่าใน dataDashboard
          $dataDashboard[$i] = [
               
              "traceEmployee" => $traceEmployee[$i]->traceEmployee,

                  // คอลัมน์รวม
                "รวม (รวม)"  => $count[$i],
                "รวม (ผ่าน)"  =>  $pass[$i],
                "รวม (%)"   => $resultpercent[$i],
                
                 // คอลัมน์Befor
                "Befor (รวม)"  => $countBefor[$i],
                "Befor (ผ่าน)" => $passBefor[$i],
                "Befor (%)"   =>  $passpercenBefor[$i], 
                  
                 // คอลัมน์Nomal
                 "Nomal (รวม)"  => $countNomal[$i],
                 "Nomal (ผ่าน)" =>  $passNomal[$i] ,               
                 "Nomal (%)"   =>  $passpercenNomal[$i],
                 // คอลัมน์Past 1
                 "Past1 (รวม)"  =>  $countPast1[$i],
                 "Past1 (ผ่าน)" =>  $passPast1[$i],              
                 "Past1 (%)"   => $passpercenPast1[$i],
                 // คอลัมน์Past 2
                 "Past2 (รวม)"  =>  $countPast2[$i],
                 "Past2 (ผ่าน)" =>  $passPast2[$i] ,           
                 "Past2 (%)"   => $passpercenPast2[$i],
                 // คอลัมน์Past 3
               
                 "Past3 (รวม)" =>   $countPast3[$i],
                 "Past3 (ผ่าน)" =>  $passPast3[$i] ,
                 "Past3 (%)" =>    $passpercenPast3[$i],

                  //คอลัมน์จำนวนลูกค้าที่ต้องตาม
                  "จำนวนลูกค้าที่ต้องตาม"=> $followCustomers[$i],
                     
                 //คอลัมน์ผ่าน
                 "ผ่าน"=> $totalpass[$i],
                     
                 //คอลัมน์ไม่ผาน
                 "ไม่ผาน"=>  $totalnotpass[$i],
                     
                     
                 //คอลัมน์เปอร์เซ็นทั้งหมด
                     
                 "เปอร์เซ็นทั้งหมด" =>  @$totalpercen[$i] , 

    
          ];

         
          /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นแถว รวม ค่าว่าเป็น 0 หรือไม่ --*/ 
            $total[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('typeLoan','=',$typeLoan)->count();
            $totalpass[$i] = tbl_customer:: where('teamGroup','=',$getnum)->where('typeLoan','=',$typeLoan) ->where('status','=','ผ่าน')->count();
            
            if($total[$i]==0 || $totalpass[$i] ==0)  {
              $total[$i]= $total[$i];
              $totalpass[$i] = '-';
              $totalpercen[$i] =  '-';
            }else{
              $totalpercen[$i] = number_format(($totalpass[$i]) /($total[$i])*100,2);
            }
            /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นแถว Befor ค่าว่าเป็น 0 หรือไม่ --*/ 
           $totalBefor[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','1.Befor')->where('typeLoan','=',$typeLoan)->count();
           $totalBeforpass[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','1.Befor')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
           if($totalBefor[$i]==0 || $totalBeforpass[$i] ==0)  {
            $totalBeforpass[$i] = '-';
            $totalBefor[$i] =   $totalBefor[$i] ;
            $totalpercen[$i] = '-';
            $percenBefor[$i] = '-';
          }else{
            $percenBefor[$i] = number_format(($totalBeforpass[$i]) /($totalBefor[$i])*100,2);
          }
            /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นแถว Nomal ค่าว่าเป็น 0 หรือไม่ --*/ 
           $totalNomal[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','2.Nomal')->where('typeLoan','=',$typeLoan)->count();
           $totalNomalPass[$i] = tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','2.Nomal')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
           if($totalNomal[$i]==0 || $totalNomalPass[$i] ==0)  {
            $totalNomal[$i] =  $totalNomal[$i];
            $totalNomalPass[$i] = '-';
            $totalpercen[$i] =  '-';
            $percenNomal[$i] ='-';
          }else{
            $percenNomal[$i] = number_format(($totalNomalPass[$i]) /($totalNomal[$i])*100,2);
          }
           /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นแถว Past1 ค่าว่าเป็น 0 หรือไม่ --*/ 
         $totalPast1[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('typeLoan','=',$typeLoan)->count();
         $totalPast1Pass[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1') ->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
         if($totalPast1[$i]==0 || $totalPast1Pass[$i] ==0)  {
          $totalPast1[$i] =  $totalPast1[$i];
          $totalPast1Pass[$i] = '-';
          $percenPast1[$i] =  '-';
        }else{
          $percenPast1[$i] = number_format(($totalPast1Pass[$i]) /($totalPast1[$i])*100,2);
        }   
          /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นแถว Past2 ค่าว่าเป็น 0 หรือไม่ --*/ 
         $totalPast2[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('typeLoan','=',$typeLoan)->count();
         $totalPast2Pass[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2') ->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
         if($totalPast2[$i]==0 || $totalPast2Pass[$i] ==0)  {
          $totalPast2[$i] =  $totalPast2[$i];
          $totalPast2Pass[$i] = '-';
          $percenPast2[$i] =  '-';
        }else{
          $percenPast2[$i] = number_format(($totalPast2Pass[$i]) /($totalPast2[$i])*100,2);
        }  
          
          /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นแถว Past3 ค่าว่าเป็น 0 หรือไม่ --*/ 
         $totalPast3[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('typeLoan','=',$typeLoan)->count();
         $totalPast3Pass[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3') ->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
         if($totalPast3[$i]==0 || $totalPast3Pass[$i] ==0)  {
          $totalPast3Pass[$i] =  '-';
          $totalPast3[$i] =  $totalPast3[$i] ;
          $percenPast3[$i] =  '-';
        }else{
          $percenPast3[$i] = number_format(($totalPast3Pass[$i]) /($totalPast3[$i])*100,2);
        }    
        
         /*-- ตรวจสอบคอลัมน์ % ค่าว่าเป็น 0 หรือไม่ --*/
         $totalfollowCus[$i] = 
         tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('typeLoan','=',$typeLoan)->count() +
         tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('typeLoan','=',$typeLoan)->count() +
         tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('typeLoan','=',$typeLoan)->count() ;

          $totalfollowCusPass[$i] = 
         tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count() +
         tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count() +
         tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count() ;

         if($totalfollowCus[$i]==0 || $totalfollowCusPass[$i] ==0)  {
          $totalfollowCusPass[$i] = '-';
          $totalfollowCus[$i] =  $totalfollowCus[$i];
          $percenPast3[$i] = '-';
        }else{
          $totalPercen[$i] = number_format(($totalfollowCusPass[$i]) /($totalfollowCus[$i])*100,2);
        }  
         /*-- ตรวจสอบคอลัมน์ ไม่ผ่าน ค่าว่าเป็น 0 หรือไม่ --*/
         $totalfollowCusnotPass[$i] = 
        tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('status','=','ไม่ผ่าน')->where('typeLoan','=',$typeLoan)->count() +
        tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('status','=','ไม่ผ่าน')->where('typeLoan','=',$typeLoan)->count() +
        tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('status','=','ไม่ผ่าน')->where('typeLoan','=',$typeLoan)->count() ;
          
        if($totalfollowCusnotPass[$i]==0)  {
          $totalfollowCusnotPass[$i] = '-';
        } 
        else{
          $totalfollowCusnotPass[$i] =$totalfollowCusnotPass[$i];
        }

           // สรุปรวมในตาราง
            $result = [
                  //
                  "รวม (รวม)" => $total[$i] ,
                  "รวม (ผ่าน)" => $totalpass[$i],
                  "รวม (%)"  => $totalpercen[$i],
                    
                  "Befor (รวม)" => $totalBefor[$i] ,
                  "Befor (ผ่าน)" => $totalBeforpass[$i],
                  "Befor (%)" => $percenBefor[$i],
  
                  "Nomal (รวม)" =>  $totalNomal[$i],
                  "Nomal (ผ่าน)" => $totalNomalPass[$i],
                  "Nomal (%)" => $percenNomal[$i],
  
                  "Past1 (รวม)" =>  $totalPast1[$i],
                  "Past1 (ผ่าน)" => $totalPast1Pass[$i],
                  "Past1 (%)" => $percenPast1[$i],
  
                  "Past2 (รวม)"  =>  $totalPast2[$i],
                  "Past2 (ผ่าน)" => $totalPast2Pass[$i],
                  "Past2 (%)"  => $percenPast2[$i],
  
                  "Past3 (รวม)"=>  $totalPast3[$i],
                  "Past3 (ผ่าน)" => $totalPast3Pass[$i],
                  "Past3 (%)"=> $percenPast3[$i],
  
                   // จำนวนลูกค้าที่ต้องตาม
                   "จำนวนลูกค้าที่ต้องตาม" => $totalfollowCus[$i],
                   //ผ่าน
                   "ผ่าน" => $totalfollowCusPass[$i],
                   //ไม่ผ่าน
                   "ไม่ผาน" => $totalfollowCusnotPass[$i],  
                   //เปอร์เซ็นทั้งหมด
                   "เปอร์เซ็นทั้งหมด" => @$totalPercen[$i],
            ];
       
        }  
        
                    //chart
                    $beforAll =     tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','1.Befor')->where('typeLoan','=',$typeLoan)->count();
                    $befor =        tbl_customer:: where('teamGroup','=',$getnum) ->where('groupDebt','=','1.Befor')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
                    $beforNotpass = $beforAll - $befor;
                  
                    $nomalAll =     tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','2.Nomal')->where('typeLoan','=',$typeLoan)->count();
                    $nomal =        tbl_customer:: where('teamGroup','=',$getnum) ->where('groupDebt','=','2.Nomal')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
                    $nomalNotpass = $nomalAll - $nomal ; 
                  
                    $past1All =     tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('typeLoan','=',$typeLoan)->count();
                    $past1 =        tbl_customer:: where('teamGroup','=',$getnum) ->where('groupDebt','=','3.Past 1')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
                    $past1Notpass =  $past1All - $past1 ; 
                  
                    $past2All =     tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('typeLoan','=',$typeLoan)->count();
                    $past2 =        tbl_customer:: where('teamGroup','=',$getnum) ->where('groupDebt','=','4.Past 2')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
                    $past2Notpass =  $past2All - $past2 ; 
                  
                    $past3All =     tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('typeLoan','=',$typeLoan)->count();
                    $past3 =        tbl_customer:: where('teamGroup','=',$getnum) ->where('groupDebt','=','5.Past 3')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
                    $past3Notpass =  $past3All - $past3 ; 
                  
                    $emplist = tbl_traceEmployee::where('teamGroup','=',$getnum)->orderBy('teamGroup', 'ASC')->get();
                    $countupdatetoday = count(tbl_customer::where('teamGroup','=',$getnum )->whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'ASC')->get());
                    $countdateline = count(tbl_customer::where('status','=','นัดชำระ')->where('teamGroup','=',$getnum )->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->get());

  
      
                      //Calculate percent

                      $totalCus = tbl_customer::where('teamGroup','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); // ลูกค้าทั้งหมด
                      $totalCusPass = tbl_customer::where('status','=','ผ่าน')->where('teamGroup','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); // ลูกค้าทั้งหมดที่ผ่าน
                      $totalCusNotPass = tbl_customer::whereNot('status','=','ผ่าน')->where('teamGroup','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); // ลูกค้าทั้งหมดยกเว้นคนที่ผ่าน
                      $totalpowerApp = tbl_customer::where('powerApp','!=','')->where('teamGroup','=',$getnum)->where('typeLoan','=',$typeLoan)->count(); //จำนวนการลง power app
                         if($totalCus==0 || $totalpowerApp==0){
                           $percenfiled = 0;
                         }else{
                           $percenfiled = number_format(($totalpowerApp/$totalCus) * 100,2); // เปอร์เซ็นการลงพื้นที่  
                         }
                         if($totalCus==0 || $totalCusNotPass==0){
                           $percenNotPass = 0;
                         }else{
                           $percenNotPass = number_format(($totalCusNotPass/$totalCus)*100,2); //เปอร์เซ็นลูกค้าทั้งหมดที่ไม่ผ่าน
                         }
                         if($totalCus==0 || $totalCusPass==0){
                           $percenPass = 0;
                         }else{
                           $percenPass = number_format(($totalCusPass/$totalCus)*100,2); //เปอร์เซ็นลูกค้าที่ผ่านทั้งหมด
                         }
      
       
        return view('data_head.dashboard_head',compact('befor','beforNotpass','nomal','nomalNotpass','past1','past1Notpass','past2','past2Notpass','past3','past3Notpass','count','pass','countBefor','passBefor','countNomal','passNomal', 'countPast1',
        'passPast1','countPast2' ,'passPast2','countPast3','passPast3','dataDashboard','traceEmployeecount','num','result','head','column','emplist','countupdatetoday','countdateline','percenfiled','percenNotPass','percenPass','percenfiled','percenNotPass',
        'percenPass'
        ));
      }
    

         
          
    }
    public function customerHeader(Request $request)
    {
      $position = Auth::user()->position;
      if($position == 'headA'){
        $num = '1';
      }else{
        $num = '2';
      }
      $type = $request->get('type');
      if($type == '' || $type == '1'){
       $typename = 'PAST2,PAST3 PLM';
       $customers = tbl_customer::whereIn('groupDebt',['4.PAST 2','5.PAST 3'])->where('typeLoan','=', '1')
       ->where('teamGroup','=', $num)
       ->orderBy('dealDay', 'ASC');
      }else if($type == '2'){
        $typename = 'สัญญา PLM ส่งรายงานหัวหน้า ,ส่งรายงาน GM (ไม่รวม Past2,Past3)';
        $customers = tbl_customer::whereIn('status',['ส่งหัวหน้า','ส่ง GM'])->whereNotIn('groupDebt',['4.PAST 2','5.PAST 3'])->where('typeLoan','=', '1')
        ->where('teamGroup','=', $num)
        ->orderBy('dealDay', 'ASC');
      } else if($type == '3'){
        $typename =  "สัญญา 50 ส่งรายงานหัวหน้า ,ส่งรายงาน GM (ไม่รวม Past2,Past3)";
        $customers = tbl_customer::whereIn('status',['ส่งหัวหน้า','ส่ง GM'])->whereNotIn('groupDebt',['4.PAST 2','5.PAST 3'])->where('typeLoan','=', '2')
        ->where('teamGroup','=', $num)
        ->orderBy('dealDay', 'ASC');
      }else if($type == '0'){
        $typename = "";
        $customers = tbl_customer::
        where('teamGroup','=', $num)
        ->orderBy('dealDay', 'ASC');
      }


       $groupDebt = tbl_groupdebt::orderby('groupDebtID', 'ASC')->get();     

       $statuslist = tbl_statustype::orderBy('id', 'ASC')->get();
       $countresulttype = count($customers->get());
       $customers =  $customers->paginate();     
       $links = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
       $customers->withPath($links);
       $non = tbl_non::orderBy('id', 'ASC')->get();
       $branch = tbl_customer::select('Branch')->distinct()->get();
       $emplist = tbl_traceEmployee::where('teamGroup','=',$num)->orderBy('teamGroup', 'ASC')->get();
       $teamtumlists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','1')->get();
       $teamtonglists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','2')->get();
       $countresult = count(tbl_customer::where('teamGroup','=',$num )->orderBy('dealDay', 'ASC')->get());
       $countdateline = count(tbl_customer::where('status','=','นัดชำระ')->where('teamGroup','=',$num )->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->get());
       $countresultPass = count(tbl_customer::where('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('teamGroup','=',$num )->get());
       $countresultfoll = count(tbl_customer::whereNot('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('teamGroup','=',$num )->get());
       $countupdatetoday = count(tbl_customer::where('teamGroup','=',$num )->whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'ASC')->get());
      $tag = 1;

        return view('data_head.view_Cus_head', compact('customers','groupDebt','statuslist','emplist','non','branch','teamtumlists','teamtonglists','countresult','typename','countupdatetoday','countdateline','countresultPass','countresultfoll','countresulttype','tag','type','links')); 
    }
}
