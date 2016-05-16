<?php

    namespace Api\androidApi;

    use Think\Controller\RestController;
    use Core\Controller\UserController;
    use Api\baseApi;
    
/**
 *  Android客户端请求类: 处理来自于Android的客户端的请求
 */


class AndroidApi extends RestController implements baseApi
{

    //规定Android客户端的请求只能以json的格式传送数据
    protected $allowType = array("json");


   
    public function register_by_mail()
    {

        $handler = new UserController;

        /**
         * 检查请求参数
         */
   
    }

    /**
     * 处理请求
     * @return void
     */
    public function process()
    {
    }

    /**
    * 返回结果请求
    * @return string[json] [返回相应的json结果]
    */
    public function response()
    {

    }


}










