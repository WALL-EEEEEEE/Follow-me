<?php
   
   function callFunc($func){
        
        $func('some string');
   }

   $printStrFunc = function($str) {
   	   echo $str;
   };

   callFunc($printStrFunc);
