<?php

namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\Db;
use app\admin\model\SchoolsModel;

//学校页面

class SchoolController extends AdminBaseController {

    /**
     * 列表页
     * @return type
     */
    public function index() {
        $model = new SchoolsModel;
        $data = $model->indexModel();
        $this->assign("roles", $data);
        $this->assign('page', $data->render());
        return $this->fetch();
    }

    /**
     * 添加页面
     * @return type
     */
    public function add() {
        return $this->fetch();
    }

    /**
     * 添加方法
     */
    public function addPost() {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $model = new SchoolsModel;
            $result = $model->addPostModel($data);
            if ($result) {
                $this->success('添加学校成功', url("School/index"));
            } else {
                $this->error('添加学校失败');
            }
        } else {
            $this->error('非POST请求');
        }
    }

    public function deletePost() {
        $id['id'] = $this->request->param("id", 0, 'intval');
        $model = new SchoolsModel;
        $result = $model->deletePostModel($id);
        if ($result) {
            $this->success('删除学校成功', url("School/index"));
        } else {
            $this->error('删除学校失败');
        }
    }

    public function edit() {
        $id['id'] = $this->request->param("id", 0, 'intval');
        $model = new SchoolsModel;
        $result = $model->editModel($id);
        if (!empty($result)) {
            $this->assign('data', $result);
            return $this->fetch();
        } else {
            $this->error('查找数据失败');
        }
    }
    
    public function editPost() {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $model = new SchoolsModel;
            $result = $model->editPostModel($data);
            if ($result) {
                $this->success('修改学校成功', url("School/index"));
            } else {
                $this->error('修改学校失败');
            }
        } else {
            $this->error('非POST请求');
        }
    }

}
