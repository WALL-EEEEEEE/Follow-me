<?php 

        namespace Api\androidApi;

use Think\Controller\RestfulController;
        use Api\baseApi\Api;

        /**
 *  提供安卓平台下的关于用户部分的API请求服务
 */

class user extends RestfulController implements Api
{


    /**
     * [获取用户列表API]
     * @return {
     * {"uid1":"userinfo1"},
     * {"uid2","userinfo2"},
     * { "uid3","userinfo3"},
     * ......
     * }[json格式]
     */
    public function user_read_list()
    {
    }

    /**
     * [获取某个特定的用户信息]
     * @return 
     * { "uid":"userinfo"}[json格式数据]
     */
    public function user_read()
    {
    }
}
