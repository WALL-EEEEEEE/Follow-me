<?php
namespace Api\Controller;

use Think\Controller\RestController;
use Api\androidApi\AndroidApi;
use Api\webApi\webApi;
use Api\wechatApi\wechatApi;
use Api\baseApi\Api;

/**
 *  Restful API 请求分配器,为不同终端的请求调用不同的api
 */
class RestfulApiDispatherController extends RestController
{

    //请求API
    protected $apis = null;

    /**
         * 分配器方法,根据终端类型决定调用的api
         * @param  string $action [请求的操作]
         * @return string[json]   [响应的json字符串]
         */
    public function dispather($action = '')
    {
        var_dump($this->_method);
        echo "</br>";
        var_dump($this->action);
        echo "</br>";
        var_dump($_GET["platform"]);
        switch ($this->action) {
            case 'android':
                 $this->apis = new AndroidApi();
                break;
            case 'web':
                 $this->apis = new webApi();
                break;
            case 'wechatApi':
                 $this->apis = new wechatApi();
                break;
            default:
                break;
        }
        //根据不同客户端调用不同的接口实现
        if ($this->apis != null) {
            $this->apis->response();
        } else {
            echo "error";
        }
    }

    public function android_get_html()
    {

        echo "android";
    }
}
