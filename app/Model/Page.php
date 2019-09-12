<?php
/**
 * Created by PhpStorm.
 * User: liuwei
 * Date: 2019/8/9
 * Time: 11:01
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Page extends Model
{
    use HasRoles;
}