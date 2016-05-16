<?php

      namespace Core\Common;

      use services\Ucpaas;
      use services\ihuiyi;

/**
 * 验证消息发送类
 */
class Message
{

    private $support_platform = array("ihuiyi","ucpaas");
    
    private $service_handler  = null;

    private $service_platform = null;

    private $ucpaas_config = null;

    public function __construct($service_platform = "", $config = array())
    {
        
        $ucpaas_config = C("MESSAGE.ucpaas");
        $this->ucpaas_config = $ucpaas_config;
        $service_platform = !empty($service_platform)?$service_platform: !empty($ucpaas_config) ? "ucpaas":"";
        $this->service_platform = $service_platform;

        
        if (empty($service_platform)) {
            throw new \Exception("not specify the platform!");
        }

        if (!in_array($service_platform, $this->support_platform)) {
            throw new \Exception("Sorry! ".$service_platform." is not supported yet!");
        }


      //根据相应的平台读取相关配置初始化服务
        switch ($service_platform) {
            case 'ihuiyi':
                if ((C("MESSAGE.ihuiyi.account") == null || trim(C("MESSAGE.ihuiyi.account")) == "")&&!in_array("account", $config)) {
                     throw new \Exception("account can't be null");
                } else {
                    $account = isset($config["account"])?$config["account"]:C("MESSAGE.ihuiyi.account");
                }

                if ((C("MESSAGE.ihuiyi.password") == null || trim(C("MESSAGE.ihuiyi.password")) == "")&&!in_array("password", $config)) {
                      throw new \Exception("password can't be null");
                } else {
                    $password = isset($config["password"])?$config["password"]:C("MESSAGE.ihuiyi.password");
                }

                    $this->service_handler = new Ihuiyi($account, $password, $tele_num);

                break;

            case "ucpaas":
                $options = array();
                

                if (($ucpaas_config["accountsid"] == null && trim($ucpaas_config["accountsid"]) == "")&&!in_array("accountsid", $config)) {
                    throw new \Exception("accountsid can't be null");
                } else {
                    $options["accountsid"] = isset($config["accountsid"])?$config["accountsid"]:$ucpaas_config["accountsid"];
                }

                $ucpaas_token_config = $ucpaas_config["token"];
                if (empty($ucpaas_token_config)&&!in_array("token", $config)) {
                    throw new \Exception("token can't be null");
                } else {
                    $options["token"] = isset($config["token"])?$config["token"]:$ucpaas_token_config;
                }
                 $this->service_handler = new Ucpaas($options);

                break;

        
            default:
                break;
        }



    }


    public function send($code, $telephone)
    {

        if ($this->service_platform == "ucpaas") {
            if (empty($telephone)) {
                  throw new \Exception("telenum can't be null");
            }
            $param = "Follow Me,".$code;
            $ucpaas_appId_config = $this->ucpaas_config["appId"];
            if (empty($ucpaas_appId_config)&&!in_array("appId", $config)) {
                      throw new \Exception("appId can't be null");
            } else {
                      $ucpaas_appId_config = isset($config["appId"])?$config["appId"]:$ucpaas_appId_config;
            }

     
            $ucpaas_templateId_config = $this->ucpaas_config["templateId"];
            dump(empty($ucpaas_templateId_config));
            if (empty($ucpaas_templateId_config)&&!in_array("templateId", $config)) {
                    throw new \Exception("templateId can't be null");
            } else {
                    $ucpaas_templateId_config = !empty($config["templateId"])?$config["templateId"]:$ucpaas_templateId_config;
            }
            dump($ucpaas_appId_config);
            dump($this->service_handler->templateSMS($ucpaas_appId_config, $telephone, $ucpaas_templateId_config, $code));

            return $this->service_handler->templateSMS($ucpaas_appId_config, $telephone, $ucpaas_templateId_config, $param);
        } else {
              return  $this->service_handler->send($code,$telephone);
        }
    }
}
