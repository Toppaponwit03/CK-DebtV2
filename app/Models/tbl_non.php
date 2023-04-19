<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_non extends Model
{
    use HasFactory;
    protected $table = 'tbl_nons';
    protected $fillable = ['nameNon','Details','status'];

    public static function getNon(){
        return tbl_non::orderBy('id', 'ASC')->get();
    }
}
