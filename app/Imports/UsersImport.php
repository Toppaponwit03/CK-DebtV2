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
            "firstInstallment" => date("Y-m-d",strtotime($row['firstinstallment'])),
            "dealDay" => date("Y-m-d",strtotime($row['dealday'])),
            "installment" => $row['installment'],
            "realDebt" => floatval($row['realdebt']),
            "nextDebt" => floatval($row['nextdebt']),
            "groupDebt" => $row['groupdebt'],
            "fromDebt" => $row['fromdebt'],
            "toDebt" => $row['todebt'],
            "arrears" => floatval($row['arrears']),
            "lastPaymentdate" => date("Y-m-d",strtotime($row['lastpaymentdate'])),
            "lastPayment" => floatval($row['lastpayment']),
            "finePay" => floatval($row['finepay']),
            "totalPayment" => floatval($row['totalpayment']),
            "balanceDebt" => floatval($row['balancedebt']),
            "minimumInstallment" => floatval($row['minimuminstallment']),
            "minimumPayout" => floatval($row['minimumpayout']),
            "contractGrade" => $row['contractgrade'],
            "status" => $row['status'],
            "callDate" => date("Y-m-d",strtotime($row['calldate'])),
            "quantitycallDate" => $row['quantitycalldate'],
            "callDateOut" => date("Y-m-d",strtotime($row['calldateout'])),
            "quantitycallDateOut" => $row['quantitycalldateout'],
            "traceTeamOut" => $row['traceteamout'],
            "paymentDate" =>  date("Y-m-d",strtotime($row['paymentdate'])) ,
            "fieldDay" => date("Y-m-d",strtotime($row['fieldday'])),
            "powerApp" => date("Y-m-d",strtotime($row['powerapp'])),
            "FollowingDate" => date("Y-m-d",strtotime($row['followingdate'])),
            "note" => $row['note'],
            "actionPlan" => $row['actionplan'],
            "paymentDateQuantity" => $row['paymentdatequantity'],
            "teamGroup" => intval($row['teamgroup']),
            "typeLoan" => intval($row['typeloan']),
            "Recorder" => $row['recorder'],
            "Schem" => $row['schema'],
            "TotalPay" => floatval($row['totalpay'])
        ]);
        // dd(gettype(date(date_create($row['calldate']),"Y-m-d")));
        // dd(date("Y-m-d",$row['paymentdate']));
         return $data;
    }

}
