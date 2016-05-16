<?php
namespace Api\baseApi;


/**
 * 定义Api相关接口标准
 */

interface Api
{

     /**
      * 返回请求结果
      * @return string[json] [返回json结果数据]
      */
     public function response();

    /**
     * 接收请求
     * @return void 
     */
     public function request();


    /**
     * 处理请求
     * @return void  ]
     */
     public function process();
     
}
