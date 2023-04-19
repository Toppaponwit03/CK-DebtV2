<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_traceEmployee extends Model
{
    use HasFactory;
    protected $table = 'tbl_trace_Employees';
    protected $fillable = ['employeeName','nameThai','Details','teamGroup'];

    public static function getBranch(){
        return tbl_traceEmployee::get();
    }
}
