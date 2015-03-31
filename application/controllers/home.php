<?php
/**
 * Created by PhpStorm.
 * User: yuanyetao
 * Date: 14-9-10
 * Time: 下午2:00
 */

   class Home extends CI_Controller{
       public function __construct()
       {
           parent::__construct();
       }

       public function index()
       {
           $this->load->helper('url');

           $data['title'] = 'welcome';

           $this->load->view('templates/header', $data);
           $this->load->view('at/home', $data);
           $this->load->view('templates/footer');
       }

       public function noAuth() {
           $this->load->view('templates/header');
           $this->load->view('at/no_auth');
           $this->load->view('templates/footer');
       }

   }