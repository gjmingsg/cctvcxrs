<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 */
     public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
       
    }
	public function index()
	{
		redirect('/user/listagent', 'refresh');
    }
    
    public function listagent()
    {

        $this->pagelist(1,"代理商列表","listagent");
    }
    public function listthird()
    {
        $this->pagelist(2,"第三方商家列表","listthird");
    }
    public function addagent()
    {
        $this->add(1,'添加代理商','addagent');
    }

    public function addthird()
    {
        $this->add(2,'添加第三方商家','addthird');
    }

    public function del($id)
    {
        $msg = $this->user_model->candel($id);
        if($msg==null){
            $this->user_model->del($id);
            redirect('/user/index', 'refresh');
        }else{
            $this->load->helper('html');
            $data['include'] = 'failure';
            $data['error'] = $msg;
            $this->load->view('masterpage',$data);
        }
    }
    /**
    *  设置代理商与第三方商家关系
    **/
    public function setagent()
    {
        $id = $this->uri->segment(3);
        $data['row']=$this->user_model->getunselectuser($id);
        $data['selected']=$this->user_model->getselecteduser($id);
        $data['include'] = 'user/setagent';
        $data['UserID'] = $id;
        $data['title'] = '设置商家';
        $this->load->view('masterpage',$data);
        
    }
    public function savesetagent()
    {
        $id = $this->uri->segment(3);
        $selected = $this->input->post('selected');
        if($this->user_model->saverelationship(preg_split("/[.,;!\s']\s*/",$selected),$id)){
            redirect('user/setagent/'.$id,'refresh');
        }else{
            $this->load->helper('html');
            $data['include'] = 'failure';
            $data['error'] = '设置代理商与第三方商家关系失败，请联系管理员';
            $this->load->view('masterpage',$data);
        }
    }
    public function recharge($UserID)
    {
        $this->form_validation->set_rules('Money', '金额', 'required|numeric|max_length[12]');
        $data['title'] = '充值';
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->library('table');
            $data['include'] = 'user/recharge';
            $data['UserID'] = $UserID;
            $data['row'] = $this->transaction_model->getownrecharge($UserID);
            $this->load->view('masterpage',$data);
        }
        else
        {
            $this->transaction_model->recharge();
            redirect('/user/index', 'refresh');
        }
    }
    public function rechargehistory()
    {
        $data['title'] = '充值记录';
        $this->load->library('table');
        $data['include'] = 'user/rechargehistory';
        $data['row'] = $this->transaction_model->getownrecharge($this->session->userdata('userid'));
        $this->load->view('masterpage',$data);
    }
    public function view()
    {
        $id = $this->uri->segment(3);
        $data['item']=$this->user_model->get($id);
        $data['title'] = '查看用户信息';
        $data['include'] = 'user/view';
        $this->load->library('table');
        $data['row'] = $this->transaction_model->getownrecharge($id);
        $this->load->view('masterpage',$data);
    }
    public function edit()
    {
        $this->form_validation->set_rules('LoginId', '账号', 'required|max_length[15]');
        $this->form_validation->set_rules('UserName', '姓名', 'required|max_length[15]');
        $this->form_validation->set_rules('Discount', '折扣', 'numeric|max_length[3]');
        $this->form_validation->set_rules('Email', '邮箱', 'valid_email');
        if ($this->form_validation->run() === FALSE)
        {

            $id = $this->uri->segment(3);
            $data['item']=$this->user_model->get($id);
            $data['title'] = '编辑用户信息';
            $data['include'] = 'user/edit';
            $this->load->view('masterpage',$data);
        }
        else
        {
            $this->user_model->update();
            redirect('/user/index', 'refresh');
        }
    }
   
    public function changepwd()
    {
        $data['title']="重置密码";

        $this->form_validation->set_rules('Password', '密码', 'required');
        $this->form_validation->set_rules('rePassword', '重输密码', 'required|matches[Password]');
        if ($this->form_validation->run() === FALSE)
        {
            $data['UserID']=$this->uri->segment(3);
            $data['include'] = 'user/changepwd';
            $this->load->view('masterpage',$data);
        }
        else
        {
            if($this->input->post('Password')==$this->input->post('rePassword'))
            {
                $this->user_model->changepwd();
                redirect('/user/index', 'refresh');
            }else
            {
                $data['include'] = 'user/changepwd';
                $this->load->view('masterpage',$data);
            }
        }
    }

    
    private function pagelist($type,$title,$fun)
    {
        $this->load->library('pagination');
        $pageindex = $this->uri->segment(3);
        if($pageindex=='')
            $pageindex = 0;
        $data['include'] = 'user/list';
        $data['title']=$title;
        $data["row"] = $this->user_model->getpagelist($pageindex,$type);
        $config['base_url'] = site_url('user/'.$fun);
        $config['total_rows'] = $this->user_model->getpagecount($type);
        $config['per_page'] = 10; 
        if($type==1){
            $data['type'] = "addagent";
        }
        else {
            $data['type'] = "addthird";
        }
        $this->pagination->initialize($config); 
        $this->load->view('masterpage',$data);
    }

    private function add($type,$title,$fun)
    {
        $data['title'] = $title;
        $this->form_validation->set_rules('LoginId', '账号', 'required|is_unique[cxusers.LoginId]|max_length[15]');
        $this->form_validation->set_rules('UserName', '姓名', 'required|max_length[15]');
        $this->form_validation->set_rules('Password', '密码', 'required|max_length[15]|min_length[2]');
        $this->form_validation->set_rules('IDCard', '身份证号', 'is_unique[cxusers.IDCard]');
        $this->form_validation->set_rules('Email', '邮箱', 'valid_email|is_unique[cxusers.Email]');
        $this->form_validation->set_rules('Discount', '折扣', 'numeric|max_length[3]');
        if($type==1){
            $data['type'] = "addagent";
        }
        else {
            $data['type'] = "addthird";
        }
        if ($this->form_validation->run() === FALSE)
        {
           $data['include'] = 'user/add';
           $this->load->view('masterpage',$data);
        }
        else
        {
            $this->user_model->insert($type);
            redirect('/user/index', 'refresh');
        }
    }
}


