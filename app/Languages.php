<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    protected $fillable = [
        'foldername', 'languagename', 'description','flag_image',
    ];
    protected $table = 'languages';
}
