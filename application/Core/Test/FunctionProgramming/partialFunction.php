<?php
namespace Test;

function log($level, $message)
{
     echo "$level:$message";
}
     
$logWarning = function ($message) {

    return log("Warning", $message);
    
};

$logError   = function ($message) {
    return log("Error", $message);
};

$logWarning("this is one waring message");
$logError("this is one error message");



     
     
     
     

