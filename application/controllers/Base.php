<?php
/**
 * Created by PhpStorm.
 * User: yunlong
 * Date: 14-7-25
 * Time: 下午6:01
 */

class Base extends CI_Controller {

    private static $instance;

    protected $table_tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" class="mytable">' );

    public function __construct()
    {
        parent::__construct();

//        $users = array(
//            'name'  => "张三",
//            'username'  => 'aa',
//            'userid'  => 3,
//            'role'  => 0,
//            'contestAuth'  => 1,
//            'logged_in' => TRUE
//        );
//        $this->session->set_userdata($users);



        if (!$this->session->userdata('logged_in')){
            redirect(base_url('/login/index'));
            exit();
        }

        $this->load->model('appinfo_model');
    }

}