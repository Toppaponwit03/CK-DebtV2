<?php

namespace App\Imports;

use App\Models\tbl_customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;

class UsersImport implements ToModel,WithHeadingRow
{

    public function model(array $row)
    {
        // dd( tbl_customer::where('id',1)->get() );
        //  $data = new tbl_customer([
        //      "id" => $row[0],
        //      "Branch" => $row[1],
        //      "contractNumber" => $row[2],
        //      "namePrefix" => $row[3],
        //      "firstname" => $row[4],
        //      "lastname" => $row[5],
        //      "phone" => $row[6],
        //      "productName" => $row[7],
        //      "sellEmployee" => $row[8],
        //      "traceEmployee" => $row[9],
        //      "totalInstallment" => $row[10],
        //      "firstInstallment" => $row[11],
        //      "dealDay" => $row[12],
        //      "installment" => $row[13],
        //      "realDebt" => $row[14],
        //      "nextDebt" => $row[15],
        //      "groupDebt" => $row[16],
        //      "fromDebt" => $row[17],
        //      "toDebt" => $row[18],
        //      "arrears" => $row[19],
        //      "lastPaymentdate" => $row[20],
        //      "lastPayment" => $row[21],
        //      "finePay" => $row[22],
        //      "totalPayment" => $row[23],
        //      "balanceDebt" => $row[24],
        //      "minimumInstallment" => $row[25],
        //      "minimumPayout" => $row[26],
        //      "contractGrade" => $row[27],
        //      "status" => $row[28],
        //      "callDate" => $row[29],
        //      "quantitycallDate" => $row[30],
        //      "callDateOut" => $row[31],
        //      "quantitycallDateOut" => $row[32],
        //      "traceTeamOut" => $row[33],
        //      "paymentDate" => $row[34],
        //      "fieldDay" => $row[35],
        //      "powerApp" => $row[36],
        //      "FollowingDate" => $row[37],
        //      "note" => $row[38],
        //      "actionPlan" => $row[39],
        //      "paymentDateQuantity" => $row[40],
        //      "teamGroup" => $row[41],
        //      "typeLoan" => $row[42],
        //      "Recorder" => $row[43],
        //      "Schema" => $row[44],
        //      "TotalPay" => $row[45]
        //  ]);

        $data = new tbl_customer([
            "id" => $row['id'],
            "Branch" => $row['branch'],
            "contractNumber" => $row['contractnumber'],
            "namePrefix" => $row['nameprefix'],
            "firstname" => $row['firstname'],
            "lastname" => $row['lastname'],
            "phone" => $row['phone'],
            "productName" => $row['productname'],
            "sellEmployee" => $row['sellemployee'],
            "traceEmployee" => $row['traceemployee'],
            "totalInstallment" => $row['totalinstallment'],
            "firstInstallment" => $row['firstinstallment'],
            "dealDay" => $row['dealday'],
            "installment" => $row['installment'],
            "realDebt" => $row['realdebt'],
            "nextDebt" => $row['nextdebt'],
            "groupDebt" => $row['groupdebt'],
            "fromDebt" => $row['fromdebt'],
            "toDebt" => $row['todebt'],
            "arrears" => $row['arrears'],
            "lastPaymentdate" => $row['lastpaymentdate'],
            "lastPayment" => $row['lastpayment'],
            "finePay" => $row['finepay'],
            "totalPayment" => $row['totalpayment'],
            "balanceDebt" => $row['balancedebt'],
            "minimumInstallment" => $row['minimuminstallment'],
            "minimumPayout" => $row['minimumpayout'],
            "contractGrade" => $row['contractgrade'],
            "status" => $row['status'],
            "callDate" => $row['calldate'],
            "quantitycallDate" => $row['quantitycalldate'],
            "callDateOut" => $row['calldateout'],
            "quantitycallDateOut" => $row['quantitycalldateout'],
            "traceTeamOut" => $row['traceteamout'],
            "paymentDate" => $row['paymentdate'],
            "fieldDay" => $row['fieldday'],
            "powerApp" => $row['powerapp'],
            "FollowingDate" => $row['followingdate'],
            "note" => $row['note'],
            "actionPlan" => $row['actionplan'],
            "paymentDateQuantity" => $row['paymentdatequantity'],
            "teamGroup" => $row['teamgroup'],
            "typeLoan" => $row['typeloan'],
            "Recorder" => $row['recorder'],
            "Schema" => $row['schema'],
            "TotalPay" => $row['totalpay']
        ]);
         return $data;
    }

}
