<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
    }
   
	public function index()
    {     
        $pageindex = $this->uri->segment(3);
        if($pageindex=='')
            $pageindex = 0;
        
        $data['title'] ='产品列表' ;
        $data['include'] = 'product/list';
        $data['row'] =  $this->product_model->getpagelist($pageindex);
        $this->load->library('pagination');

        $config['base_url'] = site_url('product/index');
        $config['total_rows'] = $this->product_model->getpagecount();
        $config['per_page'] = 10; 
        $this->pagination->initialize($config); 
        $this->load->view('masterpage',$data);
    }
    public function materiallist(){
        $pageindex = $this->uri->segment(3);
        if($pageindex=='')
            $pageindex = 0;
        
        $data['title'] ='产品列表' ;
        $data['include'] = 'product/list';
        $data['row'] =  $this->product_model->getpagelist($pageindex);
        $this->load->library('pagination');

        $config['base_url'] = site_url('product/index');
        $config['total_rows'] = $this->product_model->getpagecount();
        $config['per_page'] = 10; 
        $this->pagination->initialize($config); 
        $this->load->view('masterpage',$data);
    }
    public function servicelist(){
        $pageindex = $this->uri->segment(3);
        if($pageindex=='')
            $pageindex = 0;
        
        $data['title'] ='产品列表' ;
        $data['include'] = 'product/list';
        $data['row'] =  $this->product_model->getpagelist($pageindex);
        $this->load->library('pagination');

        $config['base_url'] = site_url('product/index');
        $config['total_rows'] = $this->product_model->getpagecount();
        $config['per_page'] = 10; 
        $this->pagination->initialize($config); 
        $this->load->view('masterpage',$data);
    }
    public function del()
    {
        $id = $this->uri->segment(3);
        if($this->product_model->candel($id)){
            $this->load->helper('html');
            $data['include'] = 'failure';
            $data['error'] = '该产品已被购买，不运行删除';
            $this->load->view('masterpage',$data);
        }else{
            $this->product_model->del($id);
            redirect('/product/index', 'refresh');
        }
    }
   
    public function add()
    {
        $data['title'] = '添加产品' ;
        $this->form_validation->set_rules('ProductName', '产品名称', 'required');
        $this->form_validation->set_rules('Price', '产品价格', 'required|numeric|max_length[10]');
        
        if ($this->form_validation->run() === FALSE)
        {
           $data['include'] = 'product/add';
           $this->load->view('masterpage',$data);
        }
        else
        {
            $url = $this->uri->segment(3);
            //echo $url;
            $ProductType='';
            if($url=='servicelist'){
                $ProductType='服务产品';
            }
            elseif ($url=='materiallist') {
                $ProductType='产品物料';
            }
            $this->product_model->insert(
                $this->input->post('ProductName'),
                $this->input->post('Price'),
                $this->input->post('Description'),
                $ProductType
            );
            redirect('/product/'.$url, 'refresh');
        }
    }

    public function edit()
    {     
        $this->form_validation->set_rules('ProductName', '产品名称', 'required');
        $this->form_validation->set_rules('Price', '产品价格', 'required|numeric|max_length[10]');
        if ($this->form_validation->run() === FALSE)
        {
            $id = $this->uri->segment(3);
            $data['item']=$this->product_model->get($id);
            $data['title'] = '编辑产品';
            $data['include'] = 'product/edit';
            $this->load->view('masterpage',$data);
        }
        else
        {
            $this->product_model->update(
                $this->input->post('ProductID'),
                $this->input->post('ProductName'),
                $this->input->post('Price'),
                $this->input->post('Description')
            );
            redirect('/product/index', 'refresh');
        }
    }
    public function view()
    {
        $id = $this->uri->segment(3);
        $data['item']=$this->product_model->get($id);
        $data['title'] = '查看产品';
        $data['include'] = 'product/view';
        $this->load->view('masterpage',$data);
    }
    public function purchase()
    {
        $this->form_validation->set_rules('Amount', '数量', 'required|integer|max_length[10]');
        $this->form_validation->set_message('required', '客户不能为空');
        $this->form_validation->set_rules('CustomerID', '客户', 'required');
        $id = $this->uri->segment(3);
        $data['item']=$this->product_model->get($id);
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->model('customer_model');
            $data['title'] = '预订产品';
            $data['include'] = 'product/purchase';
            $data['row'] = $this->customer_model->getcustomerforpurchase();
            $this->load->view('masterpage',$data);
        }
        else
        {
            $UserID = $this->session->userdata('userid');
            $Price = $data['item']->Price;
            $Amount = $this->input->post('Amount');
            if($this->transaction_model->canpurchase($UserID,$Price,$Amount)==FALSE){
                $this->load->helper('html');
                $data['title'] = '预订产品失败';
                $data['include'] = 'failure';
                $data['error'] = '预订失败，你的余额不足以购买商品，请联系管理员充值';          
                $this->load->view('masterpage',$data);
            }else{
                if($this->transaction_model->purchase($Price))
                {
                    redirect('/product/index', 'refresh');
                }
                else
                {
                    $data['title'] = '预订产品失败';
                    $data['include'] = 'failure';
                    $data['error'] = '预订失败，请联系管理员';
                    $this->load->view('masterpage',$data);
                }
            }
        }
    }
}

