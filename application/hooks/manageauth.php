<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageAuth 
{    
	private $CI;            
	public function __construct() 
	{        
		$this->CI = &get_instance();     
	}            
	/**     * 权限认证     */    
	public function auth() {        
		//$this->CI->load->helper('url');        
		if (!preg_match("/auth.*/i", uri_string())) 
		{        
			if( !$this->CI->session->userdata('userid') ) {        
				// 用户未登陆                
				redirect('/auth');                
				return;            
			}elseif ($this->checkurl()==FALSE) {
				redirect('/auth/unauth');
				return;
			}
		}  
		//echo "url:".uri_string();

 	} 

 	private function checkurl()
 	{
 		if(preg_match("/auth.*/i", uri_string()))
 			return TRUE;

 		$url = $this->CI->uri->segment(1).'/'.$this->CI->uri->segment(2);
 		
 		$menu = array(
 				'0' => array(
                     "首页"=>"default_page/index"
                    ,"产品列表"=>"product/index"
                    ,"添加产品"=>"product/add"
                    ,"编辑产品"=>"product/edit"
                    ,"删除产品"=>"product/del"
                    ,"查看产品"=>"product/view"
                    ,"客户列表" =>"customer/index"
                    ,"查看客户" =>"customer/view"
                    ,"编辑客户" =>"customer/edit"
                    ,"删除客户" =>"customer/del"
                    ,'用户列表'=>'user/index'
                    ,"代理商管理"=>"user/listagent"
                    ,"添加代理商"=>"user/addagent"
                    ,"第三方管理"=>"user/listthird"
                    ,"添加第三方"=>"user/addthird"
                    ,"查看用户"=>"user/view"
                    ,"编辑用户"=>"user/edit"
                    ,"删除用户"=>"user/del"
                    ,"用户充值"=>"user/recharge"
                    ,"设置代理商"=>"user/setagent"
                    ,'保存设置代理商' => 'user/savesetagent'
                    ,'修改密码'=>'user/changepwd'
                    ,"全部交易记录"=>"transaction/index"
                    ,"交易审批"=>"transaction/approvallist"
                    ,"全部充值记录"=>"transaction/allrecharge"
                    ,"全部购买记录"=>"transaction/purchase"
                    ,"查看记录"=>"transaction/view"
                    ,"审批记录"=>"transaction/approval"
                    ,"删除记录"=>"transaction/del"
                    ,"服务产品"=>"product/servicelist"
                    ,"产品物料"=>"product/materiallist"
                    ), 
                '1'=>array(
                    "首页"=>"default_page/index"
                    ,"产品列表"=>"product/index"
                    ,"服务产品"=>"product/servicelist"
                    ,"产品物料"=>"product/materiallist"
                    ,"查看产品"=>"product/view"
                    ,"订购产品"=>"product/purchase"
                    ,"客户列表" =>"customer/index"
                    ,"添加客户"=>"customer/add"
                    ,"查看客户"=>"customer/view"
                    ,"编辑客户"=>"customer/edit"
                    ,"删除客户"=>"customer/del"
                    ,"我的交易记录" =>"transaction/owntrans"
                    ,"我卖出的服务"=>"transaction/ownsale"
                    ,"查看我卖出的服务"=>"transaction/view"
                    ,"充值记录"=>"user/rechargehistory"
                    ,'修改密码'=>'user/changepwd'
                    ,"删除记录"=>"transaction/del"
                    ),
                '2'=>array(
                    "首页"=>"default_page/index"
                    ,"代理商列表" =>"user/listagent"
                    ,"产品列表"=>"product/index"
                    ,"服务产品"=>"product/servicelist"
                    ,"产品物料"=>"product/materiallist"
                    ,"代理商交易记录" =>"transaction/thirdlist"
                    ,'查看代理商'=>'user/view'
                    ,'查看产品' =>'product/view'
                    ,'查看我的代理商交易记录' =>'transaction/view'
                    ,'修改密码'=>'user/changepwd'
                	)
                );
        $t = $menu[$this->CI->session->userdata('usertype')];
        //print_r($t);
        foreach ($t as $key => $value) {
        	 //echo "string " .$value;
        	 if($value == $url)
        		return TRUE;
        }
        return FALSE;

 	}

 }