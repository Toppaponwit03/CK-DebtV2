<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_appointment extends Model
{
    use HasFactory;

    protected $table = 'tbl_appointment';
    protected $fillable = ['id','ContractNumber','DateApp','date'];
}
