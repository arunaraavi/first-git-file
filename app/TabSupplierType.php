<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TabSupplierType extends Model
{
    //
    protected $fillable = [
        'name', 'creation', 'modified','modified_by','owner','docstatus','parent','parentfield','parenttype','idx','credit_days_based_on','_comments','_assign','_liked_by','supplier_type','credit_days','_user_tags',
    ];
    protected $table = 'tab_supplier_types';

}
