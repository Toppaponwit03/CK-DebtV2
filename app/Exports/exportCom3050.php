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

class exportCom3050 implements FromCollection,WithHeadings,WithMapping
{

    public function __construct() // วันดีล
    {
        $this->SDueDate = '2023-09-01';
        $this->LDueDate = '2023-09-30';
        $this->TypeLoan = 2 ;
    }
    public function collection()
    {
        $data = tbl_traceEmployee::whereNotNull('IdCK')->get();
        return $data;
    }
    public function headings() :array
    {
        $data = [
            "สาขา",
            "จำนวนงาน",
            "เป้าเก็บ",
            "Size",
            "totalPast",
            "PassPast",
            "%",
            "คอม",
            "totalPast1",
            "PassPast1",
            "%",
            "คอม",
            "totalPast2",
            "PassPast2",
            "%",
            "คอม",
            "แอดมิน",
            "รวมค่าคอม",
            "ยอดหลังหักภาษี"

        ];
        return $data;

    }

    public function map($invoice): array
    {

            $emps = tbl_traceEmployee::where('id',$invoice->id)->first();

            // $percent =  @$emps->EmptoTarget->TargetKebt;
            if(@$emps->employeeName != NULL){

                if($invoice->IdCK == 36){ //check RPHU1 RPHU2
                    $employeeName = 'RPHU';
                }else {
                    $employeeName = $emps->employeeName;
                }

                $dataPLM = DB::select("
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

               FROM tbl_customers WHERE typeLoan = 1 and  traceEmployee = '".@$employeeName."' group by traceEmployee ;
           ");

           if( $dataPLM != NULL){
               $total = $dataPLM[0]->totalBefor  +$dataPLM[0]->totalNomal +$dataPLM[0]->totalPast1 +$dataPLM[0]->totalPast2 +$dataPLM[0]->totalPast3;
               $totalPass = $dataPLM[0]->PassBefor  +$dataPLM[0]->PassNomal +$dataPLM[0]->PassPast1 +$dataPLM[0]->PassPast2 +$dataPLM[0]->PassPast3 ;
               if($total > 0){
                $percent = number_format(( ($totalPass ) / ($total) ) * 100 ,2 );
               } else {
                $percent = 0;
               }
           } else {
            $percent = 0;
           }




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

                  FROM tbl_customers WHERE typeLoan = '".$this->TypeLoan."' and  traceEmployee = '".@$emps->employeeName."' group by traceEmployee ;
              ");

               if($dataPass != NULL && $dataPLM != NULL){

                  if($dataPass[0]->totalBefor > 0){
                    $Befor = number_format(($dataPass[0]->PassBefor / ($dataPass[0]->totalBefor)) * 100,2);
                } else {
                    $Befor = 0;
                }

                if($dataPass[0]->totalNomal > 0){
                    $Nomal = number_format(($dataPass[0]->PassNomal / ($dataPass[0]->totalNomal )) * 100,2);
                } else {
                    $Nomal = 0;
                }

                if($dataPass[0]->totalPast1 > 0){
                    $Past1 = number_format(($dataPass[0]->PassPast1 / ($dataPass[0]->totalPast1)) * 100,2);
                } else {
                    $Past1 = 0;
                }

                if($dataPass[0]->totalPast2 > 0){
                    $Past2 = number_format(($dataPass[0]->PassPast2 / ($dataPass[0]->totalPast2)) * 100,2);
                } else {
                    $Past2 = 0;
                }

                if($dataPass[0]->totalPast3 + $dataPass[0]->totalPast4 > 0){
                    $Past3 =     number_format(( ($dataPass[0]->PassPast3 + $dataPass[0]->PassPast4) / ( ($dataPass[0]->totalPast3 + $dataPass[0]->totalPast4))) * 100,2);
                } else {
                    $Past3 = 0;
                }

                if($dataPass[0]->totalPast4 > 0){
                    $Past4 = number_format(($dataPass[0]->PassPast4 / ($dataPass[0]->totalPast4)) * 100,2);
                } else {
                    $Past4 = 0;
                }

                  $total = $dataPass[0]->totalBefor  +$dataPass[0]->totalNomal +$dataPass[0]->totalPast1 +$dataPass[0]->totalPast2 +$dataPass[0]->totalPast3;
                  $totalPass = $dataPass[0]->PassBefor  +$dataPass[0]->PassNomal +$dataPass[0]->PassPast1 +$dataPass[0]->PassPast2 +$dataPass[0]->PassPast3 ;
                  $perTotal = number_format(( ($totalPass + 0.00001) / ($total + 0.00001) ) * 100 ,2 );

                    $dataDebt = tbl_customer::where('traceEmployee',@$emps->employeeName)
                    ->where('typeLoan',$this->TypeLoan)
                    ->get();

                    $countEmp = $dataDebt->count();
                    $checkSize = staticSize:: where('SCount','<',$countEmp)
                    ->where('LCount','>',$countEmp)
                    ->first();


                    $dataComDebtSTotal = staticComDebt::where('Size', $checkSize->Size)
                    ->where('typeLoan',$this->TypeLoan)
                    ->whereRaw('? between SPERTarget and LPERTarget', $percent)
                    ->selectRaw('
                        case
                        when '.$perTotal.' >= 0 and '.$perTotal.' < 85 then 0
                        when '.$perTotal.' >= 85 and '.$perTotal.' < 90 then T_85
                        when '.$perTotal.' >= 90 and '.$perTotal.' < 95 then T_90
                        else  T_95 end as Commission'
                    )
                    ->first();


               }
            }
            if(@$dataComDebtSTotal->Commission > 1000){
                @$comAFVat = @$dataComDebtSTotal->Commission - (@$dataComDebtSTotal->Commission * 3)/100;
            }else {
                @$comAFVat = @$dataComDebtSTotal->Commission;
            }
            return[
                @$emps->employeeName,
                @$countEmp,
                @$percent ,
                @$checkSize->Size,
                @$total,
                @$totalPass,
                @$perTotal,
                @$dataComDebtSTotal->Commission,
                @$dataPass[0]->totalPast1,
                @$dataPass[0]->PassPast1,
                @$Past1,
                '0',
                @$dataPass[0]->totalPast2,
                @$dataPass[0]->PassPast2,
                @$Past2,
                '0',
                @$emps->employeeName,
                @$dataComDebtSTotal->Commission,
                @$comAFVat
            ];


    }
}
