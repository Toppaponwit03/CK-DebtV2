<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staticSize extends Model
{
    use HasFactory;
    protected $table = 'tbl_staticsize';
    protected $fillable = ['SCount','LCount','Size'];
}
