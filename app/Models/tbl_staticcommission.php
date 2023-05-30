<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_staticcommission extends Model
{
    use HasFactory;
    protected $table = 'tbl_staticcommission';
    protected $fillable = ['id','YPA70','YPA80','YPA100','YPA120','NPA70','NPA80','NPA100','NPA120','TypeLoans','StotalInterest','TtotalInterest','Group'];
    
}
