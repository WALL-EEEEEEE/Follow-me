<?php
    namespace Home\Controller;

    use Think\Controller;

    use Think\Model;

class TestRoute1Controller extends Controller
{

    public function test()
    {


           
            
            echo "what the fuck you are \n";
            echo "hello";
            
            


        



    }


    public function test2()
    {

            echo "blog/read";
            echo "\n";
            echo $_GET["id"];


    }


    public function test3()
    {

            echo "test regex router";
    }

    public function test4()
    {

            echo "test static router urls";
    }


    public function test5($name)
    {

            echo  "testing for ".$name;


    }
}
