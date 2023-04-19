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


class UserController extends Controller
{
    public function index(Request $request)
    {
      $BranchUser = Auth::user()->Branch; // Check Branch User
      $type = $request->get('type');
      if($type == 1){
        $customers = tbl_customer::where('traceEmployee','=',$BranchUser)->orderBy('dealDay', 'ASC')->paginate(); // Get Data Customer 
        $links = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $customers->withPath($links);
        $typename = 'ลูกค้าทั้งหมด';
        $countresulttype =  tbl_customer::count();
     }
     elseif($type == 2){ //นัดชำระวันนี้
       $customers = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$BranchUser)->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->orderBy('dealDay', 'ASC')->paginate();
       $links = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
       $customers->withPath($links);
       $typename = 'นัดชำระวันนี้';
       $countresulttype = tbl_customer::whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'DESC')->count();
     }
     elseif($type == 3){ //นัดชำระเมื่อวาน
       $customers = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$BranchUser)->where('paymentDate','=',Carbon::yesterday()->format('Y-m-d'))->orderBy('dealDay', 'ASC')->paginate();
       $links = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
       $customers->withPath($links);
       $typename = 'นัดชำระเมื่อวาน';
       $countresulttype = tbl_customer::whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'DESC')->count();
     }
     elseif($type == 4){ //นัดชำระพรุ่งนี้
       $customers = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$BranchUser)->where('paymentDate','=',Carbon::tomorrow()->format('Y-m-d'))->orderBy('dealDay', 'ASC')->paginate();
       $links = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
       $customers->withPath($links);
       $typename = 'นัดชำระพรุ่งนี้';
       $countresulttype = tbl_customer::whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'DESC')->count();
     }
     elseif($type == 5){ //อัพเดทล่าสุดวันนี้
      $customers = tbl_customer::where('traceEmployee','=',$BranchUser)->whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'DESC')->paginate();
      $links = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      $customers->withPath($links);
      $typename = 'อัพเดทล่าสุดวันนี้';
      $countresulttype = tbl_customer::whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'DESC')->count();
    }

  

        $groupDebt = tbl_groupdebt::orderby('groupDebtID', 'ASC')->get();

        $statuslist = tbl_statustype::orderBy('statusID', 'ASC')->get();

        $non = tbl_non::orderBy('id', 'ASC')->get();
        $branch = tbl_customer::select('Branch')->distinct()->get();
        $emplist = tbl_traceEmployee::where('teamGroup','=','1')->orWhere('teamGroup','=','2')->orwhere('teamGroup','=','2')->orWhere('employeeName','=','KAI')->orderBy('teamGroup', 'ASC')->get();
         
        $teamtumlists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','1')->get();
        $teamtonglists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','2')->get();
        $countresult = count( tbl_customer::where('traceEmployee','=',$BranchUser)->get());
        $countresultPass = count(tbl_customer::where('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('traceEmployee','=',$BranchUser)->get());
        $countresultfoll = count(tbl_customer::whereNot('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('traceEmployee','=',$BranchUser)->get());
  

        $countdateline = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$BranchUser)->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->count();


        $countdatelineytd = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$BranchUser)->where('paymentDate','=',Carbon::yesterday()->format('Y-m-d'))->count();


        $countdatelinetmr = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$BranchUser)->where('paymentDate','=',Carbon::tomorrow()->format('Y-m-d'))->count();


        $countupdatetoday = tbl_customer::where('traceEmployee','=',$BranchUser)->whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'DESC')->count();

        $tag = 1;  //Check error 404 
        return view('data_User.homeUser', compact('customers','groupDebt','statuslist','emplist','non','branch','teamtumlists','teamtonglists','countresult','countresultPass','countresultfoll','countdateline','countdatelineytd','countdatelinetmr','tag','countupdatetoday','type','typename'));     

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

    public function search(Request $request)
    {  
      $positionUser = Auth::user()->Branch;
      $type = $request->get('type');

      //-- Request --//
      $teamtumlists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','1')->get();
      $teamtonglists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','2')->get();   
       $teamGroup = $request->get('teamGroup');
       $searchtype = $request->get('searchtype');
       $searchstatus = $request->get('searchstatus');
       $searchtracknumber = $request->get('searchtracknumber');
       $groupDebtlist = $request->get('groupDebt');
       $nonlist = $request->get('nonlist');
       $groupDebt = tbl_groupdebt::orderby('groupDebtID', 'ASC')->get();
       $statuslist = tbl_statustype::orderBy('statusID', 'ASC')->get();
       $non = tbl_non::orderBy('id', 'ASC')->get();
       $branch = tbl_customer::select('Branch')->distinct()->get();
       $emplist = tbl_traceEmployee::where('teamGroup','=','1')->orWhere('teamGroup','=','2')->orWhere('teamGroup','=','2')->orWhere('employeeName','=','KAI')->orderBy('teamGroup', 'ASC')->get();    
       $BranchUser = Auth::user()->Branch;
       $customer = tbl_customer::query();
      //
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


         if ($type == 1){ //ค้นหาลูกค้าทั้งหมด
          $typename='ลูกค้าทั้งหมด';
            foreach ($groupDebtlist as $selects){
              foreach ($searchstatus as $selectss){
                   $customer->orWhere
                   ->$nonlist_condition('Branch','=',$nonlist)
                   ->$groupDebtlist_condition('groupDebt','=',$selects)
                   ->$searchstatus_condition('status','=',$selectss)
                   ->$searchtype_condition('typeLoan','=',$searchtype)
                   ->where('contractNumber','LIKE','%'.$searchtracknumber.'%')
                   ->where('traceEmployee', '=', $positionUser);
              }
            } 
          }
          if ($type == 2){ //ค้นหานัดชำระวันนี้
            $typename='นัดชำระวันนี้';
            foreach ($groupDebtlist as $selects){            
                   $customer->orWhere
                   ->$nonlist_condition('Branch','=',$nonlist)
                   ->$groupDebtlist_condition('groupDebt','=',$selects)
                   ->where('status','=','นัดชำระ')
                   ->$searchtype_condition('typeLoan','=',$searchtype)
                   ->where('contractNumber','LIKE','%'.$searchtracknumber.'%')
                   ->where('paymentDate','=',Carbon::today()->format('Y-m-d'))
                   ->where('traceEmployee', '=', $positionUser);
              
            } 
          }
          if ($type == 3){ //ค้นหานัดชำระเมื่อวาน
            $typename='นัดชำระเมื่อวาน';
            foreach ($groupDebtlist as $selects){            
                   $customer->orWhere
                   ->$nonlist_condition('Branch','=',$nonlist)
                   ->$groupDebtlist_condition('groupDebt','=',$selects)
                   ->where('status','=','นัดชำระ')
                   ->$searchtype_condition('typeLoan','=',$searchtype)
                   ->where('contractNumber','LIKE','%'.$searchtracknumber.'%')
                   ->where('paymentDate','=',Carbon::yesterday()->format('Y-m-d'))
                   ->where('traceEmployee', '=', $positionUser);
              
            } 
          }
          if ($type == 4){ //ค้นหานัดชำระพรุ่งนี้
            $typename='นัดชำระพรุ่งนี้';
            foreach ($groupDebtlist as $selects){            
                   $customer->orWhere
                   ->$nonlist_condition('Branch','=',$nonlist)
                   ->$groupDebtlist_condition('groupDebt','=',$selects)
                   ->where('status','=','นัดชำระ')
                   ->$searchtype_condition('typeLoan','=',$searchtype)
                   ->where('contractNumber','LIKE','%'.$searchtracknumber.'%')
                   ->where('paymentDate','=',Carbon::tomorrow()->format('Y-m-d'))
                   ->where('traceEmployee', '=', $positionUser);
              
            } 
          }
          if ($type == 5){ //ค้นหารายการอัพเดทวันนี้
            $typename = 'อัพเดทล่าสุดวันนี้';
            foreach ($groupDebtlist as $selects){
              foreach ($searchstatus as $selectss){
                   $customer->orWhere
                   ->$nonlist_condition('Branch','=',$nonlist)
                   ->$groupDebtlist_condition('groupDebt','=',$selects)
                   ->$searchstatus_condition('status','=',$selectss)
                   ->$searchtype_condition('typeLoan','=',$searchtype)
                   ->whereDate('updated_at','=',Carbon::today())
                   ->where('contractNumber','LIKE','%'.$searchtracknumber.'%')
                   ->where('traceEmployee', '=', $positionUser);
              }
            } 
          }

        
            if($searchtype == 1){
              $loan = 'PLM';
            }else if($searchtype == 2){
              $loan = '30-50';
            }else{
              $loan = "-";
            }
            $result = 
            'NON : '.implode(" และ ",$nonlist).' | ประเภทสัญญา : '.$loan.' | กลุ่มค้างงวด :'.implode(" และ ",$groupDebtlist).
            ' | สถานะ : '.implode(" และ ",$searchstatus).' | เลขที่สัญญา : '.$searchtracknumber;

            $resultChecked = array_merge($nonlist,$groupDebtlist,$searchstatus);
            $countresultChecked = count($resultChecked);
            
            $customers =$customer->get();
            $countresultSearch = count($customers);
            $customers =$customer->orderBy('dealDay', 'ASC')->paginate();
            $countresultPass = count(tbl_customer::where('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('traceEmployee','=',$BranchUser)->get());
            $countresultfoll = count(tbl_customer::whereNot('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('traceEmployee','=',$BranchUser)->get());
            $searchValue = $searchtracknumber;
            $namestatus = '';
            $namecode =  $searchtype;
            $dateline = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$BranchUser)->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->get();
            $countdateline = count($dateline);
            $countresult = count( tbl_customer::where('traceEmployee','=',$BranchUser)->get());
   
            $datelineytd = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$BranchUser)->where('paymentDate','=',Carbon::yesterday()->format('Y-m-d'))->get();
            $countdatelineytd = count($datelineytd);
    
            $datelinetmr = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$BranchUser)->where('paymentDate','=',Carbon::tomorrow()->format('Y-m-d'))->get();
            $countdatelinetmr = count($datelinetmr);
            $countupdatetoday = tbl_customer::where('traceEmployee','=',$BranchUser)->whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'DESC')->count();

            $links = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $customers->withPath($links);
            return view('data_User.homeUser',compact('customers','namecode','searchValue','namestatus','countresult','countresult','groupDebt','statuslist','emplist','result','non','branch','teamtumlists','teamtonglists','countresultPass','countresultfoll','dateline','countdateline','countresultSearch','datelineytd','countdatelineytd','datelinetmr','countdatelinetmr','type','countupdatetoday','typename','resultChecked','countresultChecked')) ;

 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
  
       $request->validate([
        'statuschecks' => 'required',
       // 'paymentDate' => 'required',
       // 'fieldDay' => 'required',
        //'powerApp' => 'required',
        //'note' => 'required'
       ]);

       $customer = tbl_customer::find($id);
       $customer->status = $request->statuschecks;
       $customer->paymentDate= $request->paymentDate;
       $customer->fieldDay = $request->fieldDay;
       $customer->powerApp = $request->powerApp;
       $customer->note = $request->note;
       $customer->actionPlan = $request->actionPlan;
       $customer->save();

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
    public function dashboard(Request $request)
    {
      $positionUser = Auth::user()->position;
      $branchUser = Auth::user()->Branch;
  
      $getnum = $request->get('tablehead') ;
      $typeLoan = $request->get('typeloan');

      if($typeLoan == ''){
        $getnum=1;
        $typeLoan=1;
        $head = $branchUser;
        $column = 'PLM';
      
      }else if($typeLoan == '1'){

        $column = 'PLM';
        $head = $branchUser;
      }else if($typeLoan == '2'){
   
        $typeLoan=$typeLoan;
        $head = $branchUser;
        $column = '50/30';
      }else{
        $head = $branchUser;
      }
      
      $num = tbl_customer::distinct()->where('traceEmployee','=',$branchUser)->count('traceEmployee');
      $traceEmployee = tbl_customer::where('traceEmployee','=',$branchUser)->get();   
      $traceEmployeecount = count($traceEmployee);
      for($i = 0; $i < $num ; $i++){
         /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นรวม ค่าว่าเป็น 0 หรือไม่ --*/ 
        $countUser[$i] = tbl_customer::where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
        $countUserPass[$i] = tbl_customer::where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();

        if($countUser[$i] == 0 || $countUserPass[$i] == 0)  {
          $countUser[$i] =  $countUser[$i];
          $countUserPass[$i]=  '-';
          $passpercen[$i] = '-';
        }else{
          $passpercen[$i] = number_format(($countUserPass[$i]) /($countUser[$i])*100,2);
        }
         /*-- ตรวจสอบคอลัมน์ Befor ค่าว่าเป็น 0 หรือไม่ --*/ 
        $countBefor[$i] = tbl_customer::where('groupDebt','=','1.Befor')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
        $passBefor[$i] = tbl_customer::where('groupDebt','=','1.Befor')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();

        if($countBefor[$i] == 0 || $passBefor[$i] == 0)  {
          $countBefor[$i] =  $countBefor[$i];
          $passBefor[$i]=  '-';
          $passpercenBefor[$i] = '-';
        }else{
          $passpercenBefor[$i] = number_format(($passBefor[$i]) /($countBefor[$i])*100,2);
        }
          /*-- ตรวจสอบคอลัมน์ Nomal ค่าว่าเป็น 0 หรือไม่ --*/ 
        $countNomal[$i]= tbl_customer::where('groupDebt','=','2.Nomal')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
        $passNomal[$i] = tbl_customer::where('groupDebt','=','2.Nomal')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();  
          
        if($countNomal[$i] == 0 || $passNomal[$i] == 0)  {
          $countNomal[$i] = $countNomal[$i];
          $passNomal[$i]=  '-';
          $passpercenNomal[$i] = '-';
        }else{
          $passpercenNomal[$i] = number_format(($passNomal[$i]) /($countNomal[$i])*100,2);
        }

         /*-- ตรวจสอบคอลัมน์ Past 1 ค่าว่าเป็น 0 หรือไม่ --*/ 
         $countPast1[$i]= tbl_customer::where('groupDebt','=','3.Past 1')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
         $passPast1[$i] = tbl_customer::where('groupDebt','=','3.Past 1')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();  
           
         if($countPast1[$i] == 0 || $passPast1[$i] == 0)  {
           $countPast1[$i] =  $countPast1[$i];
           $passPast1[$i]=  '-';
           $passpercenPast1[$i] = '-';
         }else{
           $passpercenPast1[$i] = number_format(($passPast1[$i]) /($countPast1[$i])*100,2);
         }

          /*-- ตรวจสอบคอลัมน์ Past 2 ค่าว่าเป็น 0 หรือไม่ --*/ 
          $countPast2[$i]= tbl_customer::where('groupDebt','=','4.Past 2')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
          $passPast2[$i] = tbl_customer::where('groupDebt','=','4.Past 2')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();  
            
          if($countPast2[$i] == 0 || $passPast1[$i] == 0)  {
            $countPast2[$i] =  $countPast2[$i];
            $passPast2[$i]=  '-';
            $passpercenPast2[$i] = '-';
          }else{
            $passpercenPast2[$i] = number_format(($passPast2[$i]) /($countPast2[$i])*100,2);
          }

          /*-- ตรวจสอบคอลัมน์ Past 3 ค่าว่าเป็น 0 หรือไม่ --*/ 
          $countPast3[$i]= tbl_customer::where('groupDebt','=','5.Past 3')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();
          $passPast3[$i] = tbl_customer::where('groupDebt','=','5.Past 3')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count();  
            
          if($countPast3[$i] == 0 || $passPast1[$i] == 0)  {
            $countPast3[$i] =  $countPast3[$i];
            $passPast3[$i]=  '-';
            $passpercenPast3[$i] = '-';
          }else{
            $passpercenPast3[$i] = number_format(($passPast3[$i]) /($countPast3[$i])*100,2);
          }

           /*-- ตรวจสอบคอลัมน์ ลูกค้าที่ต้องตาม ค่าว่าเป็น 0 หรือไม่ --*/ 
           $followCustomers[$i] = intval($countPast1[$i])+intval($countPast2[$i])+intval($countPast3[$i]);
           if($followCustomers[$i] == 0){
             $followCustomers[$i] = '-';
           }
           /*-- ตรวจสอบคอลัมน์ ผ่าน ค่าว่าเป็น 0 หรือไม่ --*/ 
           $totalpass[$i] = intval($passPast1[$i])+intval($passPast2[$i])+intval($passPast3[$i]);
           if($totalpass[$i] == 0){
             $totalpass[$i] = '-';
           }
        
           /*-- ตรวจสอบคอลัมน์ ไม่ผ่าน ค่าว่าเป็น 0 หรือไม่ --*/ 
           $totalnotpass[$i] = intval($followCustomers[$i])-intval($totalpass[$i]);
           if($totalnotpass[$i] == 0){
             $totalnotpass[$i] = '-';
           }

          /*-- ตรวจสอบคอลัมน์ เปอร์เซ็นทั้งหมด ค่าว่าเป็น 0 หรือไม่ --*/ 
        
           if($totalpass[$i] != '-' || $followCustomers[$i] != '-'){
            $totalpercen[$i] = number_format(( intval($totalpass[$i]) / intval($followCustomers[$i]) )* 100,2);
           }else{
            $totalpercen[$i] = '-';
           }
           
         
        
        $dataDashboard[$i] = [       
              "สาขา" => $traceEmployee[$i]->traceEmployee,
               // รวม
               "รวม (รวม)" => $countUser[$i] ,
               "รวม (ผ่าน)" =>  $countUserPass[$i] ,
               "รวม (%)" => $passpercen[$i] ,
               // Befor
               "Befor (รวม)" =>  $countBefor[$i],
               "Befor (ผ่าน)"  => $passBefor[$i] ,
               "Befor (%)" => $passpercenBefor[$i],
               // Nomal
               "Nomal (รวม)" =>   $countNomal[$i],
               "Nomal (ผ่าน)" =>  $passNomal[$i],    
               "Nomal (%)" => $passpercenNomal[$i],
               // Past 1
               "Past1 (รวม)" =>  $countPast1[$i], 
               "Past1 (ผ่าน)" =>  $passPast1[$i],
               "Past1 (%)" => $passpercenPast1[$i],
               // Past 2
               "Past2 (รวม)" =>  $countPast2[$i],
               "Past2 (ผ่าน)"  =>  $passPast2[$i],
               "Past2 (%)" => $passpercenPast2[$i],
               // Past 3
      
               "Past3 (รวม)" =>  $countPast3[$i],
               "Past3 (ผ่าน)" =>  $passPast3[$i],
               "Past3 (%)" => $passpercenPast3[$i],
           
       //จำนวนลูกค้าที่ต้องตาม
       "จำนวนลูกค้าที่ต้องตาม" => $followCustomers[$i],

      //ผ่าน
      "ผ่าน" => $totalpass[$i],

      //ไม่ผาน
      "ไม่ผาน" =>  $totalnotpass[$i],
    
 
      //เปอร์เซ็นทั้งหมด

      "เปอร์เซ็นทั้งหมด" =>  $totalpercen[$i], 

  
          ];

      $resultA = '';
      }  
      //chart
      $beforAll =     tbl_customer::where('traceEmployee','=',$branchUser)->where('groupDebt','=','1.Befor')->where('typeLoan','=',$typeLoan)->count();
      $befor =        tbl_customer:: where('traceEmployee','=',$branchUser)->where('groupDebt','=','1.Befor')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
      $beforNotpass = $beforAll - $befor;

      $nomalAll =     tbl_customer::where('traceEmployee','=',$branchUser)->where('groupDebt','=','2.Nomal')->where('typeLoan','=',$typeLoan)->count();
      $nomal =        tbl_customer:: where('traceEmployee','=',$branchUser)->where('groupDebt','=','2.Nomal')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
      $nomalNotpass = $nomalAll - $nomal ; 

      $past1All =     tbl_customer::where('traceEmployee','=',$branchUser)->where('groupDebt','=','3.Past 1')->where('typeLoan','=',$typeLoan)->count();
      $past1 =        tbl_customer:: where('traceEmployee','=',$branchUser)->where('groupDebt','=','3.Past 1')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
      $past1Notpass =  $past1All - $past1 ; 

      $past2All =     tbl_customer::where('traceEmployee','=',$branchUser)->where('groupDebt','=','4.Past 2')->where('typeLoan','=',$typeLoan)->count();
      $past2 =        tbl_customer:: where('traceEmployee','=',$branchUser)->where('groupDebt','=','4.Past 2')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
      $past2Notpass =  $past2All - $past2 ; 

      $past3All =     tbl_customer::where('traceEmployee','=',$branchUser)->where('groupDebt','=','5.Past 3')->where('typeLoan','=',$typeLoan)->count();
      $past3 =        tbl_customer:: where('traceEmployee','=',$branchUser)->where('groupDebt','=','5.Past 3')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count();
      $past3Notpass =  $past3All - $past3 ; 
       
      
      $dateline = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$branchUser)->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->get();
      $countdateline = count($dateline);

      $datelineytd = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$branchUser)->where('paymentDate','=',Carbon::yesterday()->format('Y-m-d'))->get();
      $countdatelineytd = count($datelineytd);

      $datelinetmr = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$branchUser)->where('paymentDate','=',Carbon::tomorrow()->format('Y-m-d'))->get();
      $countdatelinetmr = count($datelinetmr);
      $countupdatetoday = tbl_customer::where('traceEmployee','=',$branchUser)->whereDate('updated_at','=',Carbon::today())->orderBy('updated_at', 'DESC')->count();

      $countAll = tbl_customer::where('traceEmployee','=',$branchUser)->where('typeLoan','=',$typeLoan)->count();
      $widgetPass = tbl_customer::where('status','=','ผ่าน')->where('traceEmployee','=',$branchUser)->where('typeLoan','=',$typeLoan)->count();//ผ่านทั้งหมด
      $widgetNotPass = tbl_customer::whereNot('status','=','ผ่าน')->where('traceEmployee','=',$branchUser)->where('typeLoan','=',$typeLoan)->count(); //ทุกสถานะที่ไม่ใช่ผ่าน
      $widgetfield = tbl_customer::where('status','=','ลงพื้นที่')->where('traceEmployee','=',$branchUser)->where('typeLoan','=',$typeLoan)->count();

      if($widgetPass == 0){
        $perwidgetPass = 0;
      }else{
        $perwidgetPass = number_format(($widgetPass / $countAll)*100,2);
      }
      if($widgetNotPass  == 0){
        $perwidgetNotPass  = 0;
      }else{
      $perwidgetNotPass = number_format(($widgetNotPass / $countAll)*100,2);
      }
      if($widgetfield  == 0){
        $perwidgetfield  = 0;
      }else{
      $perwidgetfield = number_format(($widgetfield / $countAll)*100,2);
      }
 
      
      return view('data_User.Dashboard_user',compact('befor','beforNotpass','nomal','nomalNotpass','past1','past1Notpass','past2','past2Notpass','past3','past3Notpass','countUser','countUserPass','countBefor','passBefor','countNomal','passNomal', 'countPast1',
      'passPast1','countPast2' ,'passPast2','countPast3','passPast3','dataDashboard','traceEmployeecount','num','resultA','head','column','dateline','countdateline','datelineytd','countdatelineytd','datelinetmr','countdatelinetmr',
      'perwidgetPass','perwidgetNotPass','perwidgetfield','countupdatetoday'
      ));
    
    }
         
          
    }

