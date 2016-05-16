<?php
      namespace Core\Model;

    

/**
 * 学生用户模型类,用于对学生用户的数据进行操作
 */
class StudentUserModel extends UserModel
{

    

    /**
     * 指定的用户辨识类型,和数据库中的分类相同
     * @var [string]
     */
    protected $user_s_type = 1;
    protected $tableName = "student_info";

    
    /**
     * 添加学生 用户信息
     * @override
     * @param [type] $user_data [description]
     */
    public function add($user_data = array())
    {

                 
        //基本用户
        if ($user_data["type"] == null || $user_data["type"] == "") {
            echo "base user type"."</br>";
            $user_id  = parent::add($user_data);
            return  $user_id ;
        //学生用户
        } else if ($user_data["type"] == $this->user_s_type) {
            echo "student user"."</br>";
            $model = M("student_info");
            $model->startTrans();
            $user_id = parent::add($user_data);
            if ($user_id == null) {
                $model->rollback();
            }
            //获取学生信息
            $student_info["school_id"]  = $user_data["type_info"]["school_id"];
            $student_info["student_id"] = $user_data["type_info"]["student_id"];
            $student_info["enrollment_date"] = $user_data["type_info"]["enrollment_date"];
            $student_info["graduate_date"]   =  $user_data["type_info"]["graduate_date"];
            $student_info["user_id"]    = $user_id;


            if (!$model->add($student_info)) {
                  $model->rollback();
            }
            $model->commit();
            return $user_id;
        }


    }

}


