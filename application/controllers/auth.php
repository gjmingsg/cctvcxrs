<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();               
        // 载入并初始化数据库类
        $this->load->model('user_model');
        $this->load->helper('security');
    }
	public function index()
    {

		$this->load->view('/auth/login');
    }

    public function logout($id)
    {
        //$newdata = array('userid' => $id);
        $this->session->sess_destroy();
    	$this->load->view('/auth/login');
    }
    
    public function code()
    {
        $this->load->view('/auth/code');
    }
    public function unauth()
    {
        $this->load->helper('html');
        $data['title'] = '非法访问未授权页面';
        $data['include'] = 'failure';
        $data['error'] = '非法访问未授权页面，你不具有权限访问该页面';
        $this->load->view('masterpage',$data);
    }
    public function login()
    {
        $this->form_validation->set_rules('login_name', '账号', 'required');
        $this->form_validation->set_rules('password', '密码', 'required');
        $this->form_validation->set_rules('randcode', '验证码', 'required');
        

        if ($this->form_validation->run() === FALSE ||  $this->session->userdata('randcode') != $this->input->post('randcode'))
        {
            $this->load->view('/auth/login');
        }
        else
        {
            $item = $this->user_model->validateuser();
            if($item!=null){
                $this->session->unset_userdata('randcode') ;
                //$this->session->sess_destroy();
                $newdata = array(
                   'userid'   => $item->UserID,
                   'usertype' => $item->UserType,
                   'username' => $item->UserName);
                $this->session->set_userdata($newdata);
                redirect('/default_page/index', 'refresh');
            }else{
                $this->load->view('/auth/login');
            }
            
        }
    	
    }

}



