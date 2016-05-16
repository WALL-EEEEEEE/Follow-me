<?php
     namespace Api\Controller;

     use Think\Controller\RestController;
     use Api\baseApi\Api;
     use Core\Controller\UserController;

/**
 *   Android 客户端请求处理器
 */
class AndroidController extends RestController
{
    protected $allowType = array('json');
    const  SERVICES_NO_EXISTES = -1;



    private $response_data  = array(
        "statusCode"=>"",
        "statusInfo"=>"",
        "content"   => array(),
        );

    
    /**
     * 邮件注册
     * @param   post  [user_name,user_pwd,mail]
     * @return  json  {"statusCode": "", "statusInfo": "", "content"   : "" }
     */
    public function register_by_mail_post()
    {
        $user = new UserController;
        
        $user_name = I("post.user_name", null, "strip_tags,htmlspecialchars");
        $user_pwd  = I("post.user_pwd", null, "strip_tags,htmlspecialchars");
        $user_email = I("post.mail", null);


        $statusCode = $user->register($user_name, $user_pwd, 0, 1, $user_email, null, null);


        $this->response_data["statusCode"] = $statusCode;
        return $this->response($this->response_data, "json");
    }


    /**
     * 手机注册
     * @param   post  [user_name,user_pwd,telephone]
     * @return  json  {"statusCode": "", "statusInfo": "", "content"   : "" }
     *
     */
    public function register_by_phone_post()
    {
        $user = new UserController;
        
        $user_name = I("post.user_name", null, "strip_tags,htmlspecialchars");
        $user_pwd  = I("post.user_pwd", null, "strip_tags,htmlspecialchars");
        $user_phone= I("post.telephone", null);


        $statusCode = $user->register($user_name, $user_pwd, 0, 2, null, $user_phone, null);


        $this->response_data["statusCode"] = $statusCode;
        return $this->response($this->response_data, "json");

    }

    /**
     * 判断用户别名是否存在
     * @param  get [u_name]
     * @return json {"statusCode":"","statusInfo":"","content":""}
     * 状态码 0  用户名已经注册
     * 状态码 1  用户名未注册
     * 状态码 2  无效用户名
     */
    public  function userNameExist_get()
    {
        $user = new UserController;
        //用户名不能是纯数字或纯字母
        $user_name = I("get.u_name", null, "/^((\d+[a-zA-Z]+)|([a-zA-Z]+\d+))*$/");


        if (empty($user_name)) {
                $this->response_data["statusCode"] = 2;
                return $this->response($this->response_data, 'json');
        }
        $statusCode = $user->aliasExists($user_name);
        $this->response_data["statusCode"] = $statusCode?1:0;

        return $this->response($this->response_data, 'json');
    }


    /**
     * 判别用户邮箱是否已经注册
     * @param  get [email]
     * @return json {"statusCode":"","statusInfo":"","content":""}
     * 状态码 0  邮箱已经注册
     * 状态码 1  邮箱未注册
     * 状态码 2  无效邮箱
     */
    public function userEmailExist_get()
    {

        $user = new UserController;
        $user_email = I("get.email", null, "validate_email");



        if (empty($user_email)) {
                  $this->response_data["statusCode"] = 2;
                  return $this->response($this->response_data, 'json');
        }

        $statusCode = $user->emailExists($user_email);

        $this->response_data["statusCode"] = $statusCode?1:0;

        return $this->response($this->response_data, 'json');

    }

    /**
     * 判别用户手机是否已经注册_
     * @param  get [phone]
     * @return json {"statusCode":"","statusInfo":"","content":""}
     * 状态码 0  手机号已经注册
     * 状态码 1  手机号未注册
     * 状态码 2  无效手机号
     */
    public function userTelExist_get()
    {
         $user = new UserController;
         //手机号的格式要求
         $user_phone = I("get.phone", null, "/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|70)\\d{8}$/");

         if (empty($user_phone)) {
                  $this->response_data["statusCode"] = 2;
                  return $this->response($this->response_data, 'json');
        }

         $statusCode = $user->teleExists($user_phone);
         $this->response_data["statusCode"] = $statusCode?1:0;

         return $this->response($this->response_data, 'json');

    }

    public function services_no_existes() {

        $this->response_data["statusCode"] = self::SERVICES_NO_EXISTES;
        $this->response_data["statusInfo"] = "request error!";

        return $this->response($this->response_data, "json");


    }



}









