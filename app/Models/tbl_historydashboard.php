<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_historydashboard extends Model
{
    use HasFactory;
    protected $table = 'tbl_historydashboard';
    protected $fillable = ['contractNumber','traceEmployee','groupDebt','status','teamGroup','typeLoan','duedateStart','duedateEnd','TotalPay'];
}
