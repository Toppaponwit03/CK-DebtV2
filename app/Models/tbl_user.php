<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_user extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = ['name','email','password','password_val','Branch','position'];
}
