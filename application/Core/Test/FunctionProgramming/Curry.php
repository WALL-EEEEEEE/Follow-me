<?php   
 
function sum3($x, $y, $z)
{
          return $x + $y + $z;
}

function curried_sum3($x)
{
           return function ($y) use ($x) {
                 return function ($z) use ($x, $y) {
                     return sum3($x, $y, $z);
                 };
           };
}

$f1 = curried_sum3(1);
$f2 = $f1(2);
$result = $f2(3);
echo $result;

