<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_duedate extends Model
{
    use HasFactory;
    protected $table = 'tbl_duedate';
    protected $fillable = ['datedueStart','datedueEnd','details'];


    public static function getDuedate(){
        $data = tbl_duedate::whereRaw("? between DATE_FORMAT(`datedueStart`,'%m-%d') and DATE_FORMAT(`datedueEnd`,'%m-%d') ", date('m-d'))->first();

        return $data;
    }
}
