<?php

    return array(
        "URL_ROUTE_RULES"=>array(
            "android/user/register_by_phone/activate" => "android/RegisterMobileActivate",
            "android/user/register_by_phone/msg_send" => "android/RegisterActivateMsgSend",
            "android/user/register_by_mail/mail_send" => "android/RegisterActivateMailSend",
            "android/user/register_by_mail/activate"  =>"android/RegisterMailActivate" ,
            "android/user/register_by_phone"          =>"android/register_by_phone",
            "android/user/register_by_mail"           =>"android/register_by_mail",
            "android/user/phone_is_register"          =>"android/userTelExist",
            "android/user/mail_is_register"           =>"android/userEmailExist",
            "android/user/username_is_register"       =>"android/userNameExist",
            "android/user/login/vcode"                => "android/RegisterVcode",
            ),
        
         );
