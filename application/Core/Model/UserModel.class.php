<?php
      namespace Core\Model;

      use Think\Model;

/**
 *  用户模型类,用来对用户的数据进行操作
 */
class UserModel extends Model
{

    public function add($user_data = array())
    {

       
        //提取用户基本用户数据
        $data["user_alias"] = $user_data["user_name"];
        $data["user_pwd"]  = md5($user_data["user_pwd"]);
        $data["user_id"]   = "fm_".dechex($this->getLastInsID()).time();
        $data["mail"]      = $user_data["user_mail"];
        $data["tele_num"]  = $user_data["tele_num"];
        $data["user_type"] = $user_data["type"];
        $data["register_by"] = $user_data["register_by"];


        $user = M("user");


        $res_check = $user->data($data)->add();
  
        if (!$res_check) {
             return false;
        } else {
            return  $data["user_id"];
        }


    }


    //检测用户是否是通过手机注册账号
    public function isPhoneActivate($uid)
    {

        $register_type = M("register_type");
        $type_id =  $register_type->table("user")->field("register_by")->where("user_id = '".$uid."'")->find();

        if ($type_id == null || $type_id == false) {
            return false;
        }

        $type_name = $register_type->field("reg_type_name")->where("reg_type_id = '".$type_id["register_by"]."'")->find();

        if ($type_name["reg_type_name"] == "telephone") {
            return true;
        } else {
            return false;
        }




    }



    //检测用户是否是通过邮箱注册账号
    public function isMailActivate($uid)
    {
        $register_type = M("register_type");
        $type_id =  $register_type->table("user")->field("register_by")->where("user_id = '".$uid."'")->find();

        if ($type_id == null || $type_id == false) {
            return false;
        }
        $type_name = $register_type->field("reg_type_name")->where("reg_type_id = '".$type_id["register_by"]."'")->find();

        if ($type_name["reg_type_name"] == "mail") {
            return true;
        } else {
            return false;
        }
    }



    public function registerTypeSupport($type_id)
    {
        $register_type = M("register_type");
        $is_support = $register_type->where("reg_type_id = '".$type_id."'")->find();
        if ($is_support == null || $is_support == false) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * 判断用户的信息是否存在
     * @param  [string] $uid [用户id]
     * @return [boolean]      [true,表示存在,false,表示不存在]
     */
    public function userExist($uid)
    {
        $user = M("user");
        $check = $user->where("user_id = '".$uid."'")->find();
        if ($check != null && $check != false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取用户信息
     * @param  [string] $uid [用户id]
     * @return [array || boolean]      [获取成功返回用户信息数组,失败,返回false]
     */
    public function getUserInfo($uid)
    {
        $user = M("user");
        $check = $user->where("user_id = '".$uid."'")->find();
        if ($check != null && $check != false) {
            return $check;
        } else {
            return false;
        }

    }

    /**
     * 用户是否已经激活
     * @param  [string]  $uid [用户id]
     * @return boolean      [true,已经激活,false,未激活]
     */
    public function isActivate($uid)
    {
        $user_mail_activate = M("mail_activate");
        $user_phone_activate = M("phone_activate");

        $is_mail_activate = $user_mail_activate->where("u_id = '".$uid."' and account_status= 1")->find();
        $is_phone_activate = $user_phone_activate->where("uid ='".$uid."' and account_status = 1")->find();

        if (($is_mail_activate != false && $is_mail_activate != null) || ($is_phone_activate != null && !$is_phone_activate)) {
              return true;
        } else {
            return false;
        }


    }

    
    /**
     * 检测邮箱是否已经被注册过
     * @param  [string] $mail_num [邮箱号码]
     * @return [boolean]           [true,已经注册过,false,还未注册过]
     */
    public function mailRegistered($mail_num)
    {
        $user_mail_activate = M("mail_activate");
        
        //查看用户注册表中的邮箱是否存在
        $user = M("user");
        $user_info  = $user->field("user_id")->where("mail = '".$mail_num."' and register_by = 1")->find();
        $uid   = $user_info["user_id"];

        if ($uid != null && $uid != false) {
            //邮箱是否已经激活
            $check_res = $user_mail_activate->where("u_id = '".$uid."' and account_status = 1")->find();

            if (!empty($check_res)) {
                return true;
            }
        }
        return false;
    }

   /**
    * 检测手机号码是否已经被注册过
    */

    public function phoneRegistered($phone_num)
    {
        $user_phone_activate = M("phone_activate");

        //查看用户注册表中的手机号码是否存在
        $user = M("user");
        $user_info = $user->field("user_id")->where("tele_num= '".$phone_num."' and register_by= 2")->find();
        $uid = $user_info["user_id"];

        if ($uid != null && $uid != false) {
             //手机是否通过验证
            $check_res = $user_phone_activate->where("uid = '".$uid."' and account_status = 1")->find();

            if ($check_res != null || $check_res != false) {
                return true;
            }
        }
        return false;

    }

    /**
     * 检测用户名是否被注册过
     * @param  [string] $user_alias [用户名]
     * @return [boolean]            [true,用户已经被注册,false,用户还没注册]
     */
    public function userNameRegistered($user_alias)
    {
        $user = M("user");

        $check_res = $user->join("mail_activate ON user.user_id = mail_activate.u_id")->where("user_alias = '".$user_alias."' and  mail_activate.account_status = 1 ")->union("select * from user INNER JOIN phone_activate ON user.user_id = phone_activate.uid where user_alias = '".$user_alias."' and phone_activate.account_status = 1")->find();
        if (empty($check_res)) {
            return false;
        }

        return true;

    }

}



