<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_staticCom extends Model
{
    use HasFactory;
    protected $table = 'tbl_staticcom';
    protected $fillable = ['id','StotalInterest','TtotalInterest','TypeLoans','SPercents','TPercents','Pa','Commission','Group'];
}
