<?php

namespace App\Exports;
use App\Models\staticComDebt;
use App\Models\staticSize;
use App\Models\tbl_customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;
use App\Models\CK_Model\tbl_contract;
use App\Models\tbl_staticcommission;
use App\Models\tbl_target;
use App\Models\tbl_traceEmployee;

class exportCom implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $Fdate = request('Fdate');
        $Tdate = request('Tdate');
        $data = tbl_contract::
        where('UserZone',20)
        ->with(['ConToCal' => function($query) {
            $query->select('Profit_Rate','DataTag_id','Cash_Car','Process_Car','Buy_PA','Include_PA','Insurance_PA','Process_Car','Process_Car','Tax2_Rate');
        }])
        ->WhereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"),[ '2023-10-01','2023-10-31'])
        ->orderBy('UserSent_Con','ASC')
        ->select('Contract_Con','Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con','UserSent_Con','Date_Checkers')
        ->get();
        return $data;

    }
    public function headings() :array
    {
        $data = [
            'เลขที่สัญญา','ประเภทสัญญา','วันที่โอนเงิน','ชื่อย่อ','สาขาที่ส่งจัด','ผู้ส่งจัด','ยอดจัด','ค่าดำเนินการ','ซื้อ/ไม่','ประกันPA','ดอกเบี้ยรวม','เปอร์เซ็นต์จัด','ผลตอบแทน','ลงพื้นที่',
            'ค่าน้ำมัน',
            "Size",
            "totalBefor",
            "PassBefor",
            "totalNomal",
            "PassNomal",
            "totalPast1",
            "PassPast1",
            "%",
            "คอม",
            "totalPast2",
            "PassPast2",
            "%",
            "คอม",
            "totalPast3",
            "PassPast3",
            "%",
            "คอม",
            "totalPast4",
            "PassPast4",
            "totalPast",
            "PassPast",
        ];
        return $data;

    }

    public function map($invoice): array
    {
        $data = tbl_contract::
        where('UserZone',20)
        ->where('BranchSent_Con',$invoice->BranchSent_Con)
        ->with(['ConToCal' => function($query) {
            $query->select('Profit_Rate','DataTag_id','Cash_Car','Process_Car','Buy_PA','Include_PA','Insurance_PA','Process_Car','Process_Car','Tax2_Rate');
        }])
        ->WhereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"),[ '2023-10-01','2023-10-31'])
        ->orderBy('UserSent_Con','ASC')
        ->select('Contract_Con','Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con','UserSent_Con','Date_Checkers')
        ->get();

        $emps = tbl_traceEmployee::where('IdCK',$invoice->BranchSent_Con)->first();
        $sum = 0;
            foreach($data as $con){
                $sum += ( $con->ConToCal->Cash_Car + $con->ConToCal->Insurance_PA +$con->ConToCal->Process_Car );
            }

        if($invoice->CodeLoan_Con == 04 || $invoice->CodeLoan_Con == 03){
            $totalInt = 0;
        }else{

            $totalInt = @$invoice->ConToCal->Profit_Rate - @$invoice->ConToCal->Tax2_Rate;
        }

        if(@$invoice->ConToCal->Buy_PA =='Yes'){
            $pa = 'YPA';
            $cashPa = $invoice->ConToCal->Insurance_PA;
        }else{
            $pa = 'NPA';
            $cashPa = 0;
        }
        // dump(@$emps->EmptoTarget->Target);
        if(@$emps->EmptoTarget->Target > 0){
            $percent = number_format(( $sum / @$emps->EmptoTarget->Target ) * 100,0);
        }else {
            $percent = 0;
        }
        $dataCom =  tbl_staticcommission::where('TypeLoans', @$invoice->CodeLoan_Con)
        ->whereRaw('? between StotalInterest and TtotalInterest', $totalInt)
        ->selectRaw('case when '.$percent.' < 80 then '.$pa.'70
        when '.$percent.' < 100 then '.$pa.'80
        when '.$percent.' < 120 then '.$pa.'100
        else  '.$pa.'120 end as Commission, TypeLoans,Gas')
         ->first();

        if(@$emps->employeeName != NULL){
            $dataPass = DB::select("
               SELECT
              traceEmployee,
              SUM(CASE WHEN groupDebt = '1.Befor'  THEN 1 ELSE 0 END) as 'totalBefor',
              SUM(CASE WHEN groupDebt = '1.Befor' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassBefor',
   
              SUM(CASE WHEN groupDebt = '2.Nomal'  THEN 1 ELSE 0 END) as 'totalNomal',
              SUM(CASE WHEN groupDebt = '2.Nomal' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassNomal',
   
              SUM(CASE WHEN groupDebt = '3.Past 1'  THEN 1 ELSE 0 END) as 'totalPast1',
              SUM(CASE WHEN groupDebt = '3.Past 1' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassPast1',
   
              SUM(CASE WHEN groupDebt = '4.Past 2'  THEN 1 ELSE 0 END) as 'totalPast2',
              SUM(CASE WHEN groupDebt = '4.Past 2' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassPast2',
   
              SUM(CASE WHEN groupDebt = '5.Past 3' or groupDebt = '6.Past 4'  THEN 1 ELSE 0 END) as 'totalPast',
              SUM(CASE WHEN groupDebt = '5.Past 3' or groupDebt = '6.Past 4' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassPast',
   
              SUM(CASE WHEN groupDebt = '5.Past 3'  THEN 1 ELSE 0 END) as 'totalPast3',
              SUM(CASE WHEN groupDebt = '5.Past 3' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassPast3',
   
              SUM(CASE WHEN groupDebt = '6.Past 4'  THEN 1 ELSE 0 END) as 'totalPast4',
              SUM(CASE WHEN groupDebt = '6.Past 4' and status = 'STS-005' THEN 1 ELSE 0 END) as 'PassPast4'
   
              FROM tbl_customers WHERE traceEmployee = '".@$emps->employeeName."'  ;
          ");

           
          $dataDebt = tbl_customer::where('traceEmployee',@$emps->employeeName)->get();
          $countEmp = $dataDebt->count();
          $checkSize = staticSize::
            where('SCount','<',$countEmp)
          ->where('LCount','>',$countEmp)
          ->first();
    
        
          if($checkSize->Size == 'S'){
            if(@$dataPass[0]->totalPast1 > 0){
                $perT = (@$dataPass[0]->PassPast1 /  @$dataPass[0]->totalPast1) * 100;
                  $dataComDebtPast1 = staticComDebt::where('Size', $checkSize->Size)
                  ->whereRaw('? between SPERTarget and LPERTarget', $percent)
                  ->selectRaw('
                    case 
                    when '.$perT.' >= 0 and '.$perT.' < 85 then 0
                    when '.$perT.' >= 85 and '.$perT.' < 90 then T_85
                    when '.$perT.' >= 90 and '.$perT.' < 95 then T_90
                    else  T_95 end as Commission'
                    )
                   ->first();    
              }
          } else {
              if(@$dataPass[0]->totalPast1 > 0){
                $perPast1 = (@$dataPass[0]->PassPast1 /  @$dataPass[0]->totalPast1) * 100;
                  $dataComDebtPast1 = staticComDebt::where('Size', $checkSize->Size)
                  ->whereRaw('? between SPERTarget and LPERTarget', $percent)
                  ->selectRaw('
                        case 
                        when '.$perPast1.' >= 0 and '.$perPast1.' < 85 then 0
                        when '.$perPast1.' >= 85 and '.$perPast1.' < 90 then Past1_85
                        when '.$perPast1.' >= 90 and '.$perPast1.' < 95 then Past1_90
                        else  Past1_95 end as Commission'
                    )
                   ->first();
        
                   
              }
              if(@$dataPass[0]->totalPast2 > 0){
                $perPast2 = (@$dataPass[0]->PassPast2 /  @$dataPass[0]->totalPast2) * 100;
                  $dataComDebtPast2 = staticComDebt::where('Size', $checkSize->Size)
                  ->whereRaw('? between SPERTarget and LPERTarget', $percent)
                  ->selectRaw('
                        case 
                        when '.$perPast2.' >= 0 and '.$perPast2.' < 85 then 0
                        when '.$perPast2.' >= 85 and '.$perPast2.' < 90 then Past2_85
                        when '.$perPast2.' >= 90 and '.$perPast2.' < 95 then Past2_90
                        else  Past2_95 end as Commission'
                    )
                   ->first();
        
                   
              }
              if(@$dataPass[0]->totalPast3 > 0){
                $perPast3 = (@$dataPass[0]->PassPast3 /  @$dataPass[0]->totalPast3) * 100;
                  $dataComDebtPast3 = staticComDebt::where('Size', $checkSize->Size)
                  ->whereRaw('? between SPERTarget and LPERTarget', $percent)
                  ->selectRaw('
                  case 
                  when '.$perPast3.' >= 0 and '.$perPast3.' < 85 then 0
                  when '.$perPast1.' >= 85 and '.$perPast3.' < 90 then Past3_85
                  when '.$perPast3.' >= 90 and '.$perPast3.' < 95 then Past3_90
                  else  Past3_95 end as Commission'
                    )
                   ->first();
        
              }
          }
        }

        return[
            @$invoice->Contract_Con,
            @$invoice->CodeLoan_Con,
            @$invoice->Date_monetary,
            @$emps->employeeName,
            @$invoice->ContractToBranch->Name_Branch,
            @$invoice->ContractToUserBranch->name,
            @$invoice->ConToCal->Cash_Car,
            @$invoice->ConToCal->Process_Car,
            @$pa,
            @$cashPa,
            @$invoice->ConToCal->Profit_Rate - @$invoice->ConToCal->Tax2_Rate,
            @$percent ,
            @$dataCom->Commission ,
            @$invoice->Date_Checkers,
            @$invoice->Date_Checkers != NULL ? $dataCom->Gas : 0,
            @$checkSize->Size,
            @$dataPass[0]->totalBefor,
            @$dataPass[0]->PassBefor,
            @$dataPass[0]->totalNomal,
            @$dataPass[0]->PassNomal,
            @$dataPass[0]->totalPast1,
            @$dataPass[0]->PassPast1,
            @$perPast1,
            @$dataComDebtPast1->Commission,
            @$dataPass[0]->totalPast2,
            @$dataPass[0]->PassPast2,
            @$perPast2,
            @$dataComDebtPast2->Commission,
            @$dataPass[0]->totalPast3,
            @$dataPass[0]->PassPast3,
            @$perPast3,
            @$dataComDebtPast3->Commission,
            @$dataPass[0]->totalPast4,
            @$dataPass[0]->PassPast4,
            @$dataPass[0]->totalPast,
            @$dataPass[0]->PassPast,
        ];

    }
}
