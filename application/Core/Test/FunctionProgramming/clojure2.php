<?php
      function return_func() {

      	   return function() {
      	   	   echo "返回一个函数!";
      	   };
      }

      $get_return_func = return_func();
      $get_return_func();