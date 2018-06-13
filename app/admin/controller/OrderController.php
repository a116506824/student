<?php

namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\Db;
use app\admin\model\OrderModel;
use app\admin\model\EmploymentModel;

//用工单位资料页面

class OrderController extends AdminBaseController {

    public function index() {
        $where['or.so_status'] = 0;
        $model = new OrderModel;
        $data = $model->indexModel(0);
        $this->assign("roles", $data);
        $this->assign('page', $data->render());
        return $this->fetch();
    }
    
    public function add() {
        $categoryId = $this->request->param('category', 0, 'intval');
        $sc = new EmploymentModel;
        $scmodelTree = $sc->adminCategoryTree($categoryId);
        $this->assign('category_tree', $scmodelTree);
        return $this->fetch();
    }
    
    public function addPost() {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $model = new OrderModel;
            $result = $model->addPostModel($data);
            if ($result) {
                $this->success('添加订单成功', url("Order/index"));
            } else {
                $this->error('添加学校失败');
            }
        } else {
            $this->error('非POST请求');
        }
    }
}
