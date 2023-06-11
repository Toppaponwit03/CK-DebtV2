<?php

namespace App\Models\CK_Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_branch extends Model
{
    use HasFactory;
    protected $connection = 'ck';
    protected $table = 'TB_Branchs';
    protected $fillable = ['id_Contract','id_Contract_1','Name_Branch','NickName_Branch','Zone_Branch','Branch_Locate','Loan_Active','Traget_Branch','province_Branch'];
}
