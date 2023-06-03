<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;
use App\Models\CK_Model\tbl_contract;


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
        ->select('Contract_Con','Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con','UserSent_Con')
        ->get();
        return $data;
 
    }
    public function headings() :array
    {
        $data = [
            'เลขที่สัญญา','วันที่โอนเงิน','สาขาที่ส่งจัด','ผู้ส่งจัด','ยอดจัด','ค่าดำเนินการ','ประกันPA','ดอกเบี้ยรวม','ผลตอบแทน'
         ];
        return $data;

    }

    public function map($invoice): array
    {
        return[
            @$invoice->Contract_Con,
            @$invoice->id,
            @$invoice->Date_monetary,
            @$invoice->id,
            @$invoice->id,
            @$invoice->id,
            @$invoice->id,    
        ];
       
    }
}
