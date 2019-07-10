<?php
/**
 * User: Geeson 314835050@qq.com
 * Date: 2017/9/9
 * Time: 18:22 中国·上海
 */

namespace addons\h5\model;


use think\Model;

class UserLockInfo extends Model
{

    public function geUserLockInfoList($where=[],$order='id DESC',$row=10){
       return $this->where($where)
            ->order($order)
            ->paginate($row);
    }
}