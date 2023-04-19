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
        return new tbl_customer([
            'Branch' => $row[1] ,
            'NON'    => $row[2],
            'contractNumber' => $row[3],
            'namePrefix' => $row[4],
            'firstname' => $row[5],
            'lastname' => $row[6],
            'phone' => $row[7],
            'productName' => $row[8],
            'sellEmployee' => $row[9],
            'traceEmployee' => $row[10],
            'totalInstallment' => $row[11],
            'firstInstallment' => $row[12],
            'dealDay' => $row[13],
            'installment' => $row[14],
            'realDebt' => $row[15],
            'nextDebt' => $row[16],
            'groupDebt' => $row[17],
            'fromDebt' => $row[18],
            'toDebt' => $row[19],
            'arrears' => $row[20],
            'lastPaymentdate' => $row[21],
            'lastPayment' => $row[22],
            'finePay' => $row[23],
            'totalPayment' => $row[24],
            'balanceDebt' => $row[25],
            'minimumInstallment' => $row[26],
            'minimumPayout' => $row[27],
            'contractGrade' => $row[28],
            'status' => $row[29],
            'callDate' => $row[30],
            'quantitycallDate' => $row[31],
            'callDateOut' => $row[32],
            'quantitycallDateOut' => $row[33],
            'traceTeamOut' => $row[34],
            'paymentDate' => $row[35],
            'fieldDay' => $row[36],
            'powerApp' => $row[37],
            'note' => $row[38],
            'actionPlan' => $row[39],
            'paymentDateQuantity' => $row[40],
            'teamGroup' => $row[41],
            'typeLoan' => $row[42],
            'Recorder' => $row[43],
            'Schema' => $row[44],

           
           
        ]);
    }
}
