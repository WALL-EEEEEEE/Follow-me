<?php
   
    $languages = array('php', 'python', 'scala');

    array_map(function (&$lang) {
        $lang = strtoupper($lang);
    }, $languages);


    foreach ($languages as $lang) {
        echo $lang."n";
    }



