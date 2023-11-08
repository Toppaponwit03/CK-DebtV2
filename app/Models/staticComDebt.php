<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staticComDebt extends Model
{
    use HasFactory;
    protected $table = 'tbl_statdebt';
    protected $fillable = ['Past1_95','Past1_90','Past1_85','Past2_95','Past2_90','Past2_85','Past3_95','Past3_90','Past3_85','SPERTarget','LPERTarget','Size'];
}
