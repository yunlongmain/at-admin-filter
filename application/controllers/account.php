<?php
/**
 * Created by PhpStorm.
 * User: yuanyetao
 * Date: 14-9-10
 * Time: 下午2:00
 */

class Account extends Base{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('account_model');
    }

   public function selfInfo(){

       $data = $this->session->all_userdata();
       $data['tip'] = $this->session->flashdata('update_self_pw');

       $this->load->view('templates/header', $data);
       $this->parser->parse('user/selfInfo', $data);
       $this->load->view('templates/footer');
   }

    public function updateSelfPw(){
        $this->load->library('form_validation');

        $data['actionUrl'] = base_url('account/updateSelfPw');
        $data['error_tip'] = $this->session->flashdata('update_self_pw');

        $this->form_validation->set_rules('password', '密码', 'required');
        $this->form_validation->set_rules('re_password', '密码确认', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->parser->parse('user/update_self_pw', $data);
            $this->load->view('templates/footer');
        } else{
            $result = $this->account_model->update_account(array('username' => $this->session->userdata('username')));
            if($result) {
                $this->session->set_flashdata('update_self_pw', '密码更新成功!');
                redirect(base_url('/account/selfInfo'));
            }else {
                $this->session->set_flashdata('update_self_pw', '服务器繁忙,'.$result);
                redirect(base_url('/account/updateSelfPw'));
            }
        }
    }

    public function manage(){
        $this->_filterLowAuth(Account_model::ROLE_NORMAL);

        $query = $this->db->get_where(Account_model::$tableName);
        $dataList = $query->result_array();
        foreach($dataList as &$v) {
            $editUrl = base_url('/account/edit/'.$v['username']);
            $delUrl = base_url('/account/del/'.$v['username']);
            $resetPWUrl = base_url('/account/resetPW/'.$v['username']);
            $v['handle'] = string_to_html_a($editUrl,'编辑').
                ' '.string_to_html_a($delUrl,'删除','onclick="return confirm(\'确认要删除该项吗？\')"').
                ' '.string_to_html_a($resetPWUrl,'重置密码','onclick="return confirm(\'确认要重置该用户密码吗？重置后的密码为123\')"');
        }

        $data['user_list'] = $dataList;
        $data['tip'] = $this->session->flashdata('update_other_info');

        $this->load->view('templates/header', $data);
        $this->parser->parse('user/list', $data);
        $this->load->view('templates/footer');
    }


   public function setting(){

   }

   public function edit($name=-1){
       $this->_filterLowAuth(Account_model::ROLE_NORMAL);

       $this->load->library('form_validation');

       $data['error_tip'] = $this->session->flashdata('update_other_info');
       $data['isnew'] = 0;
       $accountInfo = array();
       if($name != -1) {
           $accountInfo = $this->account_model->get_account($name);
           $data['title'] = '修改用户';
           $data['submitUrl'] = base_url("/account/edit/".$name);
       }else {
           $data['title'] = '创建用户(密码默认为：123)';
           $data['isnew'] = 1;
           $data['submitUrl'] = base_url('/account/edit');
       }

       $data['username'] = empty($accountInfo) ? "": htmlspecialchars($accountInfo['username']);
       $data['role'] = empty($accountInfo)? 2 :htmlspecialchars($accountInfo['role']);

       $this->form_validation->set_rules('username', '名称', 'required');
       $this->form_validation->set_rules('role', '角色', 'required|integer|less_than[10]|greater_than[-1]');

       if ($this->form_validation->run() === FALSE)
       {
           $this->parser->parse('templates/header', $data);
           $this->parser->parse('user/new',$data);
           $this->load->view('templates/footer');

       }
       else
       {
           $isnew = $this->input->post('isnew');
           $result = $this->account_model->set_account($isnew);

           if($result) {
               $this->session->set_flashdata('update_other_info', $isnew?'创建操作成功!':'修改成功！');
               redirect(base_url('/account/manage'));
           }else {
               $this->session->set_flashdata('update_other_info', '服务器繁忙,'.$result);
               redirect(base_url('/account/edit'));
           }
       }
   }

   public function del($name){
       $this->_filterLowAuth(Account_model::ROLE_NORMAL);

       $result = $this->account_model->del_account($name);
       if($result) {
           $this->session->set_flashdata('update_other_info','删除用户成功！');
       }else {
           $this->session->set_flashdata('update_other_info', '服务器繁忙,'.$result);
       }

       redirect(base_url('/account/manage'));
   }

    public function resetPW($name){
        $this->_filterLowAuth(Account_model::ROLE_NORMAL);

        $userData = array(
            'password' => Account_model::DEFAULT_PW,
            'username' => $name
        );

        $result = $this->account_model->update_account($userData);
        if($result) {
            $this->session->set_flashdata('update_other_info','重置密码成功，新密码是123，请尽快通知用户修改密码！');
        }else {
            $this->session->set_flashdata('update_other_info', '服务器繁忙,'.$result);
        }

        redirect(base_url('/account/manage'));

    }

    private function _filterLowAuth($threshold){
        if($threshold >= $this->session->userdata('role')) {
            redirect(base_url('/home/noAuth'));
        }

    }

}