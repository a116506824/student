<?php

namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\Db;
use app\admin\model\SchoolModel;
use app\admin\model\DepartmentsModel;

//院系页面

class DepartmentController extends AdminBaseController {

    public function index() {
        $model = new DepartmentsModel;
        $data = $model->indexModel();
//        var_dump($data);exit;
        $this->assign("roles", $data);
        $this->assign('page', $data->render());
        return $this->fetch();
    }

    public function add() {
        $categoryId = $this->request->param('category', 0, 'intval');
        $model = new SchoolModel();
        $modelTree = $model->adminCategoryTree($categoryId);
        $this->assign('category_tree', $modelTree);
        return $this->fetch();
    }

    public function addPost() {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $model = new DepartmentsModel;
            $result = $model->addPostModel($data);
            if ($result) {
                $this->success("添加成功", url("Department/index"));
            } else {
                $this->error("添加失败");
            }
        } else {
            $this->error("非post请求");
        }
    }

    public function edit() {
        $id['de.id'] = $this->request->param("id", 0, 'intval');
        $categoryId = $this->request->param('category', 0, 'intval');
        $models = new DepartmentsModel;
        $model = new SchoolModel();
        $result = $models->editModel($id);
        if (!empty($result)) {
            $modelTree = $model->adminCategoryTree($categoryId);
            $this->assign('category_tree', $modelTree);
            $this->assign('data', $result);
            return $this->fetch();
        } else {
            $this->error('查找数据失败');
        }
    }
    
    public function editPost() {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $model = new DepartmentsModel;
            $result = $model->editPostModel($data);
            if ($result) {
                $this->success("修改成功", url("Department/index"));
            } else {
                $this->error("修改失败");
            }
        } else {
            $this->error("非post请求");
        }
    }
    
    public function deletePost() {
        $id['id'] = $this->request->param("id", 0, 'intval');
        $model = new DepartmentsModel;
        $result = $model->deleteModel($id);
        if ($result) {
                $this->success("删除成功", url("Department/index"));
            } else {
                $this->error("删除失败");
            }
    }

}
