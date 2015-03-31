<?php
/**
 * Created by PhpStorm.
 * User: yunlong
 * Date: 14-4-8
 * Time: 下午8:18
 */

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['submitUrl'] = base_url('/login/signin');
        $data['error_tip'] = $this->session->userdata('error_tip');
        $this->session->set_userdata('error_tip','');

        $this->load->view('templates/header', $data);
        $this->parser->parse('user/login', $data);
        $this->load->view('templates/footer');

    }

    public function signin()
    {
        if($this->input->post('act')=='signin'){
            $this->load->library('form_validation');

            $this->form_validation->set_rules('password', '密码', 'required');
            $this->form_validation->set_rules('re_password', '密码确认', 'required|matches[password]');


            //接受客户端数据
            $name = $this->input->post('name',true);
            $password = $this->input->post('password',true);

            $this->load->model('account_model');

            if ($user = $this->account_model->signin($name,$password)){

                // session记录登陆者信息
                $users = array(
                    'username'  => $user['username'],
                    'id'  => $user['id'],
                    'role'  => $user['role'],
                    'rolename'  => Account_model::$ROLE[$user['role']],
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($users);

                redirect(base_url('/'));

            }else{
                $this->session->set_userdata('error_tip', '用户名或者密码错误！');
            }

        } else {
            $this->session->set_userdata('error_tip', '非法登录！');
        }

        redirect(base_url('/login/index'));

    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('login/index'));
    }

}