<?php

/**
 * 应用函数库
 *
 */

/**
 * 生成更好的随机数
 * @param  integer $length  [随机数的位数]
 * @param  integer $numeric [是否使用字典,1,使用字典,0不使用字典]
 * @return [integer]        返回生成的随机数
 */
function random($length = 6 , $numeric = 0) {
	PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	if($numeric) {
		$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
	} else {
		$hash = '';
		$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
		$max = strlen($chars) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
	}
	return $hash;
}

/**
 * 获取当前时间
 * @return [float] [1927年到现在的秒数]
 */
function microtime_s(){
	
	if (PHP_VERSION < '5.0.0') {
		return microtime_float();
	}	

	return microtime(true);
} 

function microtime_float()
{

    list( $usec ,  $sec ) =  explode ( " " ,  microtime ());
    return ((float) $usec  + (float) $sec );
}