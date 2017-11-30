<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    protected $fillable = [
        'modified_by', 'brand', 'description',
    ];
    protected $table = 'brands';iiioi
}
