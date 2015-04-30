<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Default_page extends CI_Controller {
    function __construct()
    {
        parent::__construct();

    } 
    //登录后默认页面
    public function index()
    {   
        $data['title'] = "欢迎登录系统!";       
        $data['include'] = 'default_page';
        $this->load->view('masterpage',$data);
    }
}

