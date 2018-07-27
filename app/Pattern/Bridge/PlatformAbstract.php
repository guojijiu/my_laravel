<?php

namespace App\Pattern\Bridge;

/**
 * 平台抽象类
 *
 * Class PlatformAbstract
 * @package App\Pattern\Bridge
 */
abstract class PlatformAbstract
{

    //视频对象
    public $format;

    public function __construct($format)
    {
        $this->format = $format;
    }

    public abstract function show();
}
