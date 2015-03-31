<?php
/**
 * Created by PhpStorm.
 * User: yunlong
 * Date: 14-9-12
 * Time: 下午2:00
 */

class Account_model extends CI_Model {

    public static $tableName="account";
    const DEFAULT_PW = 123;

    const ROLE_NORMAL = 2;
    const ROLE_ADMIN = 5;
//    const ROLE_SUPER_ADMIN = 8;

    public static $ROLE = array(
        2 => '审核员',
        5 => '管理员',
//        8 => '超级管理员',
    );

    public function __construct()
    {
        $this->load->database();
    }

    public function get_account($username = false)
    {
        if($username === false)
        {
            $query = $this->db->get('account');
            return $query->result_array();
        }

        $query = $this->db->get_where('account',array('username'=>$username));
        return $query->row_array();
    }

    public function update_account($data=array()){
        $data = $this->_filterInput($data);

        $this->db->where('username',$data['username']);
        return $this->db->update(self::$tableName,$data);
    }

    public function add_account($data=array()){
        $data = $data + array('password' => self::DEFAULT_PW);
        $data = $this->_filterInput($data);

        $this->db->where('username',$data['username']);
        return $this->db->insert(self::$tableName,$data);
    }

    public function set_account($isnew)
    {
        if(empty($isnew)) {
            return $this->update_account();
        }

        return $this->add_account();
    }


    public function del_account($username) {
        $this->db->where('username',$username);
        return $this->db->delete(self::$tableName);
    }

    public function signin($username,$password)
    {
        $query = $this->db->get_where(self::$tableName,array('username' => $username,'password' => md5($password.$this->config->item('encryption_key'))));

        return $query->row_array();
    }

    private function _filterInput($data){
        $data = $data + elements(array('username','password','role'),$this->input->post());
        $data = array_filter($data,function($v){
            return $v !== '' && $v !== false;
        });

        if(!empty($data['password'])) {
            $data['password'] = md5($data['password'].$this->config->item('encryption_key'));
        }

        return $data;
    }

//    private function _checkAuth($role,&$result){
//        $result = array('error'=>0);
//        $selfRole = $this->session->userdata('role');
//        if($selfRole <= $role) {
//            $result['error'] = 1;
//            $result['msg'] = '没有权限！';
//            return false;
//        }
//        return true;
//    }

}