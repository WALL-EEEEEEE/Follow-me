<?php
     namespace Core\Model;

     use Think\Model;

class CompanyUserModel extends UserModel
{
	 $user_s_type = 3;

	 public function add($user_data)
	 {

	 	 //基本用户
        if ($user_data["user_type"] == null || $user_data["user_type"] == "") {
            $user_id  = parent::add($user_data);
            return  $user_id ;
        //学生用户
        } else if ($user_data["user_type"] == $user_s_type) {
            $this->startTrans();
            $baseUser = new UserModel();
            $user_id = $baseUser->add($user_data);
            if ($user_id == null) {
                $this->rollback();
            }
            //获取公司信息
            $com_id      = $user_data["com_id"];
            $corporation = $user_data["corporation"];
            $com_type    = $user_data["com_type"];
            $com_tel     = $user_data["com_tel"];
            $com_mail    = $user_data["com_mail"];
            $com_locate  = $user_data["com_locate"];
            $com_locate  = $user_data["com_lc_details"];
            $this->create();
            $this->table("company_info")->add();
            $this->commit();
            $this->close();
        }

	 }
}



