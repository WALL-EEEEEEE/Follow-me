<?php
namespace Api\Controller;

use Think\Controller\RestController;

/**
 *  Restful API 请求分配器,为不同终端的请求调用不同的api
 */
class RestfulApiDispatherController extends RestController
{

    /**
         * 分配器方法,根据终端类型决定调用的api
         * @param  string $action [请求的操作]
         * @return string[json]   [响应的json字符串]
         */
    public function dispather($action = '')
    {
        //根据不同客户端调用不同的接口实现
        switch ($action) {
            case 'android':
                  echo "welcome the android user";
                break;

            case 'webchat':
                  echo "welcome the wechat user";
                break;

            case 'web':
                  echo "welcome the web user";
                break;
            default:
                  echo "something is not provided!";

                break;
        }
    }
}
