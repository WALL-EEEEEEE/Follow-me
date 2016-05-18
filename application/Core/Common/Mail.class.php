<?php
       namespace Core\Common;

/**
 * 邮件发送类
 */

class Mail
{
    
    private $mail = null;
    /** 设置基本的配置项 */
    private $ISSMTP = false;
    private $HOST    = "";
    private $SMTPAuth = true;
    private $Username = "";
    private $Password = "";
    private $SMTPSecure = "ssl";
    private $Port      = 587;
    private $HTMLTemplete = "";


    /** 设置相关出错状态码 **/

    const  MAIL_SEND_SUCCESS = 0;
    const  MAIL_NO_SENDER = 1;
    const  MAIL_NO_ADDRESS = 2;
    const  MAIL_INTERNAL_ERROR = 3;
    const  MAIL_RECIEVER_ADDRESS_INVALIDATE = 4;
    const  MAIL_NO_RECIVER = 5;
    const  MAIL_SENDER_ADDRESS_INVALIDATE = 6;
    const  MAIL_HTML_TEMPLETE_NOEXIST = 7;
    



    /**
     * 初始化邮件配置
     * @param array $config [description]
     */
    public function __construct($config = array(), $debug = false)
    {
        //是否用smtp
        $this->ISSMTP =  isset($config["isSMTP"])?$config["isSMTP"]:C("MAILER.isSMTP") != null ?C("MAILER.isSMTP"):$this->ISSMTP;

        $this->HOST    =   isset($config["Host"])?$config["Host"]:C("MAILER.Host") != null ?C("MAILER.Host"):$this->HOST;

        $this->SMTPAuth    =   isset($config["SMTPAuth"])?$config["SMTPAuth"]:C("MAILER.SMTPAuth") != null ?C("MAILER.SMTPAuth"):$this->SMTPAuth;

        $this->Username    =   isset($config["Username"])?$config["Username"]:C("MAILER.Username") != null ?C("MAILER.Username"):$this->Username;
       
        $this->Password    =   isset($config["Password"])?$config["Password"]:C("MAILER.Password") != null ?C("MAILER.Password"):$this->Password;

        $this->SMTPSecure    =   isset($config["SMTPSecure"])?$config["SMTPSecure"]:C("MAILER.SMTPSecure") != null ?C("MAILER.SMTPSecure"):$this->SMTPSecure;
        
        $this->Port    =   isset($config["Port"])?$config["Port"]:C("MAILER.Port") != null ?C("MAILER.Port"):$this->Port;

        $this->HTMLTemplete = isset($config["HTMLTemplete"])?$config["HTMLTemplete"]:C("MAILER.HTMLTemplete") != null ?C("MAILER.HTMLTemplete"):$this->HTMLTemplete;




        

        $this->mail = new \PHPMailer;
   
        $this->ISSMTP && $this->mail->isSMTP();
        $debug  && $this->mail->SMTPDebug = 3;

        $this->mail->isHTML(true);

        $this->mail->Host = $this->HOST;
        $this->mail->SMTPAuth = $this->SMTPAuth;
        $this->mail->Username = $this->Username;
        $this->mail->Password = $this->Password;
        $this->mail->SMTPSecure = $this->SMTPSecure;
        $this->mail->Port = $this->Port;


        //初始化邮件发送内容
        $this->mail->Subject = "Follow Me 注册";
        $this->mail->CharSet = "utf-8";

       

        
    }


    /**
     * 邮箱发送方法
     * @param  [array || string] $to [收件邮箱]
     * @param  string $from        [发件邮箱]
     * @param  string $sender_name [发件人]
     * @return [integer]           0发送成功,非0发送失败
     */
    public function send($to, $templateVariable  = array(), $from = "", $sender_name = "")
    {
    	$from = $from != "" ? $from : C("MAILER.Sender") != null ? C("MAILER.Sender") : "";
    	$sender_name = $sender_name != "" ? $sender_name : C("MAILER.SenderName") != null ? C("MAILER.SenderName") : "";
  
        if (trim($from) == "") {
            return self::MAIL_NO_SENDER;
        }
            
        if (count($to) == 0) {
            return self::MAIL_NO_RECIVER;
        }
          
        $this->mail->setFrom($from, $sender_name);
        $HtmlParse = new HtmlParse();
        $this->mail->Body    = $HtmlParse->htmlparse("register_validate.html", $templateVariable);
       
        foreach ($to as $key => $value) {
            if (!$this->mail->validateAddress($value, "noregex")) {
                return self::MAIL_RECIEVER_ADDRESS_INVALIDATE;
            }
            $this->mail->addAddress($value);
        }

 
           

        if (!$this->mail->send()) {
            return self::MAIL_INTERNAL_ERROR;
        } else {
            return self::MAIL_SEND_SUCCESS;
        }
    }

  
}
