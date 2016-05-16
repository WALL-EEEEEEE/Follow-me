<?php 

      namespace Core\Model;

      use Think\Model;

/**
 * 开发者用户模型,用来对开发者用户信息的相关操作
 */
class DeveloperUserModel extends UserModel
{
    protected $user_s_type = 3;

    public function add($user_data = array())
    {
        //基本用户
        if ($user_data["user_type"] == null || $user_data["user_type"] == "") {
            $user_id  = parent::add($user_data);
            return  $user_id ;
        //开发者用户
        } else if ($user_data["user_type"] == $user_s_type) {
            $this->startTrans();
            $user_id = parent::add($user_data);
            if ($user_id == null) {
                $this->rollback();
            }
            //获取开发者信息
            $dream_occup     = $user_data["dream_occup"];
            $dream_indust    = $user_data["dream_indust"];
            $master_tech     = $user_data["master_tech"];
            $master_indust   = $user_data["master_indust"];
            $college         = $user_data["college"];
            $erollement_date = $user_data["erollement_date"];
            $graduate_date   = $user_date["graduate_date"];
            $brief_intro     = $user_data["brief_intro"];
            $intership_intro = $user_data["intership_intro"];
            $this->create();
            $index_id = $this->table("developer_info")->add();

            //加入开发者列表
            $develops_data = array("u_id" => $user_id );
            $this->table("developers_info")->data($develops_data)->add();
            
            $this->commit();
            $this->close();
        }

        
    }


}

 ?>