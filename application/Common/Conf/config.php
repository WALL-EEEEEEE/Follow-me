<?php
return array(
    //开启应用程序的url路由
    'URL_ROUTER_ON' => true,
    'SHOW_PAGE_TRACE'=>true,

    //配置数据库
    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'follow_me',
    'DB_USER' => 'root',
    'DB_PWD'  => 'root',
    'DB_PORT' => '3306',
    'DB_PREFIX'=> '',
    'DB_CHARSET'=> 'utf8',

    //邮件发送配置
    "MAILER" => array(
        "Host" => "smtp.163.com",
        "Username" => "duanqingbb@163.com",
        "Password" => "duanduan123", //smtp客户端授权密码
        "isSMTP"  =>  true,
        "Sender"  =>  "duanqingbb@163.com",
        "SenderName" => "Follow Me 团队",
        "HTMLTemplete" => "mail_regiester.html", //指定邮箱激活html内容模板
        ),

    //短信发送配置
    "MESSAGE" => array(
        "ucpaas" => array(
            "accountsid" => "6210230731ffa83724db3f0e5b63507b",
            "token"  =>"c23412d7fdec2bec285b1913e7e5bef1",
            "appId" =>"541103cba446490f86835d7e6a46c0c9",
            "templateId" =>"23580",
            ),
        )

    
);
