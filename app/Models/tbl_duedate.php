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
        $data = tbl_duedate::whereRaw("? between FORMAT(datedueStart,'MM-dd') and FORMAT(datedueEnd,'MM-dd') ", date('m-d'))->first();
        return $data;
    }
}
