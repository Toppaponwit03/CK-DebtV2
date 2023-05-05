<?php

namespace App\Models;
use App\Models\tbl_custag;
use App\Models\tbl_statustype;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_customer extends Model
{
    use HasFactory;
    protected $table = 'tbl_customers';
    protected $fillable = [
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

    public function CustoCustag(){
        return $this->hasmany(tbl_custag::class,'ContractID','contractNumber')->orderby('id','DESC');
    }

    public function CustoCustag2(){
        return $this->hasOne(tbl_custag::class,'ContractID','contractNumber')->orderby('date_Tag','DESC');
    }

    public function CustoStatus(){
        return $this->hasOne(tbl_statustype::class,'Status_code','status');
    }





}
