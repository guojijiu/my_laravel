<?php

namespace App\Model;


use Jenssegers\Mongodb\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mongodb';
}