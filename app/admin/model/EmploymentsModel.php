<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\admin\model;

use think\Model;
use think\Db;

class EmploymentsModel extends Model {
    public function indexModel($where) {
        $data = Db::name('employment')->where($where)->order('id asc')->paginate(10);
        return $data;
    }
    
    public function del($id,$field) {
        $result = Db::name('employment')->where($id)->setField($field);
        return $result;
    }
    
    public function deleteModel($id,$field) {
        $result = Db::name('employment')->where($id)->setField($field);
        return $result;
    }
    
    public function addPostModel($param) {
        $result = Db::name('employment')->insert($param);
        return $result;
    }
    
    public function editModel($id) {
        $data = Db::name('employment')->where($id)->find();
        return $data;
    }
    
    public function editPostModel($param) {
        $where['id'] = $param['id'];
        unset($param['id']);
        $result = Db::name('employment')->where($where)->update($param);
        return $result;
    }
}