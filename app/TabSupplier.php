<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TabSupplier extends Model
{
    //
    protected $fillable = [
        'name', 'creation', 'modified','modified_by','owner','docstatus','parent','parentfield','parenttype','website','idx','credit_days_based_on','_comments','_assign','_liked_by','supplier_type','credit_days','_user_tags','naming_series','image','disabled','default_currency','status','supplier_name','language','country','default_price_list','is_frozen','supplier_details',
    ];
    protected $table = 'tab_suppliers';
    
}
