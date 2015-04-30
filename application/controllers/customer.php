<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model');
    }

    public function index()
    {
    	$pageindex = $this->uri->segment(3);
        if($pageindex=='')
            $pageindex = 0;
        
        $data['title'] = "客户列表";
        $data['include'] = 'customer/list';
        $data['row'] =  $this->customer_model->getpagelist($pageindex);
        $this->load->library('pagination');
        $config['base_url'] = site_url('customer/index');
        $config['total_rows'] = $this->customer_model->getpagecount();
        $config['per_page'] = 10; 
        $this->pagination->initialize($config); 
        $this->load->view('masterpage',$data);
    }
   
    public function add()
    {
        $this->form_validation->set_rules('Company', '公司名称', 'required');
        $this->form_validation->set_rules('UserName', '姓名', 'required');
        $this->form_validation->set_rules('Email', '邮箱', 'required|valid_email');
        if ($this->form_validation->run() === FALSE)
        {
            $data['title'] = '添加客户信息';
            $data['include'] = 'customer/add';
            $this->load->view('masterpage',$data);
        }
        else
        {
            $this->customer_model->insert();
            redirect('/customer/index', 'refresh');
        }
    }

    public function edit()
    {     
        
        $this->form_validation->set_rules('Company', '公司名称', 'required');
        $this->form_validation->set_rules('UserName', '姓名', 'required');
        $this->form_validation->set_rules('Email', '邮箱', 'required|valid_email');
        if ($this->form_validation->run() === FALSE)
        {
            $id = $this->uri->segment(3);
            $data['item']=$this->customer_model->get($id);
            $data['title'] = '修改客户信息';
            $data['include'] = 'customer/edit';
            $this->load->view('masterpage',$data);
        }
        else
        {
            $this->customer_model->update();
            redirect('/customer/index', 'refresh');
        }
    }

    public function view()
    {
        $this->load->library('table');
        $id = $this->uri->segment(3);
        $data['item']=$this->customer_model->get($id);
        $data['title'] = '查看客户';
        $data['include'] = 'customer/view';
        $data['row'] = $this->transaction_model->getcustomertranshistory($id);
        $this->load->view('masterpage',$data);
    }
    /**
    * 删除没有订购服务的商家
    **/
    public function del($id)
    {
        if($this->customer_model->candel($id)>0){
            $this->load->helper('html');
            $data['include'] = 'failure';
            $data['error'] = '该客户已购买了服务，不能删除';
            $this->load->view('masterpage',$data);
        }else
        {
            $this->customer_model->del($id);
            redirect('/customer/index', 'refresh');
        }
    }
}
