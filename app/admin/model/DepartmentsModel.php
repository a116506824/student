<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\admin\model;

use think\Model;
use think\Db;

class DepartmentsModel extends Model {

    public function indexModel() {
        $data = Db::name('department de')
                ->join('school sc','de.parents_id = sc.id','left')
                ->field('de.id,de.name,sc.name as schoolname')
                ->where('sd_delete_time', 0)->order('de.id asc')->paginate(10);
        return $data;
    }
    
    public function addPostModel($data) {
        $data['parents_id'] = $data['category'];
        unset($data['category']);
        $result = Db::name('department')->insert($data);
        return $result;
    }
    
    public function editModel($id) {
        $data = Db::name('department de')->join('school sc','de.parents_id = sc.id')->field('de.id,de.name,sc.id as schoolid,sc.name as schoolname')->where($id)->find();
//        var_dump($data);exit;
        return $data;
    }
    
    public function editPostModel($data) {
        $data['parents_id'] = $data['category'];
        $id['id'] = $data['id'];
        unset($data['category']);
        unset($data['id']);
        $result = Db::name('department')->where($id)->update($data);
        return $result;
    }
    
    public function deleteModel($id) {
        $result = Db::name('department')->where($id)->setField('sd_delete_time',1);
        return $result;
    }
}