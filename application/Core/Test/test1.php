<?php 

    namespace Test;

class test1
{

    public function add($data)
    {

       var_dump($data);
        echo "test1"."</br>";

    }

}

class test2 extends test1
{

    public function add($data)
    {
    	var_dump($data);
        echo "test2"."</br>";
        parent::add($data);

    }

}


$data = array("hello1","hello2","hello3");
$test2 = new test2();
$test2->add($data);
