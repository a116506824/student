<?php

// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\admin\model\RouteModel;
use think\Model;
use tree\Tree;

class DepartmentModel extends Model {

    protected $type = [
        'more' => 'array',
    ];

    /**
     * 生成分类 select树形结构
     * @param int $selectId 需要选中的分类 id
     * @param int $currentCid 需要隐藏的分类 id
     * @return string
     */
    public function adminCategoryTree($p = 0,$selectId = 0, $currentCid = 0) {
        $where['sd_delete_time'] = 0;
        if (!empty($currentCid)) {
            $where['id'] = ['neq', $currentCid];
        }
        $where['parents_id'] = $p;
//        var_dump($where);exit;
        $categories = $this->where($where)->select()->toArray();
//        var_dump($categories);exit;
        $tree = new Tree();
        $tree->icon = ['&nbsp;&nbsp;│', '&nbsp;&nbsp;├─', '&nbsp;&nbsp;└─'];
        $tree->nbsp = '&nbsp;&nbsp;';

        $newCategories = [];
        foreach ($categories as $item) {
            $item['selected'] = $selectId == $item['id'] ? "selected" : "";

            array_push($newCategories, $item);
        }
//        var_dump($newCategories);exit;
        $tree->init($newCategories);
//        var_dump($tree);exit;
        $str = '<option value=\"{$id}\" {$selected}>{$spacer}{$name}</option>';
//        var_dump($str);exit;
        $treeStr = $tree->getTree(0, $str);
        //var_dump($treeStr);exit;//这个是OK的
        return $treeStr;
    }

}
