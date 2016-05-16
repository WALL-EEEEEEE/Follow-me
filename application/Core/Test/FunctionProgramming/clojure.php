<?php
   $bind = 3;
   $closure = function($arg) use ($bind) {
   	    return $arg + $bind;
   };
   $bind = 4;

   var_dump($closure(4));