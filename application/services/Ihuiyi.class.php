<?php
        namespace services;


/**
 * 互亿无线短信服务SDK
 */
classa Ihuiyi 
{

     
      protected $limitNumsMember = 3;
      protected $frozenTime      = 60;
      protected $limitIP  = false;
      protected $limitNumber = true;
      protected $limitTime = true;

      private  $account = "cf_duanduan" ;
      private  $pwd     = "b181f082ec9cc847e24eec6a2f5d1a76";
      private  $reciver_mobile  = "13132283239";

      const  API_ADDRESS = "http://106.ihuyi.com/webservice/sms.php?method=Submit";

      protected $required_data = array();




      function __construct($account = "",$pwd = "",$to="")
      {

        $this->$account =($account != "")?$account:C("MESSAGE.ACCOUNT");
        $this->$pwd    =($pwd != "")?$pwd:C("MESSAGE.PASSWORD");

       
      }

     public function setmobile($telenum)
     {
     	    $this->reciver_mobile = $telenum;

     }

     public function send($content = "")
      {

        $require_data["Method"]  =  "Submit";
        $require_data["mobile"]  = $this->reciver_mobile;
        $require_data["account"] = $this->account;
        $require_data["password"] = $this->pwd;
        $require_data["content"]  = $content;


		$curl = curl_init();
		var_dump(self::API_ADDRESS);
		curl_setopt($curl, CURLOPT_URL,self::API_ADDRESS);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $require_data);
		$return_str = curl_exec($curl);
		var_dump(curl_error($curl));
		var_dump($return_str);
		curl_close($curl);

		return $return_str; 


      }




}


  
