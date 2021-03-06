<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018 年 9 月 25 日 0025
 * Time: 22:17:13
 */

class Controller_AjaxTable extends Controller_Base{

    public function init() {
        parent::init();
        $this->_display = true;
    }
    /**
     * 获取节点列表
     */
    public function nodes(){
        //页数
        $pageNum = getHttpVal('pageNum');
        $node_m = new Model_PurviewNode();
        $node_info = $node_m->selectAll();
        if ($node_info){
            //获取记录条数
            $totalItem = count($node_info);
            //分页数
            $pageSize = 10;
            //该记录共分几页
            $totalPage = ceil($totalItem/$pageSize);
            //开始页数
            $startItem = ($pageNum-1) * $pageSize;
            $arr['totalItem'] = $totalItem;
            $arr['pageSize'] = $pageSize;
            $arr['totalPage'] = $totalPage;
            //分页数据
            $dataInfo = $node_m->getInfoAll($startItem,$pageSize);
            $arr['data_content'] = $dataInfo;
            echo json_encode($arr);
        }else{
            $arr['code'] = '401';
            echo json_encode($arr);
        }
    }

    /**
     * 删除节点
     */
    public function delNode(){
        $id = getHttpVal('id');
        $node_m = new Model_PurviewNode();
        $node_m->deleteDbById($id);
        $arr['code'] = '201';
        echo json_encode($arr);
    }

    /**
     * 修改节点
     */
    public function editNode(){
        $id = getHttpVal('id');
        $node_m = new Model_PurviewNode();
        $node_info = $node_m->selectDbById($id);
        echo json_encode($node_info);
    }

    public function group(){
        $group_m = new Model_PurviewGroup();
        $group_info = $group_m->selectAll();
        if ($group_info){
            $data = [
                'code' => '201',
                'data_content' => $group_info
            ];
        }else{
            $data = [
                'code' => '401',
            ];
        }
        echo json_encode($data);
    }

    /*
     * 删除分组
     * */
    public function delGroup(){
        $id = getHttpVal('id');
        $group_m = new Model_PurviewGroup();
        $group_m->deleteDbById($id);
        $arr['code'] = '201';
        echo json_encode($arr);
    }

    /**
     * 修改分组
     */
    public function editGroup(){
        $id = getHttpVal('id');
        $group_m = new Model_PurviewGroup();
        $group_info = $group_m->selectDbById($id);
        echo json_encode($group_info);
    }

    /**
     * 管理员列表
     */
    public function accountList(){
        $account_m = new Model_Account();
        $account_info = $account_m->getAccount();
        $group_m = new Model_PurviewGroup();
        $group_info = $group_m->selectAll();
        if ($account_info){
            $data = [
                'code' => '201',
                'data_content' => $account_info
            ];
        }else{
            $data = [
                'code' => '401',
            ];
        }
        $data['group_info'] = $group_info;
        echo json_encode($data);
    }

    /**
     * 删除管理员
     */
    public function delAccount(){
        $id = getHttpVal('id');
        if ($id == 1){
            $data = [
                'code' => 401
            ];
        }else{
            $account_m = new Model_Account();
            $account_m->deleteDbById($id);
            $data = [
                'code' => 201
            ];
        }
        echo json_encode($data);
    }

    public function editAccount(){
        $id = getHttpVal('id');
        $account_m = new Model_Account();
        $account_info = $account_m->selectDbById($id);
        echo json_encode($account_info);
    }

    public function changeNodeAuth(){
        $id = getHttpVal('id');
        $group_id = getHttpVal('group_id');
        $show = getHttpVal('show');
        $groupNode_m = new Model_PurviewGroupNode();
        $groupNode_m->getAuthNodes($id,$group_id,$show);

    }
}
