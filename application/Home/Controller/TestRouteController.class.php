<?php

    namespace Home\Controller;

use Think\Controller;
use Think\Model;

class TestRouteController extends Controller
{

    public static function test1()
    {
        echo "show";
        $this->show();
        $this-display();

        $this->display();

        echo $_GET();
    }

    public function test2()
    {
        echo "ehllo";
    }
}
