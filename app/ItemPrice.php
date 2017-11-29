<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPrice extends Model
{
    //
    protected $fillable = [
        'name','modified_by', 'price_list_rate', 'item_description','item_name','price_list','currency',
    ];
    protected $table = 'item_prices';
}
