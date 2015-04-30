<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends CI_Controller {
	/**
	 */
     public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }
	/**
	 *全部交易记录(购买，充值)
	 */
	public function index()
	{
		$this->load->library('pagination');
        $pageindex = $this->uri->segment(3);
        if($pageindex=='')
            $pageindex = 0;
        $data['include'] = 'transaction/list';
        $data['title']="全部交易记录(购买，充值)";
        $data['options'] = $this->user_model->getagentlist($this->session->userdata("userid"));
        $data["row"] = $this->transaction_model->getpagelist($pageindex,null);
        $config['base_url'] = site_url('transaction/index');
        $config['total_rows'] = $this->transaction_model->getpagecount(null);
        $config['per_page'] = 10; 
        $this->pagination->initialize($config); 
        $this->load->view('masterpage',$data);
	}

	public function approvallist()
	{
		$this->load->library('pagination');
        $pageindex = $this->uri->segment(3);
        if($pageindex=='')
            $pageindex = 0;
        $data['include'] = 'transaction/list';
        $data['title']="待审批的交易";
        $data["row"] = $this->transaction_model->getapprovalpagelist($pageindex);
        $data['options'] = $this->user_model->getagentlist($this->session->userdata("userid"));
        $config['base_url'] =site_url('transaction/approvallist');
        $config['total_rows'] = $this->transaction_model->getapprovalpagecount();
        $config['per_page'] = 10; 
        $this->pagination->initialize($config); 
        $this->load->view('masterpage',$data);
	}
    public function approval()
    {
        $id = $this->uri->segment(3);
        $data['item']=$this->transaction_model->get($id);
        $this->form_validation->set_rules('TStatus', '审批结果', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $data['title'] = '审批交易';
            $data['include'] = 'transaction/approval';
            $this->load->view('masterpage',$data);
        }
        else
        {
            $UserID = $this->input->post('UserID');;
            $Price = $data['item']->Price;
            $Amount = $this->input->post('Amount');
            $TStatus = $this->input->post('TStatus');
            if($TStatus =='通过' && $this->transaction_model->canpurchase($UserID,$Price,$Amount)==FALSE){
                $this->load->helper('html');
                $data['title'] = '预订产品失败';
                $data['include'] = 'failure';
                $data['error'] = '预订失败，该代理商的余额不足以购买商品，请及时充值';          
                $this->load->view('masterpage',$data);
            }else{
                if($this->transaction_model->approval())
                {
                    redirect('/transaction/approvallist', 'refresh');
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
    public function view($id)
    {
        $data['title'] = '查看交易';
        $data['item'] = $this->transaction_model->get($id);
        $data['include'] = 'transaction/view';
        $this->load->view('masterpage',$data);
    }
	public function allrecharge()
	{
		$this->load->library('pagination');
        $pageindex = $this->uri->segment(3);
        if($pageindex=='')
            $pageindex = 0;
        $data['include'] = 'transaction/list';
        $data['title']="全部充值记录";
        $data["row"] = $this->transaction_model->getpagelist($pageindex,1);
        $data['options'] = $this->user_model->getagentlist($this->session->userdata("userid"));
        $config['base_url'] = site_url('transaction/allrecharge');
        $config['total_rows'] = $this->transaction_model->getpagecount(1);
        $config['per_page'] = 10; 
        $this->pagination->initialize($config); 
        $this->load->view('masterpage',$data);
	}

	public function purchase()
	{
		$this->load->library('pagination');
        $pageindex = $this->uri->segment(3);
        if($pageindex=='')
            $pageindex = 0;
        $data['include'] = 'transaction/list';
        $data['title']="全部购买记录";
        $data['options'] = $this->user_model->getagentlist($this->session->userdata("userid"));
        $data["row"] = $this->transaction_model->getpagelist($pageindex,-1);
        $config['base_url'] = site_url('transaction/purchase');
        $config['total_rows'] = $this->transaction_model->getpagecount(-1);
        $config['per_page'] = 10; 
        $this->pagination->initialize($config); 
        $this->load->view('masterpage',$data);
	}
    /**
    * 我的交易记录
    **/
    public function owntrans()
    {
        $this->load->library('pagination');
        $pageindex = $this->uri->segment(3);
        if($pageindex=='')
            $pageindex = 0;
        $data['include'] = 'transaction/list';
        $data['title']="我的交易记录";
        $data["row"] = $this->transaction_model->getownpurchasepagelist($pageindex,0);
        $config['base_url'] = site_url('transaction/owntrans');
        $config['total_rows'] = $this->transaction_model->getownpurchasepagecount(0);
        $config['per_page'] = 10; 
        $this->pagination->initialize($config); 
        $this->load->view('masterpage',$data);
    }
    public function ownsale()
    {
        $this->load->library('pagination');
        $pageindex = $this->uri->segment(3);
        if($pageindex=='')
            $pageindex = 0;
        $data['include'] = 'transaction/list';
        $data['title']="我的交易记录";
        $data["row"] = $this->transaction_model->getownpurchasepagelist($pageindex,-1);
        $config['base_url'] = site_url('transaction/ownsale');
        $config['total_rows'] = $this->transaction_model->getownpurchasepagecount(-1);
        $config['per_page'] = 10; 
        $this->pagination->initialize($config); 
        $this->load->view('masterpage',$data);
    }
    public function thirdlist()
    {
        $this->load->library('pagination');
        
        $pageindex = $this->uri->segment(3);
        if($pageindex=='')
            $pageindex = 0;
        
        $data['include'] = 'transaction/thirdlist';
        $data['title']="我的代理商交易记录";
        $data['options'] = $this->user_model->getagentlist($this->session->userdata("userid"));
        $data["row"] = $this->transaction_model->getthirdpagelist($pageindex);
        $config['base_url'] = site_url('transaction/thirdlist');
        $config['total_rows'] = $this->transaction_model->getthirdpagecount();
        $config['per_page'] = 10; 
        $this->pagination->initialize($config); 
        $this->load->view('masterpage',$data);
    }
    /**
    * 删除为审批的记录
    **/
    public function del()
    {
        $id = $this->uri->segment(3);
        $this->load->helper('html');
        if(!$id){
            $data['title'] = '删除预定失败';
            $data['include'] = 'failure';
            $data['error'] = '删除失败，可能是提供了不合法的数据，请联系管理员充值';          
            $this->load->view('masterpage',$data);
        }elseif ($this->transaction_model->candel($id)) {
            $this->transaction_model->del($id);
            if ($this->session->userdata("usertype")==2)
                redirect("transaction/thirdlist",'refresh') ;
            elseif($this->session->userdata("usertype")==1)
                redirect("transaction/owntrans",'refresh') ;
            else
                redirect("transaction/index",'refresh') ;
        }
        else{
            $data['title'] = '删除预定失败';
            $data['include'] = 'failure';
            $data['error'] = '删除失败，该交易已审批，不允许删除';          
            $this->load->view('masterpage',$data);
        }
    }
}

