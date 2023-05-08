<?php

namespace App\Exports;
use App\Models\tbl_customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Controllers\customercontroller;
use Maatwebsite\Excel\Concerns\WithHeadings;

class exportDataCustomers implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    { 
        $data = tbl_customer::select(
            [
                "id",
                "Branch",
                "contractNumber",
                "namePrefix",
                "firstname",
                "lastname",
                "phone",
                "productName",
                "sellEmployee",
                "traceEmployee",
                "totalInstallment",
                 "firstInstallment",
                 "dealDay",
                 "installment",
                 "realDebt",
                 "nextDebt",
                 "groupDebt",
                 "fromDebt",
                 "toDebt",
                 "arrears",
                 "lastPaymentdate",
                 "lastPayment",
                 "finePay",
                 "totalPayment",
                 "balanceDebt",
                 "minimumInstallment",
                 "minimumPayout",
                 "contractGrade",
                 "status",
                 "callDate",
                 "quantitycallDate",
                 "callDateOut",
                 "quantitycallDateOut",
                 "traceTeamOut",
                 "paymentDate",
                 "fieldDay",
                 "powerApp",
                 "note",
                 "actionPlan",
                 "paymentDateQuantity",
                 "teamGroup",
                 "typeLoan",
                 "Recorder",
                 "Schema",
                 "TotalPay"
             ]
        )->get();
        return $data;
 
    }
    public function headings() :array
    {
        $data = [
            "id",
            "Branch",
            "contractNumber",
            "namePrefix",
            "firstname",
            "lastname",
            "phone",
            "productName",
            "sellEmployee",
            "traceEmployee",
            "totalInstallment",
             "firstInstallment",
             "dealDay",
             "installment",
             "realDebt",
             "nextDebt",
             "groupDebt",
             "fromDebt",
             "toDebt",
             "arrears",
             "lastPaymentdate",
             "lastPayment",
             "finePay",
             "totalPayment",
             "balanceDebt",
             "minimumInstallment",
             "minimumPayout",
             "contractGrade",
             "status",
             "callDate",
             "quantitycallDate",
             "callDateOut",
             "quantitycallDateOut",
             "traceTeamOut",
             "paymentDate",
             "fieldDay",
             "powerApp",
             "note",
             "actionPlan",
             "paymentDateQuantity",
             "teamGroup",
             "typeLoan",
             "Recorder",
             "Schema",
             "TotalPay"
         ];
        return $data;

    }
}
