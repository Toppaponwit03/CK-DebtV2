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
        return tbl_customer::all();
 
    }
    public function headings() :array
    {
        return [
        'id',
        'Branch',
        'NON',
        'contractNumber',
        'namePrefix',
        'firstname',
        'lastname',
        'phone',
        'productName',
        'sellEmployee',
        'traceEmployee',
        'totalInstallment',
        'firstInstallment',
        'dealDay',
        'installment',
        'realDebt',
        'nextDebt',
        'groupDebt',
        'fromDebt',
        'toDebt',
        'arrears',
        'lastPaymentdate',
        'lastPayment',
        'finePay',
        'totalPayment',
        'balanceDebt',
        'minimumInstallment',
        'minimumPayout',
        'contractGrade',
        'status',
        'callDate',
        'quantitycallDate',
        'callDateOut',
        'quantitycallDateOut',
        'traceTeamOut',
        'paymentDate',
        'fieldDay',
        'powerApp',
        'note',
        'actionPlan',
        'paymentDateQuantity',
        'teamGroup',
        'typeLoan',
        'Recorder',
        'Schema',
        'TotalPay',
        'create_at',
        'update_at',
    ];
    }
}
