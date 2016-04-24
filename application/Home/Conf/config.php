<?php

return array(
//'配置项'=>'配置值'
    'URL_ROUTE_RULES' => array(

    'hello/:name' => function ($name) {

                echo 'Hello,'.$name.'<br/>';
                $_SERVER['PATH_INFO'] = 'TestRoute1/test5/name/'.$name;

                return false;

    },

    ),
    'URL_MAP_RULES' => array(
      'news/top' => 'TestRoute1/test4',
      'news/top2.html' => 'TestRoute1/test5', ),

);
