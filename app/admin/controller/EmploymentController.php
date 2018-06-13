<?php

namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\Db;
use app\admin\model\EmploymentsModel;

//用工单位资料页面

class EmploymentController extends AdminBaseController {

    public function index() {
        $where['se_status'] = 0;
        $where['se_delete_time'] = 0;
        $model = new EmploymentsModel;
        $data = $model->indexModel($where);
        $this->assign("roles", $data);
        $this->assign('page', $data->render());
        return $this->fetch();
    }

    public function black() {
        $where['se_status'] = 1;
        $model = new EmploymentsModel;
        $data = $model->indexModel($where);
        $this->assign("roles", $data);
        $this->assign('page', $data->render());
        return $this->fetch();
    }

    public function ban() {
        $id['id'] = $this->request->param("id", 0, 'intval');
        if ($id) {
            $field['se_status'] = 1;
            $model = new EmploymentsModel;
            $result = $model->del($id, $field);
            if ($result) {
                $this->success("拉黑成功！", "employment/index");
            } else {
                $this->error('拉黑失败,学生不存在！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }

    public function whi() {
        $id['id'] = $this->request->param("id", 0, 'intval');
        if ($id) {
            $field['se_status'] = 0;
            $model = new EmploymentsModel;
            $result = $model->del($id, $field);
            if ($result) {
                $this->success("拉白成功！", "employment/index");
            } else {
                $this->error('拉白失败,学生不存在！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }

    public function del() {
        $id['id'] = $this->request->param("id", 0, 'intval');
        $field['se_delete_time'] = 1;
        $model = new EmploymentsModel;
        $result = $model->deleteModel($id, $field);
        if ($result) {
            $this->success("删除成功！", "employment/index");
        } else {
            $this->error('删除失败,学生不存在！');
        }
    }
    
    public function add() {
        return $this->fetch();
    }
    
    public function addPost() {
        $param = $this->request->param();
//        var_dump($param);exit;
        $model = new EmploymentsModel;
        $result = $model->addPostModel($param);
        if ($result) {
            $this->success("添加成功！", "employment/index");
        } else {
            $this->error('添加失败,请重新添加！');
        }
    }
    
    public function edit(){
        $id['id'] = $this->request->param("id", 0, 'intval');
        $model = new EmploymentsModel;
        $data = $model->editModel($id);
        if ($data) {
            $this->assign('data', $data);
            return $this->fetch();
        } else {
            $this->error('查找数据失败');
        }
    }
    
    public function editPost() {
        $param = $this->request->param();
        $model = new EmploymentsModel;
        $result = $model->editPostModel($param);
        if ($result) {
            $this->success("修改成功！", "employment/index");
        } else {
            $this->error('修改失败');
        }
    }

}
