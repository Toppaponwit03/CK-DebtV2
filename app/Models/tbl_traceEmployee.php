<?php

namespace App\Models;

use App\Models\tbl_target;
use App\Models\CK_Model\tbl_contract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_traceEmployee extends Model
{
    use HasFactory;
    protected $table = 'tbl_trace_Employees';
    protected $fillable = ['id','employeeName','nameThai','Details','teamGroup','IdCK'];

    public static function getBranch(){
        return tbl_traceEmployee::get();
    }

    public function EmptoTarget(){
        return $this->hasOne(tbl_target::class,'EmpId','id');
    }
    public function EmptoCon(){
        return $this->hasMany(tbl_contract::class,'BranchSent_Con','IdCK');
    }

}
