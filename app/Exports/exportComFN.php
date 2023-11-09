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
use Maatwebsite\Excel\Events\AfterSheet;

class exportComFN implements FromCollection,WithHeadings,WithMapping
{

    public function __construct() // วันดีล
    {
        $this->SDueDate = '2023-09-01';
        $this->LDueDate = '2023-09-30';
    }

    public function headings() :array
    {
        $data = [
            'สาขา',
            'ชื่อไฟแนนซ์',
            'ลงพื้นที่',
            'ไม่ลงพื้นที่',
            'เคสรวม',
            'ค่าน้ำมัน',
            'ค่าการตลาด',
            'ผลตอบแทนไฟแนนซ์',
            'NON-STARTER ไฟแนนซ์',
            'รวมค่าคอมไฟแนนซ์',
            'ยอดหลังหักภาษีไฟแนนซ์',
            'ผลตอบแทนแอดมิน',
            'NON-STARTER แอดมิน',
            'รวมค่าคอมแอดมิน',
            'ยอดหลังหักภาษีแอดมิน',
            'ยอดจัด',
            'ค่าดำเนินการ',
            'ประกันPA',
            'จัดได้รวม',
            'เปอร์เซ็นต์จัด',
            'เป้า',
        ];
        return $data;

    }

    public function collection()
    {

        $data = tbl_traceEmployee::whereNotNull('IdUserCk')->get();
        return $data;

    }
    private $row = 1;

    public function map($invoice): array
    {

        if($invoice->IdCK == 29) {  // นาทวี
            $data = tbl_contract::
                where('UserZone',20)
                ->where('UserSent_Con',$invoice->IdUserCk)
                ->WhereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"),[ $this->SDueDate,$this->LDueDate])
                ->orderBy('UserSent_Con','ASC')
                ->get();
            $emps = tbl_traceEmployee::where('IdUserCk',$invoice->IdUserCk)->first();
        } else {
            $data = tbl_contract::
                where('UserZone',20)
                ->where('BranchSent_Con',$invoice->IdCK)
                ->WhereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"),[ $this->SDueDate,$this->LDueDate])
                ->orderBy('UserSent_Con','ASC')
                ->get();
            $emps = tbl_traceEmployee::where('IdCK',$invoice->IdCK)->first();
        }

        $sum = 0;
        $Cash_Car = 0;
        $Insurance_PA = 0;
        $Process_Car = 0;
        $checkArea = 0 ;
        $totalCase = @$data->count();
        foreach($data as $con){
            if($con->ContractToDataCusTags->Type_Customer != 'CUS-0009'){
                $Cash_Car += $con->ConToCal->Cash_Car ;
                $Process_Car += $con->ConToCal->Process_Car;
                @$con->Date_Checkers != NULL ? $checkArea += 1 : $checkArea += 0 ;
                if($con->ConToCal->Buy_PA == 'Yes' && $con->ConToCal->Include_PA == 'Yes'){
                    $Insurance_PA += $con->ConToCal->Insurance_PA;
                }
            }
        }
        $sum = ( @$Cash_Car + @$Insurance_PA + @$Process_Car );

        if(@$emps->EmptoTarget->Target > 0){
            $percent = floor((( $sum / @$emps->EmptoTarget->Target )) * 100);
        }else {
            $percent = 0;
        }
        $SumdataCom = 0;
        $GasCash = 0;
        foreach($data as $con){

            if($con->CodeLoan_Con == 04 || $con->CodeLoan_Con == 03){
                $totalInt = 0;
            }else{

                $totalInt = @$con->ConToCal->Profit_Rate - @$con->ConToCal->Tax2_Rate;
            }

            if(@$con->ConToCal->Buy_PA =='Yes'){
                $pa = 'YPA';
            }else{
                $pa = 'NPA';
            }
            $dataCom =  tbl_staticcommission::where('TypeLoans', @$con->CodeLoan_Con)
            ->whereRaw('? between StotalInterest and TtotalInterest', $totalInt)
            ->selectRaw('case when '.$percent.' < 80 then '.$pa.'70
            when '.$percent.' < 100 then '.$pa.'80
            when '.$percent.' < 120 then '.$pa.'100
            else  '.$pa.'120 end as Commission, TypeLoans,Gas')
            ->first();
            $SumdataCom += @$dataCom->Commission;
            @$con->Date_Checkers != NULL ? $GasCash += $dataCom->Gas : $GasCash += 0;
        }

        $this->row++;
        return[
            @$invoice->employeeName, //สาขา
            @$data[0]->ContractToUserBranch->name, // ชื่อไฟแนนซ์
            @$checkArea, // ลงพื้นที่
            @$totalCase -  @$checkArea, // ไม่ลงพื้นที่
            @$totalCase, //เคสรวม
            @$GasCash, //ค่าน้ำมัน
            0, //การตลาด
            @$SumdataCom - (@$SumdataCom * 40) / 100 , // ผลตอบแทนไฟแนนซ์
            0, // non-starter
            '=(F'.$this->row.'+G'.$this->row.'+H'.$this->row.')-I'.$this->row, // รวมค่าคอมไฟแนนซ์
            '=J'.$this->row.'-((J'.$this->row.'*3)/100)', // ค่าคอมหลังหักภาษีไฟแนนซ์
            @$SumdataCom - (@$SumdataCom * 60) / 100 , // ผลตอบแทนแอดมิน
            0, // non-starter แอดมิน
            '=L'.$this->row.'- M'.$this->row, // รวมค่าคอมแอดมิน
            '=N'.$this->row.'-((N'.$this->row.'*3)/100)', // ค่าคอมหลังหักภาษีแอดมิน
            @$Cash_Car,
            @$Process_Car,
            @$Insurance_PA,
            @$sum,
            @$percent ,
            @$emps->EmptoTarget->Target

        ];

    }


}






