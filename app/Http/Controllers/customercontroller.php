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
use App\Imports\UsersImport;


use App\Exports\exportDataCustomers;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class customercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    public function index()
    {
      $positionUser = Auth::user()->position;
      $branchUser = Auth::user()->Branch;
      if ($positionUser == 'admin'){
       
        $customers = tbl_customer::orderBy('dealDay', 'ASC')->paginate();
        $countresult = count(tbl_customer::orderBy('dealDay', 'ASC')->get());
        $countresultPass = count(tbl_customer::where('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->get());
        $countresultfoll = count(tbl_customer::whereNot('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->get());
     
      } else if ($positionUser == 'headA'){
        $customers = tbl_customer::where('teamGroup','=','1')->orderBy('dealDay', 'ASC')->paginate();
        $countresult = count(tbl_customer::where('teamGroup','=','1')->orderBy('dealDay', 'ASC')->get());
        $countresultPass = count(tbl_customer::where('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('traceEmployee','=',$branchUser)->get()); 
        $countresultfoll = count(tbl_customer::whereNot('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('traceEmployee','=',$branchUser)->get());
      } else{
        $customers = tbl_customer::where('teamGroup','=','2')->orderBy('dealDay', 'ASC')->paginate();
        $countresult = count(tbl_customer::where('teamGroup','=','2')->orderBy('dealDay', 'ASC')->get());
        $customers = tbl_customer::where('teamGroup','=','1')->orderBy('dealDay', 'ASC')->paginate();
        $countresult = count(tbl_customer::where('teamGroup','=','1')->orderBy('dealDay', 'ASC')->get());
        $countresultPass = count(tbl_customer::where('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('traceEmployee','=',$branchUser)->get()); 
        $countresultfoll = count(tbl_customer::whereNot('status','=','ผ่าน')->orderBy('dealDay', 'ASC')->where('traceEmployee','=',$branchUser)->get());
        
        $dateline = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$branchUser)->where('paymentDate','=',Carbon::today()->format('Y-m-d'))->get();

        $countdateline = count($dateline);
        $countresult = count( tbl_customer::where('traceEmployee','=',$branchUser)->get());

        $datelineytd = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$branchUser)->where('paymentDate','=',Carbon::yesterday()->format('Y-m-d'))->get();
        $countdatelineytd = count($datelineytd);

        $datelinetmr = tbl_customer::where('status','=','นัดชำระ')->where('traceEmployee','=',$branchUser)->where('paymentDate','=',Carbon::tomorrow()->format('Y-m-d'))->get();
        $countdatelinetmr = count($datelinetmr);
      }
        $groupDebt = tbl_groupdebt::orderby('groupDebtID', 'ASC')->get();

        $statuslist = tbl_statustype::orderBy('statusID', 'ASC')->get();

        $non = tbl_non::orderBy('id', 'ASC')->get();
        $branch = tbl_customer::select('Branch')->distinct()->get();
        $emplist = tbl_traceEmployee::where('teamGroup','=','1')->orWhere('teamGroup','=','2')->orwhere('teamGroup','=','2')->orWhere('employeeName','=','KAI')->orderBy('teamGroup', 'ASC')->get();
         
        $teamtumlists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','1')->get();
        $teamtonglists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','2')->get();
       // $countresult = count($customers);
       $emplist = tbl_traceEmployee::where('teamGroup','=',$branchUser)->orderBy('teamGroup', 'ASC')->get();
     
     
        return view('customers.index', compact('customers','groupDebt','statuslist','emplist','non','branch','teamtumlists','teamtonglists','countresult','countresultPass','countresultfoll','emplist'
        ,'non','branch','teamtumlists','teamtonglists','countresultPass','countresultfoll','dateline','countdateline','datelineytd','countdatelineytd','datelinetmr','countdatelinetmr')); 
    
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
      $positionUser = Auth::user()->position;
       $teamtumlists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','1')->get();
       $teamtonglists = tbl_customer::select('traceEmployee')->distinct()->where('teamGroup','=','2')->get();
      
        $teamGroup = $request->get('teamGroup');
        $traceEmployee = $request->get('traceEmployee');
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
        
        $customer = tbl_customer::query();

        if(!empty($traceEmployee) && !empty($groupDebtlist) && !empty($searchstatus) && empty($nonlist)){    
        
          foreach ($traceEmployee as $select) {
            foreach ($groupDebtlist as $selects) {
              foreach ($searchstatus as $selectss) {
               $customer->orWhere('traceEmployee', '=', $select)->where('groupDebt','=',$selects)->where('status','=',$selectss)->orderBy('Dealday', 'ASC');
              }
          } 
        }
        $result = 'ทีมตาม(ใน) :'.implode(" และ ",$traceEmployee).'|กลุ่มค้างงวด :'.implode(" และ ",$groupDebtlist).'|สถานะ :'.implode(" และ ",$searchstatus);
        $traceEmployee =  'เทส';
         }else if( !empty($traceEmployee) && !empty($groupDebtlist) && !empty($searchstatus)  && !empty($nonlist) ){    
        
          foreach ($traceEmployee as $select) {
            foreach ($groupDebtlist as $selects) {
              foreach ($searchstatus as $selectss) {
                foreach ($nonlist as $selectsss) {
               $customer->orWhere('traceEmployee', '=', $select)->where('groupDebt','=',$selects)->where('status','=',$selectss)->where('Branch','=',$selectsss)->orderBy('Dealday', 'ASC');
              }
            }
          } 
        }
        $result ='NON: '.implode(" และ ",$nonlist).' | ทีมตาม(ใน): '.implode(" และ ",$traceEmployee).' | กลุ่มค้างงวด : '.implode(" และ ",$groupDebtlist).' | สถานะ : '.implode(" และ ",$searchstatus);
        $traceEmployee =  'เทส';
         } else if(!empty($traceEmployee) && !empty($searchstatus) ){ 

        if(count($traceEmployee) > count($searchstatus)){
          foreach ($traceEmployee as $select) {
            foreach ($searchstatus as $selects) {
               $customer->orWhere('traceEmployee', '=', $select)->where('status','=',$selects)->orderBy('Dealday', 'ASC');
          } 
        }
        }else if(count($traceEmployee) <= count($searchstatus)){
          foreach ($searchstatus as $select) {
            foreach ($traceEmployee as $selects) {
               $customer->orWhere('status', '=', $select)->where('traceEmployee','=',$selects)->orderBy('Dealday', 'ASC');
          } 
        } 
      }

          $result = 'ทีมตาม(ใน) :'.implode(" และ ",$traceEmployee).'|สถานะ :'.implode(" และ ",$searchstatus);
          $traceEmployee = implode(",",$traceEmployee);
     
      } 
      


      else if(!empty($searchtype) && !empty($groupDebtlist) && !empty($traceEmployee)) { 
           
        foreach ($groupDebtlist as $selects) {
          foreach ($traceEmployee as $select) {
          $customer->orWhere('traceEmployee', '=', $select)
          ->where('typeLoan', '=', $searchtype)
          ->where('groupDebt','=',$selects)
          ->orderBy('Dealday', 'ASC');
          
        
          }
        } 
     
    if($searchtype == 1){
      $loan = 'PLM';
    }else{
      $loan = '30-50';
    }
    $result =  'ประเภทสัญญา :'.$loan.' | กลุ่มค้างงวด :'.implode(" และ ",$groupDebtlist).' | กลุ่มค้างใน :'.implode(" และ ",$traceEmployee);
    } 


      
      else if(!empty($traceEmployee && !empty($groupDebtlist)) ){ 
          if(count($traceEmployee) > count($groupDebtlist)){
            foreach ($traceEmployee as $select) {
              foreach ($groupDebtlist as $selects) {
            $customer->orWhere('traceEmployee', '=', $select)->where('groupDebt','=',$selects)->orderBy('Dealday', 'ASC');
            } 
          }
  
          } else if(count($traceEmployee) <= count($groupDebtlist)){
            foreach ($groupDebtlist as $select) {
              foreach ($traceEmployee as $selects) {
            $customer->orWhere('groupDebt', '=', $select)->where('traceEmployee','=',$selects)->orderBy('Dealday', 'ASC');
            } 
          } 
          }
            $result =  'ทีมตาม(ใน) :'.implode(" และ ",$traceEmployee).'|กลุ่มค้างงวด :'.implode(" และ ",$groupDebtlist);
           
            $traceEmployee = implode(",",$traceEmployee);
       
          }
          else if(!empty($searchtype) && !empty($groupDebtlist) && !empty($searchstatus)) { 
           
            foreach ($groupDebtlist as $selects) {
              foreach ($searchstatus as $select) {
              $customer->orWhere('status', '=', $select)
              ->where('typeLoan', '=', $searchtype)
              ->where('groupDebt','=',$selects)
              ->orderBy('Dealday', 'ASC');
              
            
              }
            } 
         
        if($searchtype == 1){
          $loan = 'PLM';
        }else{
          $loan = '30-50';
        }
        $result =  'ประเภทสัญญา :'.$loan.' | กลุ่มค้างงวด :'.implode(" และ ",$groupDebtlist).' | สถานะ :'.implode(" และ ",$searchstatus);
        }else if(!empty($groupDebtlist) && !empty($searchstatus)){ 
            foreach ($groupDebtlist as $select) {
              foreach ($searchstatus as $selects) {
            $customer->orWhere('groupDebt', '=', $select)->where('status','=',$selects)->orderBy('Dealday', 'ASC');
            } 
          } 
          $result =  'กลุ่มค้างงวด :'.implode(" และ ",$groupDebtlist).'|สถานะ :'.implode(" และ ",$searchstatus);
          
        } else if(!empty($nonlist && !empty($traceEmployee)) ){ 
            foreach ($nonlist as $select) {
              foreach ($traceEmployee as $selects) {
            $customer->orWhere('Branch', '=', $select)->where('traceEmployee','=',$selects)->orderBy('Dealday', 'ASC');
            } 
          } 
          $result =  'ทีมตาม(ใน) :'.implode(" และ ",$traceEmployee).'|NON :'.implode(" และ ",$nonlist);
          $traceEmployee = implode(",",$traceEmployee);
          
        } else if(!empty($groupDebtlist && !empty($nonlist)) ){ 
            foreach ($groupDebtlist as $select) {
              foreach ($nonlist as $selects) {
            $customer->orWhere('groupDebt', '=', $select)->where('Branch','=',$selects)->orderBy('Dealday', 'ASC');
            } 
          } 
          $result =  'กลุ่มค้างงวด :'.implode(" และ ",$groupDebtlist).'|NON :'.implode(" และ ",$nonlist);
          
        } else if(!empty($searchstatus) && !empty($nonlist)){ 
            foreach ($searchstatus as $select) {
              foreach ($nonlist as $selects) {
            $customer->orWhere('status', '=', $select)->where('Branch','=',$selects)->orderBy('Dealday', 'ASC');
            } 
          } 
          $result =  'สถานะ :'.implode(" และ ",$searchstatus).'|NON :'.implode(" และ ",$nonlist);
          }

          else if(!empty($searchtype) && !empty($nonlist)) { 
           
              foreach ($nonlist as $selects) {
            $customer->orWhere('typeLoan', '=', $searchtype)->where('Branch','=',$selects)->orderBy('Dealday', 'ASC');
             
          } 
          if($searchtype == 1){
            $loan = 'PLM';
          }else{
            $loan = '30-50';
          }
          $result =  'ประเภทสัญญา :'.$loan.' | NON :'.implode(" และ ",$nonlist);
          }

        else if(!empty($searchtype) && !empty($searchstatus)) { 
           
            foreach ($searchstatus as $selects) {
              $customer->orWhere('typeLoan', '=', $searchtype)->where('status','=',$selects)->orderBy('Dealday', 'ASC');
           
           } 
                if($searchtype == 1){
                  $loan = 'PLM';
                }else{
                  $loan = '30-50';
                }
            $result =  'ประเภทสัญญา :'.$loan.' | สถานะ :'.implode(" และ ",$searchstatus);
        }

          else if(!empty($searchtype) && !empty($traceEmployee)) { 
           
            foreach ($traceEmployee as $selects) {
              $customer->orWhere('typeLoan', '=', $searchtype)->where('traceEmployee','=',$selects)->orderBy('Dealday', 'ASC');
               
            } 
         
        if($searchtype == 1){
          $loan = 'PLM';
        }else{
          $loan = '30-50';
        }
        $result =  'ประเภทสัญญา :'.$loan.' | ทีมตามใน :'.implode(" และ ",$traceEmployee);
        }

        else if(!empty($searchtype) && !empty($groupDebtlist)) { 
           
          foreach ($groupDebtlist as $selects) {
            $customer->orWhere('typeLoan', '=', $searchtype)->where('groupDebt','=',$selects)->orderBy('Dealday', 'ASC');
             
          } 
       
      if($searchtype == 1){
        $loan = 'PLM';
      }else{
        $loan = '30-50';
      }
      $result =  'ประเภทสัญญา :'.$loan.' | ทีมตามใน :'.implode(" และ ",$groupDebtlist);
      }

      


          else if(!empty($searchstatus)){     
          foreach ($searchstatus as $select) {
            $customer->orWhere('status', '=', $select)->orderBy('Dealday', 'ASC');
            }
            // $searchstatus = implode(",",$searchstatus);   
            $result ='สถานะ :'.implode(" และ ",$searchstatus);
    
        }
          else if(!empty($groupDebtlist)){     
          foreach ($groupDebtlist as $select) {
            $customer->orWhere('groupDebt', '=', $select)->orderBy('Dealday', 'ASC');
            }
            $result = 'กลุ่มค้างงวด :'.implode(" และ ",$groupDebtlist);
        
      
        } else if(!empty($traceEmployee)){ 
          if($traceEmployee == '1' || $traceEmployee == '2' ){

            foreach ($traceEmployee as $select) {
            $customer->orWhere('teamGroup','=',$select)->orderBy('Dealday', 'ASC');
            return compact('customer');
            }
            
          }else{    

          foreach ($traceEmployee as $select) {
            $customer->orWhere('traceEmployee', '=', $select)->orderBy('Dealday', 'ASC');
            }

          }
            $result = 'ทีมตามใน :'.implode(" และ ",$traceEmployee);
            $traceEmployee = implode(",",$traceEmployee);
        
          }else if(!empty($nonlist)){     
            foreach ($nonlist as $select) {
              $customer->orWhere('Branch', '=', $select)->orderBy('Dealday', 'ASC');
              }
              $result = 'NON :'.implode(" และ ",$nonlist);
          
          }else if(!empty($searchtracknumber)){     
            
                $customer->orWhere('contractNumber', 'Like','%'.$searchtracknumber.'%')
                ->orWhere('firstname', 'Like','%'.$searchtracknumber.'%')
                ->orWhere('lastname', 'Like','%'.$searchtracknumber.'%')
                ->orWhere('traceEmployee', 'Like','%'.$searchtracknumber.'%')
                ->orWhere('groupDebt', 'Like','%'.$searchtracknumber.'%')
                ->orWhere('status', '=',$searchtracknumber)
                ->orderBy('Dealday', 'ASC');
                

                $result = $searchtracknumber;
            
          }else if(!empty($searchtype)){
            $customer->orWhere('typeLoan', '=',$searchtype)->orderBy('Dealday', 'ASC');

            if($searchtype == '1'){
              $result = 'ประเภทสัญญา : สัญญา PLM';
            }else {
              $result = 'ประเภทสัญญา : สัญญา 30-50';
            }
        

          }else{
              return redirect()->route('index');
            }    

         $customers =$customer->get();

        
         $countresult = count($customers);
         $searchValue = $searchtracknumber;
         $namestatus = '';
         $namecode =  $searchtype;
         return view('customers/showcustomer',compact('customers','namecode','searchValue','namestatus','countresult','countresult','traceEmployee','groupDebt','statuslist','emplist','result','non','branch','teamtumlists','teamtonglists')) ;
       
        
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
       $customer->Recorder = Auth::user()->Branch;
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
  
        if($positionUser == 'admin' || $positionUser == 'headA' || $positionUser == 'headB'){

        $getnum = $request->get('tablehead') ;
        $typeLoan = $request->get('typeloan');

        if($getnum !='KAI'){


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
        //$traceEmployee = ["HDY","JN"];  
        //$traceEmployee = ["HDY","SK","HYN","BPRU","JN","NT1","NT2","TEPA","RPHU","SING","HQ","KHKA","LNGU","ST","PTL","MKRE","KCHI","PPYN","GHRA"];
        $traceEmployeecount = count($traceEmployee);
        for($i = 0; $i < $num ; $i++){
            $dataDashboard[$i] = [
               
              "traceEmployee" => $traceEmployee[$i]->traceEmployee,
                 // รวม
                 "countSK" => $countSK[$i] = tbl_customer::where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
                 "SKpass" =>  $SKpass[$i] = tbl_customer::where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count() ,
                $passpercen[$i] = number_format((($SKpass[$i]+0.0001)/($countSK[$i]+0.0001))*100,2),
                 // Befor
                 "countSKBefor" =>  $countSKBefor[$i] = tbl_customer::where('groupDebt','=','1.Befor')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
                 "SKpassBefor" => $SKpassBefor[$i] = tbl_customer::where('groupDebt','=','1.Befor')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
                  $passpercenBefor[$i] = number_format((($SKpassBefor[$i]+0.0001) /($countSKBefor[$i]+0.0001) )*100,2),
                 // Nomal
                 "countSKNomal" => $countSKNomal[$i]= tbl_customer::where('groupDebt','=','2.Nomal')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
                 "SKpassNomal" =>  $SKpassNomal[$i] = tbl_customer::where('groupDebt','=','2.Nomal')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
                
                  $passpercenNomal[$i] = number_format((($SKpassNomal[$i]+0.0001) /($countSKNomal[$i]+0.0001) )*100,2),
                 // Past 1
                 "countSKPast1" =>  $countSKPast1[$i]= tbl_customer::where('groupDebt','=','3.Past 1')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
                 "SKpassPast1" =>  $SKpassPast1[$i] = tbl_customer::where('groupDebt','=','3.Past 1')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
               
                  $passpercenPast1[$i] = number_format((($SKpassPast1[$i]+0.0001) /($countSKPast1[$i]+0.0001) )*100,2),
                 // Past 2
                 "countSKPast2" =>  $countSKPast2[$i]= tbl_customer::where('groupDebt','=','4.Past 2')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
                 "SKpassPast2" =>  $SKpassPast2[$i] = tbl_customer::where('groupDebt','=','4.Past 2')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
                
                 $passpercenPast2[$i] = number_format((($SKpassPast2[$i]+0.0001) /($countSKPast2[$i]+0.0001) )*100,2),
                 // Past 3
               
                 "countSKPast3" =>  $countSKPast3[$i]= tbl_customer::where('groupDebt','=','5.Past 3')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
                 "SKpassPast3" =>  $SKpassPast3[$i] = tbl_customer::where('groupDebt','=','5.Past 3')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
  
                  $passpercenPast3[$i] = number_format((($SKpassPast3[$i]+0.0001) /($countSKPast3[$i]+0.0001))*100,2),
             
         //จำนวนลูกค้าที่ต้องตาม
         "followCustomers"=> $followCustomers[$i] = $countSKPast1[$i]+$countSKPast2[$i]+$countSKPast3[$i],

        //ผ่าน
        "totalpass"=> $totalpass[$i]= $SKpassPast1[$i]+$SKpassPast2[$i]+$SKpassPast3[$i],

        //ไม่ผาน
        "totalnotpass"=>  $totalnotpass[$i] =  $followCustomers[$i] - $totalpass[$i],
      
   
        //เปอร์เซ็นทั้งหมด
  
        "totalpercen" =>  $totalpercen[$i] = number_format((($totalpass[$i]+0.0001) / ($followCustomers[$i] +0.0001))*100,0) , 

    
            ];

            $resultA = [
                "total" => $total[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('typeLoan','=',$typeLoan)->count(),
                "totalpass" => $totalpass[$i] = tbl_customer::
                  where('teamGroup','=',$getnum)
                ->where('typeLoan','=',$typeLoan)
                ->where('status','=','ผ่าน')->count(),
                "totalpercen" => $totalpercen[$i] = number_format((($totalpass[$i]+0.0001)/($total[$i]+0.0001))*100,2),

                "totalBefor" => $totalBefor[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','1.Befor')->where('typeLoan','=',$typeLoan)->count(),
                "totalBeforpass" => $totalBeforpass[$i] = tbl_customer::
                    where('teamGroup','=',$getnum)
                  ->where('groupDebt','=','1.Befor')
                  ->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count(),
                  "percenBefor" => $percenBefor = number_format((($totalBeforpass[$i]+0.0001)/($totalBefor[$i]+0.0001))*100,2),

                  "totalNomal" =>  $totalNomal[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','2.Nomal')->where('typeLoan','=',$typeLoan)->count(),
                  "totalNomalPass" => $totalNomalPass[$i] = tbl_customer::
                    where('teamGroup','=',$getnum)
                  ->where('groupDebt','=','2.Nomal')
                  ->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count(),
                  "percenNomal"=> $percenNomal = number_format((($totalNomalPass[$i]+0.0001)/($totalNomal[$i]+0.0001))*100,2),

                  "totalPast1" =>  $totalPast1[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('typeLoan','=',$typeLoan)->count(),
                  "totalPast1Pass" => $totalPast1Pass[$i] = tbl_customer::
                    where('teamGroup','=',$getnum)
                  ->where('groupDebt','=','3.Past 1')
                  ->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count(),
                  "percenPast1"=> $percenPast1 = number_format((($totalPast1Pass[$i]+0.0001)/($totalPast1[$i]+0.0001))*100,2),

                  "totalPast2" =>  $totalPast2[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('typeLoan','=',$typeLoan)->count(),
                  "totalPast2Pass" => $totalPast2Pass[$i] = tbl_customer::
                    where('teamGroup','=',$getnum)
                  ->where('groupDebt','=','4.Past 2')
                  ->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count(),
                  "percenPast2"=> $percenPast2 = number_format((($totalPast2Pass[$i]+0.0001)/($totalPast2[$i]+0.0001))*100,2),

                  "totalPast3" =>  $totalPast3[$i] = tbl_customer::where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('typeLoan','=',$typeLoan)->count(),
                  "totalPast3Pass" => $totalPast3Pass[$i] = tbl_customer::
                    where('teamGroup','=',$getnum)
                  ->where('groupDebt','=','5.Past 3')
                  ->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count(),
                  "percenPast3"=> $percenPast3 = number_format((($totalPast3Pass[$i]+0.0001)/($totalPast3[$i]+0.0001)*100+0.0001),2),


                    // จำนวนลูกค้าที่ต้องตาม
                    "totalfollowCus" => $totalfollowCus[$i] = 
                    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('typeLoan','=',$typeLoan)->count() +
                    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('typeLoan','=',$typeLoan)->count() +
                    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('typeLoan','=',$typeLoan)->count() ,
                    //ผ่าน
                    "totalfollowCusPass" => $totalfollowCusPass[$i] = 
                    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count() +
                    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count() +
                    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count() ,
                    //ไม่ผ่าน
                    "totalfollowCusnotPass" => $totalfollowCusnotPass[$i] = 
                    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','3.Past 1')->where('status','=','N')->where('typeLoan','=',$typeLoan)->count() +
                    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','4.Past 2')->where('status','=','N')->where('typeLoan','=',$typeLoan)->count() +
                    tbl_customer:: where('teamGroup','=',$getnum)->where('groupDebt','=','5.Past 3')->where('status','=','N')->where('typeLoan','=',$typeLoan)->count() ,
                    //เปอร์เซ็นทั้งหมด
                    "totalPercen"=> $totalPercen[$i] = number_format((($totalfollowCusPass[$i]+0.0001)/($totalfollowCus[$i]+0.0001))*100,2),
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

        

        //'befor','beforNotpass','nomal','nomalNotpass','past1','past1Notpass','past2','past2Notpass','past3','past3Notpass'
         
        
        $emplist = tbl_traceEmployee::where('teamGroup','=',$getnum)->orderBy('teamGroup', 'ASC')->get();

        return view('customers.dashboard',compact('befor','beforNotpass','nomal','nomalNotpass','past1','past1Notpass','past2','past2Notpass','past3','past3Notpass','countSK','SKpass','countSKBefor','SKpassBefor','countSKNomal','SKpassNomal', 'countSKPast1',
        'SKpassPast1','countSKPast2' ,'SKpassPast2','countSKPast3','SKpassPast3','dataDashboard','traceEmployeecount','num','resultA','head','column','emplist'
        ));
      }else{


          if($typeLoan == 1){
            $totalKAIPLM =  tbl_customer::where('traceEmployee','=',$getnum)->where('typeloan','=',$typeLoan)->count();
            $totalKAIPassPLM =  tbl_customer::where('traceEmployee','=',$getnum)->where('typeloan','=',$typeLoan)->where('status','=','ผ่าน')->count();
            $totalPercenKAIPLM = number_format((($totalKAIPassPLM+0.0001) / ($totalKAIPLM+0.0001))*100,2);
            $column= 'PLM';
            $head = 'ทีม C';

            $befor=''; $beforNotpass=''; $nomal=''; $nomalNotpass=''; $past1=''; $past1Notpass=''; $past2=''; $past2Notpass =''; $past3=''; $past3Notpass ='';
            $emplist = tbl_traceEmployee::where('teamGroup','=',$getnum)->orderBy('teamGroup', 'ASC')->get();

            return view('customers.dashboard',compact('befor','beforNotpass','nomal','nomalNotpass','past1','past1Notpass','past2','past2Notpass','past3','past3Notpass','head','column','totalKAIPLM','totalKAIPassPLM','totalPercenKAIPLM','typeLoan','emplist'));

          }else if($typeLoan == 2){
            $totalKAI50=  tbl_customer::where('traceEmployee','=',$getnum)->where('typeloan','=',$typeLoan)->count();
            $totalKAIPass50 =  tbl_customer::where('traceEmployee','=',$getnum)->where('status','=','ผ่าน')->count();
            $totalPercenKAI50 =  number_format((($totalKAIPass50+0.0001) / ($totalKAI50+0.0001))*100,2);
            $column = '50-30';
            
            $head = 'ทีม C';

           // $chartstatus = 2;
           $befor=''; $beforNotpass=''; $nomal=''; $nomalNotpass=''; $past1=''; $past1Notpass=''; $past2=''; $past2Notpass =''; $past3=''; $past3Notpass ='';
           $emplist = tbl_traceEmployee::where('teamGroup','=',$getnum)->orderBy('teamGroup', 'ASC')->get();

            return view('customers.dashboard',compact('befor','beforNotpass','nomal','nomalNotpass','past1','past1Notpass','past2','past2Notpass','past3','past3Notpass','head','column','totalKAI50','totalKAIPass50','totalPercenKAI50','typeLoan','emplist'));

          }

          





      }
    }else {
      $getnum = $request->get('tablehead') ;
      $typeLoan = $request->get('typeloan');

      if($getnum !='KAI'){

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
      //$traceEmployee = tbl_customer::where('teamGroup','=',$getnum)->distinct()->get('traceEmployee');   
      $traceEmployee = tbl_customer::where('traceEmployee','=',$branchUser)->get();   
      //$traceEmployee = ["HDY","SK","HYN","BPRU","JN","NT1","NT2","TEPA","RPHU","SING","HQ","KHKA","LNGU","ST","PTL","MKRE","KCHI","PPYN","GHRA"];
      $traceEmployeecount = count($traceEmployee);
      for($i = 0; $i < $num ; $i++){
          $dataDashboard[$i] = [
             
            "traceEmployee" => $traceEmployee[$i]->traceEmployee,
               // รวม
               "countSK" => $countSK[$i] = tbl_customer::where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
               "SKpass" =>  $SKpass[$i] = tbl_customer::where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('status','=','ผ่าน')->where('typeLoan','=',$typeLoan)->count() ,
              $passpercen[$i] = number_format((($SKpass[$i]+0.0001)/($countSK[$i]+0.0001))*100,2),
               // Befor
               "countSKBefor" =>  $countSKBefor[$i] = tbl_customer::where('groupDebt','=','1.Befor')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
               "SKpassBefor" => $SKpassBefor[$i] = tbl_customer::where('groupDebt','=','1.Befor')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
                $passpercenBefor[$i] = number_format((($SKpassBefor[$i]+0.0001) /($countSKBefor[$i]+0.0001) )*100,2),
               // Nomal
               "countSKNomal" => $countSKNomal[$i]= tbl_customer::where('groupDebt','=','2.Nomal')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
               "SKpassNomal" =>  $SKpassNomal[$i] = tbl_customer::where('groupDebt','=','2.Nomal')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
              
                $passpercenNomal[$i] = number_format((($SKpassNomal[$i]+0.0001) /($countSKNomal[$i]+0.0001) )*100,2),
               // Past 1
               "countSKPast1" =>  $countSKPast1[$i]= tbl_customer::where('groupDebt','=','3.Past 1')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
               "SKpassPast1" =>  $SKpassPast1[$i] = tbl_customer::where('groupDebt','=','3.Past 1')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
             
                $passpercenPast1[$i] = number_format((($SKpassPast1[$i]+0.0001) /($countSKPast1[$i]+0.0001) )*100,2),
               // Past 2
               "countSKPast2" =>  $countSKPast2[$i]= tbl_customer::where('groupDebt','=','4.Past 2')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
               "SKpassPast2" =>  $SKpassPast2[$i] = tbl_customer::where('groupDebt','=','4.Past 2')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
              
               $passpercenPast2[$i] = number_format((($SKpassPast2[$i]+0.0001) /($countSKPast2[$i]+0.0001) )*100,2),
               // Past 3
             
               "countSKPast3" =>  $countSKPast3[$i]= tbl_customer::where('groupDebt','=','5.Past 3')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),
               "SKpassPast3" =>  $SKpassPast3[$i] = tbl_customer::where('groupDebt','=','5.Past 3')->where('status','=','ผ่าน')->where('traceEmployee','=',$traceEmployee[$i]->traceEmployee)->where('typeLoan','=',$typeLoan)->count(),

                $passpercenPast3[$i] = number_format((($SKpassPast3[$i]+0.0001) /($countSKPast3[$i]+0.0001))*100,2),
           
       //จำนวนลูกค้าที่ต้องตาม
       "followCustomers"=> $followCustomers[$i] = $countSKPast1[$i]+$countSKPast2[$i]+$countSKPast3[$i],

      //ผ่าน
      "totalpass"=> $totalpass[$i]= $SKpassPast1[$i]+$SKpassPast2[$i]+$SKpassPast3[$i],

      //ไม่ผาน
      "totalnotpass"=>  $totalnotpass[$i] =  $followCustomers[$i] - $totalpass[$i],
    
 
      //เปอร์เซ็นทั้งหมด

      "totalpercen" =>  $totalpercen[$i] = number_format((($totalpass[$i]+0.0001) / ($followCustomers[$i] +0.0001))*100,0) , 

  
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

      

      //'befor','beforNotpass','nomal','nomalNotpass','past1','past1Notpass','past2','past2Notpass','past3','past3Notpass'
       
      
      $emplist = tbl_traceEmployee::where('teamGroup','=',$getnum)->orderBy('teamGroup', 'ASC')->get();

      return view('customers.dashboard',compact('befor','beforNotpass','nomal','nomalNotpass','past1','past1Notpass','past2','past2Notpass','past3','past3Notpass','countSK','SKpass','countSKBefor','SKpassBefor','countSKNomal','SKpassNomal', 'countSKPast1',
      'SKpassPast1','countSKPast2' ,'SKpassPast2','countSKPast3','SKpassPast3','dataDashboard','traceEmployeecount','num','resultA','head','column','emplist'
      ));
    }else{


        if($typeLoan == 1){
          $totalKAIPLM =  tbl_customer::where('traceEmployee','=',$getnum)->where('typeloan','=',$typeLoan)->count();
          $totalKAIPassPLM =  tbl_customer::where('traceEmployee','=',$getnum)->where('typeloan','=',$typeLoan)->where('status','=','ผ่าน')->count();
          $totalPercenKAIPLM = number_format((($totalKAIPassPLM+0.0001) / ($totalKAIPLM+0.0001))*100,2);
          $column= 'PLM';
          $head = 'ทีม C';

          $befor=''; $beforNotpass=''; $nomal=''; $nomalNotpass=''; $past1=''; $past1Notpass=''; $past2=''; $past2Notpass =''; $past3=''; $past3Notpass ='';
          $emplist = tbl_traceEmployee::where('teamGroup','=',$getnum)->orderBy('teamGroup', 'ASC')->get();

          return view('customers.dashboard',compact('befor','beforNotpass','nomal','nomalNotpass','past1','past1Notpass','past2','past2Notpass','past3','past3Notpass','head','column','totalKAIPLM','totalKAIPassPLM','totalPercenKAIPLM','typeLoan','emplist'));

        }else if($typeLoan == 2){
          $totalKAI50=  tbl_customer::where('traceEmployee','=',$getnum)->where('typeloan','=',$typeLoan)->count();
          $totalKAIPass50 =  tbl_customer::where('traceEmployee','=',$getnum)->where('status','=','ผ่าน')->count();
          $totalPercenKAI50 =  number_format((($totalKAIPass50+0.0001) / ($totalKAI50+0.0001))*100,2);
          $column = '50-30';
          
          $head = 'ทีม C';

         // $chartstatus = 2;
         $befor=''; $beforNotpass=''; $nomal=''; $nomalNotpass=''; $past1=''; $past1Notpass=''; $past2=''; $past2Notpass =''; $past3=''; $past3Notpass ='';
         $emplist = tbl_traceEmployee::where('teamGroup','=',$getnum)->orderBy('teamGroup', 'ASC')->get();

          return view('customers.dashboard',compact('befor','beforNotpass','nomal','nomalNotpass','past1','past1Notpass','past2','past2Notpass','past3','past3Notpass','head','column','totalKAI50','totalKAIPass50','totalPercenKAI50','typeLoan','emplist'));

        }

        





    }
    }
         
          
    }
    public function export() 
    {
       return Excel::download(new exportDataCustomers, 'รายงานทีมติดตามหนี้.xlsx');
    }
    public function import() 
    {
        Excel::import(new UsersImport,request()->file('file'));
               
        return back();
    }
}

