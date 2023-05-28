<?php

namespace App\Models\CK_Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_typeLoan extends Model
{
    use HasFactory;
    protected $connection = 'ck';
    protected $table = 'TB_TypeLoans';
    protected $fillable = ['Code_PLT','id_rateType','Loan_Code','Loan_Name','Loan_Group','Loan_Com','Loantype_Con','Description',
                            'Flagzone_PTN','Flagzone_HY','Flagzone_NK','Flagzone_KB','Flagzone_SR'];
}
