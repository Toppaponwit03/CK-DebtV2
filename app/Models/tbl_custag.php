<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_custag extends Model
{
    use HasFactory;
    protected $table = 'tbl_custag';
    protected $fillable = ['ContractID','detail','UserInsert'];
}
