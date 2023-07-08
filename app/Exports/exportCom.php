<?php

namespace App\Exports;
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
        ->WhereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"),[ '2023-05-01','2023-05-31'])
        ->orderBy('UserSent_Con','ASC')
        ->select('Contract_Con','Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con','UserSent_Con','Date_Checkers')
        ->get();
        return $data;
 
    }
    public function headings() :array
    {
        $data = [
            'เลขที่สัญญา','วันที่โอนเงิน','สาขาที่ส่งจัด','ผู้ส่งจัด','ยอดจัด','ค่าดำเนินการ','ประกันPA','ดอกเบี้ยรวม','ผลตอบแทน','ลงพื้นที่','ค่าน้ำมัน'
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
        ->WhereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"),[ '2023-05-01','2023-05-31'])
        ->orderBy('UserSent_Con','ASC')
        ->select('Contract_Con','Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con','UserSent_Con','Date_Checkers')
        ->get();

        $emps = tbl_traceEmployee::select('id','IdCK')->where('IdCK',$invoice->BranchSent_Con)->first();
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
        }else{
            $pa = 'NPA';
        }

        $percent = number_format(( $sum / $emps->EmptoTarget->Target ) * 100,0);
        $dataCom =  tbl_staticcommission::where('TypeLoans', @$invoice->CodeLoan_Con)
        ->whereRaw('? between StotalInterest and TtotalInterest', $totalInt)
        ->selectRaw('case when '.$percent.' < 80 then '.$pa.'70  
        when '.$percent.' < 100 then '.$pa.'80  
        when '.$percent.' < 120 then '.$pa.'100  
        else  '.$pa.'120 end as Commission, TypeLoans,Gas')
         ->first();

        return[
            @$invoice->Contract_Con,
            @$invoice->Date_monetary,
            @$invoice->ContractToBranch->Name_Branch,
            @$invoice->ContractToUserBranch->name,
            @$invoice->ConToCal->Cash_Car,
            @$invoice->ConToCal->Process_Car,
            @$invoice->ConToCal->Insurance_PA,
            @$invoice->ConToCal->Profit_Rate - @$invoice->ConToCal->Tax2_Rate,
            $dataCom->Commission ,
            @$invoice->Date_Checkers,
            @$invoice->Date_Checkers != NULL ? $dataCom->Gas : 0,
        ];
       
    }
}
