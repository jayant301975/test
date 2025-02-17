<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
   use SoftDeletes;
   protected $table="contacts";
   protected $fillable=['name','country_code','mobile'];
   protected $dates = ['deleted_at'];
}
