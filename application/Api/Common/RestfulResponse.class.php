<?php
        namespace Api\Common;

/**
 *  Restful API请求应答消息类 
 *
 *  定义了请求状态的消息应答
 */
class RestfulResponse
{

    /*
    * 请求的服务不存在
    */
    public static $REQUEST_NOT_EXIST = "Sorry,the content you request is no exist! Please Check you request format ,and try again";
    /**
     * 请求的服务不清楚
     */

    public static $REQUEST_IMPLICIT = "Sorry,the content you request is implicit! Please check you request , and try again";
}
