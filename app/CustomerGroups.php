<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerGroups extends Model
{
    //
    protected $fillable = [
        'name', 'creation', 'modified','modified_by','owner','docstatus','parent','parentfield','parenttype','idx','credit_limit','rgt','default_price_list','credit_days_based_on','_comments','parent_customer_group','_assign','is_group','old_parent','lft','_liked_by','customer_group_name','credit_days','_user_tags',
    ];
    protected $table = 'customer_groups';
}
