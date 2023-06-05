<?php

namespace App\Exports;
use App\Models\tbl_customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Controllers\customercontroller;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class exportDataCustomers implements FromCollection,WithHeadings,WithMapping
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
                 "FollowingDate",
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
             "FollowingDate",
             "note",
             "actionPlan",
             "paymentDateQuantity",
             "teamGroup",
             "typeLoan",
             "Recorder",
             "Schema",
             "ยอดรับชำระ"
         ];
        return $data;

    }
    public function map($data): array
    {
        return[
                @$data->id,
                @$data->Branch,
                @$data->contractNumber,
                @$data->namePrefix,
                @$data->firstname,
                @$data->lastname,
                @$data->phone,
                @$data->productName,
                @$data->sellEmployee,
                @$data->traceEmployee,
                @$data->totalInstallment,
                @$data-> firstInstallment,
                @$data-> dealDay,
                @$data-> installment,
                @$data-> realDebt,
                @$data-> nextDebt,
                @$data-> groupDebt,
                @$data-> fromDebt,
                @$data-> toDebt,
                @$data-> arrears,
                @$data-> lastPaymentdate,
                @$data-> lastPayment,
                @$data-> finePay,
                @$data-> totalPayment,
                @$data-> balanceDebt,
                @$data-> minimumInstallment,
                @$data-> minimumPayout,
                @$data-> contractGrade,
                @$data-> CustoStatus->details,
                @$data-> callDate,
                @$data-> quantitycallDate,
                @$data-> callDateOut,
                @$data-> quantitycallDateOut,
                @$data-> traceTeamOut,
                @$data-> paymentDate,
                @$data-> FollowingDate,
                @$data-> fieldDay,
                @$data-> powerApp,
                @$data-> note,
                @$data-> actionPlan,
                @$data-> paymentDateQuantity,
                @$data-> teamGroup,
                @$data-> typeLoan,
                @$data-> Recorder,
                @$data-> Schema,
                @$data-> TotalPay 
        ];
       
    }
}
