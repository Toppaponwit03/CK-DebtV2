<?php

namespace App\Models\CK_Model;
use App\Models\tbl_target;
use App\Models\CK_Model\tbl_contract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_userck extends Model
{
    use HasFactory;
    protected $connection = 'ck';
    protected $table = 'users';



    protected $fillable = [
        'id',
        'name',
        'username',
        'email',
        'password',
        'password_token',
    ];

    public function UsertoCon(){
        return $this->hasMany(tbl_contract::class,'UserSent_Con','id');
    }

}
