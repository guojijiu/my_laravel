<?php

namespace App\Pattern\Bridge;


class Windows extends PlatformAbstract
{


    public function show()
    {
        echo '在Windows平台使用';

        return $this->format->format();
    }
}