<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_actionplan;

class tbl_custag extends Model
{
    use HasFactory;
    protected $table = 'tbl_custag';
    protected $fillable = ['id','ContractID','detail','UserInsert'];

    public function CustagPlan(){
        return $this->hasmany(tbl_actionplan::class,'tag_id','id')->orderBy('created_At', 'ASC');
    }
}
