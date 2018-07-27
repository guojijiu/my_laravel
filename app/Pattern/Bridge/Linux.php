<?php
/**
 * Created by PhpStorm.
 * User: user009
 * Date: 2018/6/29
 * Time: 15:27
 */

namespace App\Pattern\Bridge;


class Linux extends PlatformAbstract
{
    public function show()
    {
        echo '在Linux平台使用';
    }
}