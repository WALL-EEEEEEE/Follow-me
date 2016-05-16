<?php

      $time = "morning!\n";
      $func = function() use (&$time) {
      	echo "good $time";
      };
      $func();
      $time = "afternoon!\n";
      $func();