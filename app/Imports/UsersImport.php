<?php

namespace App\Imports;

use App\Models\tbl_customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Hash;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd( tbl_customer::where('id',1)->get() );
         $data = new tbl_customer([
             "id" => $row[0],
             "Branch" => $row[1],
             "contractNumber" => $row[2],
             "namePrefix" => $row[3],
             "firstname" => $row[4],
             "lastname" => $row[5],
             "phone" => $row[6],
             "productName" => $row[7],
             "sellEmployee" => $row[8],
             "traceEmployee" => $row[9],
             "totalInstallment" => $row[10],
             "firstInstallment" => $row[11],
             "dealDay" => $row[12],
             "installment" => $row[13],
             "realDebt" => $row[14],
             "nextDebt" => $row[15],
             "groupDebt" => $row[16],
             "fromDebt" => $row[17],
             "toDebt" => $row[18],
             "arrears" => $row[19],
             "lastPaymentdate" => $row[20],
             "lastPayment" => $row[21],
             "finePay" => $row[22],
             "totalPayment" => $row[23],
             "balanceDebt" => $row[24],
             "minimumInstallment" => $row[25],
             "minimumPayout" => $row[26],
             "contractGrade" => $row[27],
             "status" => $row[28],
             "callDate" => $row[29],
             "quantitycallDate" => $row[30],
             "callDateOut" => $row[31],
             "quantitycallDateOut" => $row[32],
             "traceTeamOut" => $row[33],
             "paymentDate" => $row[34],
             "fieldDay" => $row[35],
             "powerApp" => $row[36],
             "note" => $row[37],
             "actionPlan" => $row[38],
             "paymentDateQuantity" => $row[39],
             "teamGroup" => $row[40],
             "typeLoan" => $row[41],
             "Recorder" => $row[42],
             "Schema" => $row[43],
             "TotalPay" => $row[44]
         ]);
         return $data;
    }
}
