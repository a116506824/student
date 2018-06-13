<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\admin\model;

use think\Model;
use think\Db;

class OrderModel extends Model {

    public function indexModel($where) {
        $data = Db::name('order ord')
                ->join('employment emp','ord.se_id = emp.id')
                ->field('ord.id,emp.se_name as emname,ord.so_post,ord.so_starttime,ord.so_endtime,ord.so_count,ord.so_length,ord.so_price,ord.so_other,ord.so_remark')
                ->where('ord.so_status',$where)->order('ord.id asc')->paginate(10);
        return $data;
    }
    
    public function addPostModel($data) {
        $data['se_id'] = $data['id'];
        unset($data['id']);
        $result = Db::name('order')->insert($data);
        return $result;
    }
}
