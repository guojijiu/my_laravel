<?php

abstract class Computer{
    protected $phone;

    public function __construct($phone)
    {
        $this->phone = $phone;
    }
    public  function &__get($property_name)
    {
        if(isset($this->$property_name))
        {
            return($this->$property_name);
        }
        else
        {
            return(NULL);
        }
    }
    public  function __set($property_name, $value)
    {
        $this->$property_name = $value;
    }
    public abstract function connect();
}


//接口：手机
interface Phone{
    public function connectImpl();
}


//华硕品牌的电脑
class  ASUSComputer extends Computer{
    public function __construct($phone)
    {
        $this->phone=$phone;
    }
    public function connect()
    {
        echo "华硕电脑";
        $this->phone->connectImpl();
    }
}


//戴尔品牌的电脑
class DellComputer extends Computer{
    public function __construct($phone)
    {
        $this->phone=$phone;
    }
    public function connect()
    {
        echo "戴尔电脑";
        $this->phone->connectImpl();
    }

}


//三星手机
class  SamsungPhone implements Phone{
    public function connectImpl()
    {
        echo "连接了三星手机\n";
    }
}
//小米手机
class XiaomiPhone implements Phone{
    public function connectImpl()
    {
        echo "连接了小米手机\n";
    }
}


//抽象类：人
abstract class Person{
    public $computer;
    public function __construct($computer)
    {
        $this->computer = $computer;
    }
    public abstract function useComputer();
}


//学生
class Student extends Person{
    public function useComputer()
    {
        echo "学生使用";
        $this->computer->connect();
    }

}


//老师
class Teacher extends Person{
    public function useComputer()
    {
        echo "教师使用";
        $this->computer->connect();
    }

}

function main(){
    //华硕电脑连接了小米手机
    $asusComputer=new ASUSComputer(new XiaomiPhone());
    $asusComputer->connect();
    //戴尔电脑连接了三星手机
    $dellComputer=new DellComputer(new SamsungPhone());
    $dellComputer->connect();
    //学生使用华硕电脑连接了小米手机
    $student=new Student(new ASUSComputer(new XiaomiPhone()));
    $student->useComputer();
    //教师使用戴尔电脑连接了三星手机
    $teacher=new Teacher(new DellComputer(new SamsungPhone()));
    $teacher->useComputer();
}

main();