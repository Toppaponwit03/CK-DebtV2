<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_statustype extends Model
{
    use HasFactory;
    
    protected $table = 'tbl_statustypes';
    protected $fillable = ['id','statusName','Status_code','details'];

    public static function getstatus(){
        return tbl_statustype::get();
    }
}
