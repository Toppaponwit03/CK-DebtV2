<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_target extends Model
{
    use HasFactory;
    protected $table = 'tbl_target';
    protected $fillable = ['id','EmpName','Target','EmpId','created_at','updated_at'];
}
