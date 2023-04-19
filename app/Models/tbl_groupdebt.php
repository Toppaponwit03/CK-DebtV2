<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_groupdebt extends Model
{
    use HasFactory;
    protected $table = 'tbl_groupdebts';
    protected $fillable = ['nameGroup','Groupdebt_Code','detail'];

    public static function getGroupdebt(){
        return tbl_groupdebt::orderby('id', 'ASC')->get();
    }
}
