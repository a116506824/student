<?php

namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\Db;
use app\admin\model\StudentModel;
use app\admin\model\SchoolModel;
use app\admin\model\DepartmentModel;
use think\session;

//学生资料页面

class StudentController extends AdminBaseController {

    public function index() {
        $where['ss_status'] = 0;
        $Print = new StudentModel;
        $data = $Print->indexModel($where);
        $this->assign("roles", $data);
        $this->assign('page', $data->render());
        return $this->fetch();
    }

    public function ban() {
        $id['id'] = $this->request->param("id", 0, 'intval');
        if ($id) {
            $field['ss_status'] = 1;
            $model = new StudentModel;
            $result = $model->del($id, $field);
            if ($result) {
                $this->success("拉黑成功！", "student/index");
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
            $field['ss_status'] = 0;
            $model = new StudentModel;
            $result = $model->del($id, $field);
            if ($result) {
                $this->success("拉白成功！", "student/black");
            } else {
                $this->error('拉白失败,学生不存在！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }

    public function del() {
        $id['id'] = $this->request->param("id", 0, 'intval');
        if ($id) {
            $result = Db::name("student")->where($id)->setField('ss_status', 2);
            if ($result) {
                $this->success("删除成功！", "student/index");
            } else {
                $this->error('删除失败,学生不存在！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }

    public function black() {
        $where['ss_status'] = 1;
        $Print = new StudentModel;
        $data = $Print->indexModel($where);
        $this->assign("roles", $data);
        $this->assign('page', $data->render());
        return $this->fetch();
    }

    public function add() {
        $categoryId = $this->request->param('category', 0, 'intval');
        $sc = new SchoolModel;
        $scmodelTree = $sc->adminCategoryTree($categoryId);
        $this->assign('sc_category_tree', $scmodelTree);
        return $this->fetch();
    }

    public function add1() {
        if ($_POST) {
            Session::set('scid', $_POST['category']);
            $id = Session::get('scid');
//            var_dump($id);exit;
            $categoryId = $this->request->param('category', 0, 'intval');
            $de = new DepartmentModel;
            $demodelTree = $de->adminCategoryTree($id);
            $this->assign('de_category_tree', $demodelTree);
            return $this->fetch();
        }
    }

    public function addPost() {
        if ($_POST) {
            $data = $this->request->param();
//            var_dump($data);exit;
            $data['ssc_id'] = Session::get('scid');
            $data['sm_id'] = $data['category'];
            unset($data['category']);
            $model = new StudentModel;
            $result = $model->addPostModel($data);
            if ($result) {
                $this->success("新增成功！", "student/index");
            } else {
                $this->error('新增失败！');
            }
            //array(8) { ["ss_name"]=> string(1) "1" ["category"]=> string(1) "2" ["ss_phone"]=> string(8) "13333333" ["ss_height"]=> string(3) "180" ["ss_alipay"]=> string(4) "1112" ["ss_wechat"]=> string(3) "222" ["ss_assessment"]=> string(3) "333" ["ss_remark"]=> string(3) "444" }
        } else {
            $this->error('非POST请求！');
        }
    }

    public function add2() {
        if ($_POST) {
            Session::set('scid', $_POST['category']);
            $id = Session::get('scid');
        }
        $categoryId = $this->request->param('category', 0, 'intval');
        $de = new DepartmentModel;
        $demodelTree = $de->adminCategoryTree(2);
//        var_dump($demodelTree);exit;
        $this->assign('de_category_tree', $demodelTree);
        return $this->fetch();
    }

    public function edit() {
        $id['st.id'] = $this->request->param("id", 0, 'intval');
        $model = new StudentModel;
        $data = $model->editModel($id);
        if ($data) {
            $sc = new SchoolModel;
            $scmodelTree = $sc->adminCategoryTree($data['scid']);
            $this->assign('sc_category_tree', $scmodelTree);
            $de = new DepartmentModel;
            $demodelTree = $de->adminCategoryTree($data['scid'],$data['deid']);
//            var_dump($demodelTree);exit;
            $this->assign('de_category_tree', $demodelTree);
            $this->assign('data', $data);
            return $this->fetch();
        } else {
            $this->error('查找数据失败');
        }
    }
    
    public function editPost() {
        $param = $this->request->param();
        $param['ssc_id'] = $param['sc_category_tree'];
        $param['sm_id'] = $param['de_category_tree'];
        unset($param['sc_category_tree']);
        unset($param['de_category_tree']);
//        var_dump($param);exit;
        $model = new StudentModel;
        $result = $model->editPostModel($param);
        if($result){
            $this->success("修改成功！", "student/index");
        } else {
            $this->error('修改失败！');
        }
    }

}
