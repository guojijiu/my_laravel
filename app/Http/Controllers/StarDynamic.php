<?php

namespace App\Http\Controllers;


use Illuminate\Database\Eloquent\Model;

class StarDynamic extends Model
{
    protected $fillable = [
        'id', 'star_id', 'resource_id', 'resource_from', 'resource_type', 'img_urls', 'caption', 'created_at', 'updated_at'
    ];
}