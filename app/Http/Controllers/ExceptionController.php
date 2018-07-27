<?php

namespace App\Http\Controllers;


class ExceptionController
{
    public function test()
    {
        $a = 'a';
        try {
            $a = 'aa';
            $new = new LogController();

            $new->test();

            $this->testTwo();
        } catch (\Exception $e) {
//            throw new \InvalidArgumentException('aa', '22');
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function testTwo()
    {
        $c = 'dd';

        throw new \Exception('aass', '123');
    }
}