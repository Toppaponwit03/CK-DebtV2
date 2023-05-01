<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_privilege;

class tbl_user extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = ['id','name','email','password','password_val','Branch','position'];



}
