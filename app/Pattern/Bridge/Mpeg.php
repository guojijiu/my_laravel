<?php
/**
 * Created by PhpStorm.
 * User: user009
 * Date: 2018/6/29
 * Time: 15:35
 */

namespace App\Pattern\Bridge;


class Mpeg implements FormatInterface
{
    public function format()
    {
        return 'Mpeg格式解析电影';
    }
}