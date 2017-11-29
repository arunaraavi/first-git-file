<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
        public $fillable = ['id','name','owner','status','customer_details','customer_name'];
       // public $timestamps = false;
        //protected $table=customer;
}
