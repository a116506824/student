<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\admin\model;

use think\Model;
use think\Db;

class StudentModel extends Model {

    public function indexModel($where) {
        $data = Db::name('student st')
                ->join('school sc','st.ssc_id = sc.id')
                ->join('department de','de.id = st.sm_id')
                ->field('st.id,st.ss_sex,st.ss_name,st.ss_birthday,st.ss_height,st.ss_phone,sc.name as school,de.name as department')
                ->where($where)->order('id asc')->paginate(10);
        return $data;
    }
    
    public function del($id,$field){
        $result = Db::name("student")->where($id)->setField($field);
        return $result;
    }


    public function addPostModel($data) {
        $result = Db::name('student')->insert($data);
        return $result;
    }
    
    public function editModel($id) {
        $data = Db::name('student st')
                ->join('school sc','st.ssc_id=sc.id')
                ->join('department de','st.sm_id=de.id')->where($id)
                ->field('st.id,st.ss_name,st.ss_sex,st.ss_birthday,st.ss_height,st.ss_phone,sc.id as scid,sc.name as scname,de.id as deid,de.name as dename,st.ss_alipay,st.ss_wechat,st.ss_assessment,st.ss_remark')
                ->find();
        return $data;
    }
    
    public function editPostModel($param) {
        $id['id'] = $param['id'];
        unset($param['id']);
        $result = Db::name('student')->where($id)->update($param);
        return $result;
    }

}
