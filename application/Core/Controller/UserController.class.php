<?php
      namespace Core\Controller;

use Think\Controller;
use Think\Model;
use Think\Verify;
use services\Ucpaas;
use Core\Common\Mail;
use Core\Common\Message;
use Core\Model\UserModel;

/**
 *  用来处理用户相关业务逻辑
 *  @TODO 邮箱是否已经注册,手机号码是否已经注册,以及用户名是否已经注册的判断需要完善
 */
class UserController extends Controller
{
    //注册状态码
    const REG_SUCCESS      = 0;
    const REG_ERROR_INSERT = "00101";
    const REG_EMAIL_EMPTY  = "00102";
    const REG_USER_TYPE_NOEXIST = "00103";
    const REG_USER_TYPEINFO_IMCOMPLETED = "00104";
    const REG_USER_USERNAME_FORMAT_INCORRECT = "00105";
    const REG_USER_USERNAME_EMPTY     = "00106";
    const REG_USER_PASSWORD_EMPTY     = "00107";
    const REG_USER_PASSWORD_FORMAT_INCORRECT  = "00108";
    const REG_USER_EMAIL_FORMAT_INCORRECT = "00109";
    const REG_USER_PHONE_FORMAT_INCORRECT = "00110";
    const REG_USER_NAME_EXISTED  = "00111";
    const REG_USER_EMAIL_REGISTERED = "00112";
    const REG_USER_PHONE_REGISTERED = "00113";
    const REG_PHONE_EMPTY  = "00114";

    const REG_STUDENT_ID_EMPTY= "00201";
    const REG_STUDENT_ID_ERROR = "00202";
    const REG_STUDENT_SCHOOL_EMPTY = "00203";
    const REG_STUDENT_SCHOOL_ERROR = "00204";
    const REG_STUDENT_EROLLMENT_ERROR = "00205";
    const REG_STUDENT_GRADUATE_ERROR = "00206";

    const REG_TYPE_NO_IMPLICIT   = "00301";
    const REG_TYPE_NO_SUPPORT    = "00302";
    const REG_TYPE_FORMAT_INCORRECT = "00303";



    //手机激活状态码
    const PHONE_ACTIVATE_SUCCESS       = 0;
    const PHONE_ACTIVATE_ACTIVATED     = "00401";
    const PHONE_ACTIVATE_ACODE_ERROR   = "00402";
    const PHONE_ACTIVATE_ACODE_EXPIRED = "00403";
    // const PHONE_ACTIVATE_ACCOUNT_NOEXIST = "00404";
    const PHONE_ACTIVATE_SESSION_USER_NOEXIST = "00405";
    const PHONE_ACTIVATE_USER_NOEXIST = "00406";
    const PHONE_ACTIVATE_USER_ACTIVATEINFO_NOEXIST = "00407";
    const PHONE_ACTIVATE_CODE_GENERATE_ERROR = "00408";
    const PHONE_ACTIVATE_STATUS_UPDATE_ERROR = "00409";
    const PHONE_ACTIVATE_MSG_SEND_FAILED = "00410";


    //邮件激活状态码
    const MAIL_ACTIVATE_SUCCESS       = 0;
    const MAIL_ACTIVATE_ACTIVATED     = "00501";
    const MAIL_ACTIVATE_ACODE_ERROR   = "00502";
    const MAIL_ACTIVATE_ACODE_EXPIRED = "00503";
    // const MAIL_ACTIVATE_ACCOUNT_NOEXIST = "00504";
    const MAIL_ACTIVATE_SESSION_USER_NOEXIST = "00505";
    const MAIL_ACTIVATE_USER_NOEXIST = "00506";
    const MAIL_ACTIVATE_USER_ACTIVATEINFO_NOEXIST = "00507";
    const MAIL_ACTIVATE_CODE_GENERATE_ERROR  = "00508";
    const MAIL_ACTIVATE_EXPIRED = "00509";
    const MAIL_ACTIVATE_STATUS_UPDATE_ERROR = "00510";
    const MAIL_ACTIVATE_PARAMETER_ERROR ="00511";
    const MAIL_ACTIVATE_SEND_FAILED  = "00512";
    




    //用户初始化错误码
    const REG_INITIAL_INTERNAL_ERROR = "00601";
    const REG_INITIAL_FAILED  = "00602";
    const REG_INITIAL_MAIL_ACTIVATE_INFO_FAILED = "00603";
    const REG_INITIAL_PHONE_ACTIVATE_INFO_FAILED = "00604";


    private $activate_code_info = array(
      ACTIVATE_SUCCESS => "Activated success",
      ACTIVATE_ACTIVATED=> "Duplicating,The account has activated.",
      ACTIVATE_ACODE_ERROR=>"Activate code is error!",
      ACTIVATE_ACODE_EXPIRED=>"Activate code has out of date!",
      ACTIVATE_ACCOUNT_NOEXIST=>"Account is not exists!",
      );


    //默认的邮件验证码过期时间为30分钟
    private $phone_regex = "/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|70)\\d{8}$/";
    private $email_regex = "/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";

    // 24小时
    private $default_email_vcode_expire_time = 1440;
    private $default_phone_vcode_expire_time = 3;
    
    protected $UserCate = array("User" ,"StudentUser" ,"SchoolUser","CompanyUser");
    private $registerType = array(1=>"mail",2=>"telephone");



   
    protected $registStatusTips = array(
        REG_FAILED       => "register failed, Perhaps you have some infomation incorrected.",
        REG_SUCCESS      => "reigster success, you can login now.",
        REG_ERROR_INSERT => "register failed, sorry some error occurs internally!"
    );
    


    public function login()
    {
        $model = M("User");
        $user_info =  $model->getDbFields();


         //获取用户的信息,验证用户的信息,登陆
    }

    public function authetic()
    {
    }

    
    /**
     * 用户注册
     * @param  [string]  $u_name        [用户名]
     * @param  [string]  $u_pwd         [用户密码]
     * @param  [integer] $u_type        [用户类型]
     * @param  integer   $register_type [用户注册类别]
     * @param  string    $u_check_mail  [用户注册邮箱]
     * @param  string  $u_check_phone   [用户注册手机号]
     * @param  array   $options         [用户可选信息]
     * @return [boolean]                [0,表示注册成功,非0表示注册失败]
     */
    public function register($u_name, $u_pwd, $u_type, $register_type = 1, $u_check_mail = '', $u_check_phone = '', $options = array())
    {
        $user_data = array(
                "user_name"   =>$u_name,
                "user_pwd"    =>$u_pwd,
                "type"        =>$u_type,
                "user_mail"   =>$u_check_mail,
                "tele_num"    => $u_check_phone,
                "register_by" => $register_type,
                "type_info"   => $options
        );
                

        
        //基本用户信息验证

        //限制用户名

        //用户名不能为空
        if (trim($u_name) == "") {
            return self::REG_USER_USERNAME_EMPTY;
        }
 
        //用户名格式要求,用户名不能是数字
        if (is_numeric($u_name)) {
            return self::REG_USER_USERNAME_FORMAT_INCORRECT;
        }

        //限制用户密码
        
        //密码不能为空
        if (trim($u_pwd) =="") {
            return self::REG_USER_PASSWORD_EMPTY;
        }

        //密码格式要求,密码不能为纯数字,纯英文,密码长度>=6
        if (preg_match("/^(?:\d+|[a-zA-Z]+)$/", $u_pwd) && strlen($u_pwd) < 6) {
            return self::REG_USER_PASSWORD_FORMAT_INCORRECT;
        }

        $user = new UserModel();
        //注册方式支持检测
        if (trim($register_type) == "") {
              return self::REG_TYPE_NO_IMPLICIT;
        }

        if (!is_numeric($register_type) || $register_type < 0) {
              return self::REG_TYPE_FORMAT_INCORRECT;
        }
       
        $is_support = $user->registerTypeSupport($register_type);
        if (!$is_support) {
              return self::REG_TYPE_NO_SUPPORT;
        }

        $u_check_mail = trim($u_check_mail);
        $u_check_phone = trim($u_check_phone);

        //邮箱登陆,邮箱不能为空
        if ($this->registerType[$register_type] == "mail" && empty($u_check_mail)) {
               return self::REG_EMAIL_EMPTY;
        }

        //手机登陆,手机号不能为空
        if ($this->registerType[$register_type] == "telephone" && empty($u_check_phone)) {
               return self::REG_PHONE_EMPTY;
        }

        //邮箱格式限制
        if ($u_check_mail != "" && !preg_match($this->email_regex, $u_check_mail)) {
             return self::REG_USER_EMAIL_FORMAT_INCORRECT;
        }

        //手机号码格式限制
        if ($u_check_phone != "" && !preg_match($this->phone_regex, $u_check_phone)) {
             return self::REG_USER_PHONE_FORMAT_INCORRECT;
        }

                   
        //特定用户信息验证
        //学生信息验证
        if ($this->UserCate[$u_type] == "StudentUser") {
            //学号不能为空
            if (trim($options["type_info"]["stu_id"]) == "" || $options["type_info"]["stu_id"] == null) {
                return self::REG_STUDENT_ID_EMPTY;
            }
            //学号只能是数字
            if (is_numeric($options["type_info"]["stu_id"]) || $options["type_info"]["stu_id"] < 0) {
                return self::REG_STUDENT_ID_ERROR;
            }

            //学校不能为空
            if (trim($options["type_info"]["school_id"]) == "" || $options["type_info"]["school_id"] == null) {
                return self::REG_STUDENT_SCHOOL_EMPTY;
            }

            //学校ID只能是数字
            if (is_numeric($options["type_info"]["school_id"]) || $options["type_info"]["school_id"] < 0) {
                return self::REG_STUDENT_SCHOOL_ERROR;
            }

            //入学日期和毕业日期格式是否正确
            if (!strtotime($options["type_info"]["graduate_date"]) || strtotime($options["type_info"]["graduate_date"]) == -1) {
                return self::REG_STUDENT_GRADUATE_ERROR;
            }
            if (!strtotime($options["type_info"]["enrollment_date"]) || strtotime($options["type_info"]["enrollment_date"]) == -1) {
                return self::REG_STUDENT_EROLLMENT_ERROR;
            }
        }


        
        $user = new UserModel();
        //检查用户是否已经存在
        if ($this->aliasExists(trim($u_name))) {
             return self::REG_USER_NAME_EXISTED;
        }



         //判断是否注册用户是否有信息重复
        if ($u_check_mail != '' && $this->registerType[$register_type ]== "mail") {
           //检查邮箱是否已经注册激活过
            if ($user->mailRegistered($u_check_mail)) {
                return self::REG_USER_EMAIL_REGISTERED;
            }
        } elseif ($u_check_phone != '' && $this->registerType[$register_type] == "telephone") {
            //检查手机是否注册激活过
            if ($user->phoneRegistered($u_check_phone)) {
                  return self::REG_USER_PHONE_REGISTERED;
            }
        }

        
       //调用指定用户模块更新用户数据

        if ($this->UserCate[$u_type] == null) {
                return self::REG_USER_TYPE_NOEXIST;
        }


        $class = "\Core\Model\\".$this->UserCate[$u_type]."Model";
        $user = new $class();

        $uid = $user->add($user_data);

        if ($uid != null) {
        //初始化用户
            session("user_id", $uid);
            $initial_res = $this->initialAccountStatus($uid);

            if ($initial_res != true) {
                return $initial_res;
            }

                return  self::REG_SUCCESS;
        } else {
                return self::REG_ERROR_INSERT;
        }

    }


    /**
     * 验证码生成
     * @return [string] [图像二进制数据]
     */
    public function vCode()
    {
        $VerifyCodeStyle = array();
        $Verify = new Verify($VerifyCodeStyle);
        $Verify->entry();

        return $Verify->getImage();
    }

    /**
     * 邮箱注册激活邮件发送
     * @return [integer]    [0为发送成功,非0为发送失败]
     */
    public function mailRegisterSend($mail = "")
    {

        $user_id = null;

        //验证Session中是否有用户信息
        if (!session("?user_id")) {
            return self::MAIL_ACTIVATE_SESSION_USER_NOEXIST;
        } else {
            $user_id = session("user_id");
        }

        //验证数据库中是否有用户信息
        $user = new UserModel();

        if (!$user->userExist($user_id)) {
            return self::MAIL_ACTIVATE_USER_NOEXIST;
        }

        //验证数据库中是否有用户的邮箱激活信息

        $account_status = M("mail_activate");

        $acc_info = null;
        if ($user_id != null) {
            $acc_info =  $account_status->where("u_id = '".$user_id."'")->find();
        } else {
            return self::MAIL_ACTIVATE_USER_ACTIVATEINFO_NOEXIST;
        }

    
        //防止重复激活
        if ($user->isActivate($uid)) {
            return self::MAIL_ACTIVATE_ACTIVATED;
        }

        //生成激活码
        $user_info = $user->getUserInfo($user_id);


        //生成邮箱激活码,限定激活期限
        $genActivatedCode = md5($user_info["mail"]+$user_info["user_pwd"]+$user_id);
        $genExpire        = date("Y:m:d h:m:s", time()+$this->default_email_vcode_expire_time*60);
        $update_data  = array(
         "activate_code" => $genActivatedCode,
         "time_expire"   => $genExpire);
        $update_res = $account_status->where("u_id = '".$user_id."'")->setField($update_data);

        if (!$update_res) {
            return self::MAIL_ACTIVATE_CODE_GENERATE_ERROR;
        }

        //生成激活链接

        $activate_url  = "http://".$_SERVER["HTTP_HOST"]."/api/android/user/register_by_mail/activate?ac=".base64_encode($user_info["mail"])."&k=".$genActivatedCode;
        $activate_url = "<a href=\"".$activate_url."\""."  target=\"_blank\">"."点击这里激活账号"."</a>";
        $info = array($user_info["user_alias"],$activate_url,date("Y年-m月-d日"));
        $mail_sender = new Mail();
        $reciever = array($acc_info["reg_mail"]);

        $send_res = $mail_sender->send($reciever, $info);

        if ($send_res != 0) {
               return self::MAIL_ACTIVATE_SEND_FAILED;
        }

        return 0;




}

    /**
     * 手机注册短信发送
     * @return [integer | boolean] [成功返回true,失败返回非0状态码]
     */
    public function phoneRegisterMsgSend()
    {
         //验证用户session是否存在
         $user_id = null;

        //验证Session中是否有用户信息
        if (!session("?user_id")) {
            return self::PHONE_ACTIVATE_SESSION_USER_NOEXIST;
        } else {
            $user_id = session("user_id");
        }

        //验证数据库中是否有用户信息
        $user = new UserModel();

        if (!$user->userExist($user_id)) {
            return self::PHONE_ACTIVATE_USER_NOEXIST;
        }

        //验证数据库中是否有用户的邮箱激活信息

        $account_status = M("phone_activate");

        $acc_info = null;
        if ($user_id != null) {
            $acc_info =  $account_status->where("uid = '".$user_id."'")->find();
            if (empty($acc_info)) {
                 return self::PHONE_ACTIVATE_USER_ACTIVATEINFO_NOEXIST;
            }
        }
    
        //防止重复激活
        if ($user->isActivate($user_id)) {
            return self::PHONE_ACTIVATE_ACTIVATED;
        }

        //生成激活码
        $user_info = $user->getUserInfo($user_id);


        //生成短信验证码,并限定期限
        $genExpire        = date("Y:m:d H:i:s", $this->default_phone_vcode_expire_time*60+time());

        $genActivatedCode   = random(6, 1);
        $update_data  = array(
         "activate_code" => $genActivatedCode,
         "time_expire"   => $genExpire);
        $update_res = $account_status->where("uid = '".$user_id."'")->setField($update_data);

        if (!$update_res) {
            return self::PHONE_ACTIVATE_CODE_GENERATE_ERROR;
        }

        $msg_sender = new Message();
        $send_check = $msg_sender->send($genActivatedCode, $acc_info["reg_phone"]);
        
        if ($send_check) {
            return 0;
        } else {
            return self::PHONE_ACTIVATE_MSG_SEND_FAILED;
        }



         
    }

   

     /**
     * @TODO 可能需要进行优化,这里
     * 初始化用户账号状态
     * @param  $uid   用户账号id
     * @return [boolean] 初始化成功为true,初始化返回状态码
     */

    
    private function initialAccountStatus($uid)
    {
         $user_id = $uid;
         //获取用户的邮箱账号
         $user = new UserModel();
         $user_info = $user->field("mail,user_pwd,tele_num")->where("user_id = '".$user_id."'")->find();

     
        //邮箱激活账号

       
        if ($user_info["mail"] != null && $user->isMailActivate($uid)) {
            $account_data = array(
            "u_id" => $user_id,
            "reg_mail" => $user_info["mail"],
            "account_status" => 0,
                     );
            $model  = M();
            $res = $model->table("mail_activate")->data($account_data)->add();

            if (!$res) {
                return self::REG_INITIAL_MAIL_ACTIVATE_INFO_FAILED;
            }

            return true;
        }

        //手机短信激活账号状态初始化
        if ($user_info["tele_num"] != null && $user->isPhoneActivate($uid)) {
            $account_data = array(
            "uid" => $user_id,
            "reg_phone" => $user_info["tele_num"],
            "account_status" => 0,
            );
            $model  = M();
            $res = $model->table("phone_activate")->data($account_data)->add();

            if (!$res) {
                return self::REG_INITIAL_PHONE_ACTIVATE_INFO_FAILED;
            }

            return true;
        }


        return self::REG_INITIAL_INTERNAL_ERROR;
}

    /**
     * 短信验证码验证
     * @param  [string] $activate_code [激活码]
     * @return [integer]               [0,激活成功,非0,激活失败]
     */
    public function mobileMsgVerify($code_from)
    {
         //检查用户是否存在
        $user = new UserModel();
        $uid = session("user_id");
        if (empty($uid)) {
            return self::PHONE_ACTIVATE_SESSION_USER_NOEXIST;
        }

        if (!$user->userExist($uid)) {
            return self::PHONE_ACTIVATE_USER_NOEXIST;
        }

        $mail_activate = M("phone_activate");
        $activate_info = $mail_activate->field("activate_code,time_expire")->where("uid = '".$uid."'")->find();

        //验证码信息是否存在
        if ($acticate_info["activate_code"] == null && $activate_info == false) {
            return self::PHONE_ACTIVATE_USER_ACTIVATEINFO_NOEXIST;
        }

        //用户是否已经通过验证
        if ($user->isActivate($uid)) {
            return self::PHONE_ACTIVATE_ACTIVATED;
        }

        //验证码是否过期
        if (strtotime($activate_info["time_expire"]) <= time()) {
              return self::PHONE_ACTIVATE_ACODE_EXPIRED;
        }


        //验证激活码是否正确
        if ($activate_info["activate_code"] != $code_from) {
             return self::PHONE_ACTIVATE_ACODE_ERROR;
        } else {
             //更新状态
             $update_res = $mail_activate->where("uid = '".$uid."'")->setField("account_status", "1");
            if (!$update_res) {
                  return self::PHONE_ACTIVATE_STATUS_UPDATE_ERROR;
            }
             //销毁session
             session("user_id", null);
             return 0;
        }

    
    }

   
    /**
     * 邮箱激活
     * @param  [string] $activate_code [激活码]
     * @param  [string] $mailAccount   [邮箱账号]
     * @return [integer]               [0代表激活成功,否则返回非0激活码]
     */
    public function mailActivate($activate_code, $mailAccount)
    {
        //检查用户是否存在

        
        $user = new UserModel();

        if (empty($activate_code) || empty($mailAccount)) {
              return self::MAIL_ACTIVATE_PARAMETER_ERROR;
        }

        $user_exist = $user->field("user_id")->where("mail = '".base64_decode($mailAccount)."'")->find();
        $uid = $user_exist["user_id"];
 

        if (empty($uid)) {
               return self::MAIL_ACTIVATE_USER_NOEXIST;
        }

        $mail_activate = M("mail_activate");
        $activate_info = $mail_activate->field("activate_code,time_expire")->where("u_id = '".$uid."'")->find();

        //用户验证信息不存在
        if ($acticate_info["activate_code"] == null && $activate_info == false) {
            return self::MAIL_ACTIVATE_USER_ACTIVATEINFO_NOEXIST;
        }

        //用户是否已经激活
        if ($user->isActivate($uid)) {
            return self::MAIL_ACTIVATE_ACTIVATED;
        }

        //用户验证信息是否过期
        if (strtotime($activate_info["time_expire"]) <= time()) {
              return self::MAIL_ACTIVATE_EXPIRED;
        }


        //验证激活码是否正确
        if ($activate_info["activate_code"] != $activate_code) {
             return self::MAIL_ACTIVATE_ACODE_ERROR;
        } else {
             //更新状态
             $update_res = $mail_activate->where("u_id = '".$uid."'")->setField("account_status", "1");
            if (!$update_res) {
                  return self::MAIL_ACTIVATE_STATUS_UPDATE_ERROR;
            }
            //销毁session
            session("user_id", null);
             return 0;
        }

    }


    /**
     * 验证码验证
     * @param  [string] $code [验证码字符]
     * @return [boolean]     验证通过返回true,验证失败返回false
     */
    public function vCodeCheck($code)
    {
        $Verify = new Verify();
        return  $Verify->check($code);
    }
    
    /**
     * 判断用户昵称是否存在
     * @param  [string] $alias [用户别名名称]
     * @return [boolean] true,存在;false,不存在
     */
    public function aliasExists($alias)
    {
        $user =  D("Core/User");
        $check_res = $user->userNameRegistered($alias);
        return $check_res;
    }

    /**
     * [判断email是否已经被注册]
     * @param  [string] $email [邮箱号码]
     * @return [boolean] true已经存在,false,不存在
     */
    public function emailExists($email = '')
    {
        $user = new UserModel();
        $check_res = $user->mailRegistered($email);

        return $check_res;
    }


    /**
     * [判断电话是否已经被注册]
     * @param  [string] $tele_num [电话号码]
     * @return [boolean] true已经存在,false不存在
     */
    public function teleExists($tele_num)
    {
        $user = new UserModel();
        $check_res = $user->phoneRegistered($tele_num);

        return $check_res;
    }


    /**
     * 返回状态提示信息
     * @param  [type] $statusCode [description]
     * @return [type]             [description]
     */
    public function getStatusInfo ($statusCode) 
    {

    }
}
