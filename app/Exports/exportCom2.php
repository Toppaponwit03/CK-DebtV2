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

class exportCom2 implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct() // วันดีล
    {
        $this->SDueDate = '2023-10-01';
        $this->LDueDate = '2023-10-31';
        $this->TypeLoan = 1 ;
    }
    public function collection()
    {
        // $data = tbl_contract::
        // where('UserZone',20)
        // ->with(['ConToCal' => function($query) {
        //     $query->select('Profit_Rate','DataTag_id','Cash_Car','Process_Car','Buy_PA','Include_PA','Insurance_PA','Process_Car','Process_Car','Tax2_Rate');
        // }])
        // ->WhereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"),[ $this->SDueDate,$this->LDueDate ])
        // ->orderBy('UserSent_Con','ASC')
        // ->select('Contract_Con','Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con','UserSent_Con','Date_Checkers')
        // ->get();
        // return $data;
        if($this->TypeLoan == 1){
            $data = tbl_traceEmployee::whereNotNull('IdUserCk')->get();
        }elseif($this->TypeLoan == 2){
            $data = tbl_traceEmployee::whereNotNull('IdUserCk')->get();
        }
        return $data;

    }
    public function headings() :array
    {
        if($this->TypeLoan == 1){
            $data = [
                "สาขา",
                "จำนวนงาน",
                "เข้าเป้า",
                "Size",
                "totalPast",
                "PassPast",
                "total %",
                "คอม",
                "totalBefor",
                "PassBefor",
                "%",
                "totalNomal",
                "PassNomal",
                "%",
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
                "รวมค่าคอม",
                "ไฟแนนซ์",
                "จำนวน",
                "ยอดหลังหักภาษี",
                "แอดมิน",
                "จำนวน",
                "ยอดหลังหักภาษี",
                "ยอดจัดได้",
                "Pa",
                "ค่าดำเนินการ",
                "ยอดจัดรวม",


            ];
        }elseif($this->TypeLoan == 2){
            $data = [
                "สาขา",
                "จำนวนงาน",
                "เป้าเก็บ",
                "Size",
                "totalPast1",
                "PassPast1",
                "%",
                "คอม",
                "totalPast2",
                "PassPast2",
                "%",
                "คอม",
                "totalPast",
                "PassPast",
                "%",
                "คอม",
                "แอดมิน",
                "รวมค่าคอม",
                "ยอดหลังหักภาษี"

            ];
        }
        return $data;

    }

    public function map($invoice): array
    {
        if($this->TypeLoan == 1){

            if($invoice->IdCK == 29) {  // นาทวี
                $data = tbl_contract::
                  where('UserZone',20)
                ->where('UserSent_Con',$invoice->IdUserCk)
                ->with(['ConToCal' => function($query) {
                    $query->select('Profit_Rate','DataTag_id','Cash_Car','Process_Car','Buy_PA','Include_PA','Insurance_PA','Process_Car','Process_Car','Tax2_Rate');
                }])
                ->WhereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"),[ $this->SDueDate,$this->LDueDate])
                ->orderBy('UserSent_Con','ASC') 
                ->select('Contract_Con','Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con','UserSent_Con','Date_Checkers')
                ->get();
                $emps = tbl_traceEmployee::where('IdUserCk',$invoice->IdUserCk)->first();
            } else {
                $data = tbl_contract::
                 where('UserZone',20)
                ->where('BranchSent_Con',$invoice->IdCK)
                ->with(['ConToCal' => function($query) {
                    $query->select('Profit_Rate','DataTag_id','Cash_Car','Process_Car','Buy_PA','Include_PA','Insurance_PA','Process_Car','Process_Car','Tax2_Rate');
                }])
                ->WhereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"),[ $this->SDueDate,$this->LDueDate])
                ->orderBy('UserSent_Con','ASC') 
                ->select('Contract_Con','Date_monetary','BranchSent_Con','DataTag_id','CodeLoan_Con','UserSent_Con','Date_Checkers')
              ->get();
              $emps = tbl_traceEmployee::where('IdCK',$invoice->IdCK)->first();
            }

                $sum = 0;
                $Cash_Car = 0;
                $Insurance_PA = 0;
                $Process_Car = 0;
                foreach($data as $con){
                    if($con->ContractToDataCusTags->Type_Customer != 'CUS-0009'){
                        
                        $Cash_Car += $con->ConToCal->Cash_Car ;
                        $Process_Car += $con->ConToCal->Process_Car;
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

                  FROM tbl_customers WHERE typeLoan = '".$this->TypeLoan."' and  traceEmployee = '".@$emps->employeeName."' group by traceEmployee ;
              ");

                 if($dataPass != NULL){

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

                    //   $totalPass = number_format(($dataPass[0]->PassPast  / ($dataPass[0]->totalPast  + 0.001)) * 100,2);

                    $total = $dataPass[0]->totalBefor  +$dataPass[0]->totalNomal +$dataPass[0]->totalPast1 +$dataPass[0]->totalPast2 +$dataPass[0]->totalPast3+$dataPass[0]->totalPast4;
                    $totalPass = $dataPass[0]->PassBefor  +$dataPass[0]->PassNomal +$dataPass[0]->PassPast1 +$dataPass[0]->PassPast2 +$dataPass[0]->PassPast3+$dataPass[0]->PassPast4 ;
                    $perTotal = number_format(( ($totalPass + 0.00001) / ($total + 0.00001) ) * 100 ,2 );



                    $dataDebt = tbl_customer::where('traceEmployee',@$emps->employeeName)->get();
                    $countEmp = $dataDebt->count();
                    $checkSize = staticSize::
                    where('SCount','<',$countEmp)
                    ->where('LCount','>',$countEmp)
                    ->first();
                    if(@$checkSize->Size == 'S'){
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

                    } else {
                        if(@$dataPass[0]->totalPast1 > 0){
                            $dataComDebtPast1 = staticComDebt::where('Size', @$checkSize->Size)
                            ->where('typeLoan',$this->TypeLoan)
                            ->whereRaw('? between SPERTarget and LPERTarget', $percent)
                            ->selectRaw('
                                    case
                                    when '.$Past1.' >= 0 and '.$Past1.' < 85 then 0
                                    when '.$Past1.' >= 85 and '.$Past1.' < 90 then Past1_85
                                    when '.$Past1.' >= 90 and '.$Past1.' < 95 then Past1_90
                                    else  Past1_95 end as Commission'
                                )
                            ->first();


                        }
                        if(@$dataPass[0]->totalPast2 > 0){
                            $dataComDebtPast2 = staticComDebt::where('Size', @$checkSize->Size)
                            ->where('typeLoan',$this->TypeLoan)
                            ->whereRaw('? between SPERTarget and LPERTarget', $percent)
                            ->selectRaw('
                                    case
                                    when '.$Past2.' >= 0 and '.$Past2.' < 85 then 0
                                    when '.$Past2.' >= 85 and '.$Past2.' < 90 then Past2_85
                                    when '.$Past2.' >= 90 and '.$Past2.' < 95 then Past2_90
                                    else  Past2_95 end as Commission'
                                )
                            ->first();


                        }
                        if(@$dataPass[0]->totalPast3 > 0){
                            $dataComDebtPast3 = staticComDebt::where('Size', @$checkSize->Size)
                            ->where('typeLoan',$this->TypeLoan)
                            ->whereRaw('? between SPERTarget and LPERTarget', $percent)
                            ->selectRaw('
                            case
                            when '.$Past3.' >= 0 and '.$Past3.' < 85 then 0
                            when '.$Past3.' >= 85 and '.$Past3.' < 90 then Past3_85
                            when '.$Past3.' >= 90 and '.$Past3.' < 95 then Past3_90
                            else  Past3_95 end as Commission'
                                )
                            ->first();

                        }
                    }
                }
            }
           @$totalCom = (@$dataComDebtPast1->Commission + @$dataComDebtPast2->Commission + @$dataComDebtPast3->Commission + @$dataComDebtSTotal->Commission); //รวมค่าคอม
           if(@$totalCom >= 1000){
                @$totalComFN = (@$totalCom * 60) / 100; // จำนวนไฟแนนซ์รับ
                @$totalComFNVat = ((@$totalCom * 60) / 100) - ((((@$totalCom * 60) / 100)) * 3) /100;   //ไฟแนนซ์หลังหัก 3 %
                @$totalComAD = (@$totalCom * 40) / 100; // จำนวนแอดมินรับ
                @$totalComADVat = ((@$totalCom * 40) / 100) - ((((@$totalCom * 40) / 100)) * 3) /100; // แอดมินหลังหัก 3 %
           } else {
                @$totalComFN = (@$totalCom * 60) / 100; // จำนวนไฟแนนซ์รับ
                @$totalComFNVat = @$totalComFN ;   //ไฟแนนซ์หลังหัก 3 %
                @$totalComAD = (@$totalCom * 40) / 100; // จำนวนแอดมินรับ
                @$totalComADVat = @$totalComAD ; // แอดมินหลังหัก 3 %
           }
        }
        elseif($this->TypeLoan == 2){
            $emps = tbl_traceEmployee::where('IdUserCk',$invoice->IdUserCk)->first();
            $percent =  @$emps->EmptoTarget->TargetKebt;
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

                  FROM tbl_customers WHERE typeLoan = '".$this->TypeLoan."' and  traceEmployee = '".@$emps->employeeName."' group by traceEmployee ;
              ");

               if($dataPass != NULL){

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
        }

        if($this->TypeLoan == 1){
            return[
                @$emps->employeeName,
                @$countEmp,
                @$percent ,
                @$checkSize->Size,
                @$total,
                @$totalPass,
                @$perTotal,
                @$dataComDebtSTotal->Commission,
                @$dataPass[0]->totalBefor,
                @$dataPass[0]->PassBefor,
                @$Befor,
                @$dataPass[0]->totalNomal,
                @$dataPass[0]->PassNomal,
                @$Nomal,
                @$dataPass[0]->totalPast1,
                @$dataPass[0]->PassPast1,
                @$Past1,
                @$dataComDebtPast1->Commission,
                @$dataPass[0]->totalPast2,
                @$dataPass[0]->PassPast2,
                @$Past2,
                @$dataComDebtPast2->Commission,
                @$dataPass[0]->totalPast3 + @$dataPass[0]->totalPast4 + 0, // Parse 3 + 4
                @$dataPass[0]->PassPast3 + @$dataPass[0]->PassPast4, // Parse 3 + 4
                @$Past3, // Parse 3 + 4
                @$dataComDebtPast3->Commission,
                @$totalCom, //รวมค่าคอม
                @$emps->employeeName, // ไฟแนยซ์
                @$totalComFN, // จำนวนไฟแนนซ์รับ
                @$totalComFNVat,   //หลังหัก 3 %
                @$emps->employeeName, // แอดมิน
                @$totalComAD, // จำนวนแอดมินรับ
                @$totalComADVat, // แอดมินหลังหัก 3 %
                @$Cash_Car,
                @$Insurance_PA,
                @$Process_Car,
                @$sum,

            ];
        } elseif($this->TypeLoan == 2){

            return[
                @$emps->employeeName,
                @$countEmp,
                @$percent ,
                @$checkSize->Size,
                @$dataPass[0]->totalPast1,
                @$dataPass[0]->PassPast1,
                @$Past1,
                @$dataComDebtSTotal->Commission,
                @$dataPass[0]->totalPast2,
                @$dataPass[0]->PassPast2,
                @$Past2,
                @$dataComDebtSTotal->Commission,
                @$total,
                @$totalPass,
                @$perTotal,
                @$dataComDebtSTotal->Commission,
                @$emps->employeeName,
            ];
        }

    }
}
