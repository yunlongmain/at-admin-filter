<?php
/**
 * Created by PhpStorm.
 * User: yunlong
 * Date: 14-9-10
 * Time: 下午2:59
 */


class Appinfo_model extends CI_Model{
    public static $tableName='appinfo';

    //0：待审核；1：未通过 2： 已通过
    const STATUS_WAIT = 0;
    const STATUS_UNPASS = 1;
    const STATUS_PASSED = 2;

    public static $STATUS = array(
        -1 => "",
        0 => "待审核",
        1 => "未通过",
        2 => "已通过",
    );

    public function __construct()
    {
        $this->load->database();
    }

    private function _insertDefaultData($data){
        if(!isset($data['handler_name'])) {
            $data['handler_name'] = $this->session->userdata('username');
        }

        $data['utime'] = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        return $data;
    }

    public function update_appinfo($data) {
        $data = $this->_insertDefaultData($data);

        $this->db->where("appid",$data['appid']);
        $this->db->update(self::$tableName,$data);

        return $this->db->affected_rows();

    }

    public function update_appinfo_batch($inputData) {
        if(empty($inputData)) {
            return 0;
        }

        $data = [];
        foreach($inputData as $k => $v){
            $data[] = $this->_insertDefaultData($v);
        }

        $this->db->update_batch(self::$tableName,$data,'appid');

        return $this->db->affected_rows();
    }


    public function insert_appinfo_batch($inputData) {
        if(empty($inputData)) {
            return 0;
        }

        $data = [];
        foreach($inputData as $k => $v){
            $data[] = $this->_insertDefaultData($v);
        }

        $this->db->insert_batch(self::$tableName,$data);

        return $this->db->affected_rows();
    }

    public function set_appinfo_batch($inputData) {
        $result = array(
//            'insert_error' => 1,
//            'update_error' => 1,
        );

        $this->db->select('appid')->from(self::$tableName);
        $query = $this->db->get();
        $allAppidArr = $query->result_array();
        $allAppidArr = array_add_key($allAppidArr,'appid');

        $insertData = [];
        $updateData = [];

        foreach($inputData as $v) {
            $v = $this->_insertDefaultData($v);
            if(isset($allAppidArr[$v['appid']])) {
                $updateData[] = $v;
            } else {
                $insertData[] = $v;
            }
        }

        $insertSuccNum = $this->insert_appinfo_batch($insertData);
        $result['insert_msg'] = '添加'.count($insertData)."条数据";//,成功添加".$insertSuccNum."条数据

        $updateScuuNum = $this->update_appinfo_batch($updateData);
        $result['update_msg'] = '更新'.count($updateData)."条数据";//,成功更新".$updateScuuNum."条数据";

        return $result;
    }

}