<?php

namespace App\Models;

use App\Models\tbl_custag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class tbl_actionplan extends Model
{
    use HasFactory;
    protected $table = 'tbl_actionplan';
    protected $fillable = ['tag_id','date_plan','ContractID','detail','userInsert','userInsertname'];

    public function plantoUser(){
        return $this->hasOne(User::class,'id','userInsert');
    }
    public function plantoCusTag(){
        return $this->hasOne(tbl_custag::class,'id','tag_id');
    }
}
