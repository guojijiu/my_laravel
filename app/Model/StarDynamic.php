<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StarDynamic extends Model
{
    protected $fillable = [
        'id', 'star_id', 'resource_id', 'resource_user_id', 'resource_from', 'resource_type',
        'img_urls', 'caption', 'arguments', 'created_at', 'updated_at'
    ];
}