<?php 
function factorial($n, $acc)
{
    if ($n == 0) {
        return $acc;
    }
    return factorial($n-1, $acc * $n);

}
    var_dump(factorial(100, 1));