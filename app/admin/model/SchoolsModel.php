<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\admin\model;

use think\Model;
use think\Db;

class SchoolsModel extends Model {

    public function indexModel() {
        $data = Db::name('school')->where('ss_delete_time', 0)->order('id asc')->paginate(10);
        return $data;
    }
    
    public function addPostModel($data) {
        $result = Db::name('school')->insert($data);
        return $result;
    }
    
    public function deletePostModel($id) {
        $result = Db::name('school')->where($id)->setField('ss_delete_time',1);
        return $result;
    }
    
    public function editModel($id) {
        $result = Db::name('school')->where($id)->find();
        return $result;
    }
    
    public function editPostModel($data) {
        $id['id'] = $data['id'];
        unset($data['id']);
        $result = Db::name('school')->where($id)->update($data);
        return $result;
    }

}