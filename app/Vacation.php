<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    protected $fillable = ['name','email','user_id','description','subject','startDate','endDate'];
}