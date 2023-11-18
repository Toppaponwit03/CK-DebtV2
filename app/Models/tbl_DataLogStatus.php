<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_DataLogStatus extends Model
{
    use HasFactory;

   protected $table = 'tbl_DataLogStatus';
   protected $fillable = [
        'TagID'
        ,'UserInsert'
        ,'UserInsertTxt'
        ,'Details'
        ,'StatusDate'
        ,'StatusCode'
    ];
}
