<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    protected $fillable = [
        'name', 'sex', 'korea_name', 'birthday', 'constellation', 'avater', 'country', 'detail',
        'description', 'social_account', 'fans', 'status', 'created_at'
    ];

}