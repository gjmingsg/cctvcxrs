<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Transaction_model extends CI_Model {

        function __construct() {
                parent::__construct();
                $this -> load -> database();
        }

        function getpagelist($pageindex,$type)
        {
         	$sql = "select 
                t.Money * IFNULL(t.Amount,1) Money
                ,t.CreateTime
                ,if(t.TransType=1,'充值','购买') TransType
                ,u.UserName
                ,p.ProductName
                ,t.TStatus
                ,t.TransID
                ,c.UserName CustomerName
                ,c.CustomerID
                ,u.UserID from cxtransactions t inner join cxusers u on t.UserID = u.UserID
                left join cxcustomers c on c.CustomerID = t.CustomerID
                left join cxproducts p on p.ProductID = t.ProductID where 1=1 ";

        	$keyword1 = $this->input->post('txtSearch1');
            if(isset($keyword1) && $keyword1!=0 && $keyword1!='')
            {
               $sql = $sql." and t.CreateTime >=".$this->db->escape($keyword1);
            }
            $keyword2 = $this->input->post('txtSearch2');
            if(isset($keyword2) && $keyword2!=0 && $keyword2!='')
            {
               $sql = $sql." and t.CreateTime <=".$this->db->escape($keyword2);
            }
            if(isset($type))
            {
				$sql = $sql.' and TransType ='.$type;
            }
           	$sql = $sql.' limit '.($pageindex).", 10";
        	return $this->db->query($sql)->result_array();

        }

        function getpagecount($type)
        {
 			$keyword1 = $this->input->post('txtSearch1');
            if(isset($keyword1))
            {
               $this->db->where('CreateTime >=', $keyword1);
            }
            $keyword2 = $this->input->post('txtSearch2');
            if(isset($keyword2))
            {
               $this->db->where('CreateTime <=', $keyword2);
            }
            if(isset($type))
            {
				$this->db->where('TransType =', $type);
            }
        	return $this->db->count_all_results('cxtransactions');
        }
        /**
        * 获取账号余额
        **/
        function getbalance($userid)
        {
            $sql = "select ifnull(sum(ifnull(t.Money,0) * IF(t.Amount <> NULL,t.Amount,1) * t.TransType * t.Discount),0) as money
                    from cxtransactions t where t.TStatus = '通过' and t.UserID = ?";
            $query = $this->db->query($sql,array($userid));
            if ($query->num_rows() > 0)
            {
               return $query->row()->money; 
            } 
            return 0; 
        }
        /**
        * 充值
        **/
        function recharge()
        {
            $money =  $this->input->post('Money');
            $UserID = $this->input->post('UserID');
            $data = array(
                'Money' => $money,
                'UserID' => $UserID,
                'Amount' => 1,
                'TransType' => 1,
                'TStatus' => '通过',
                'Discount'=>1
            ); 
            $this->db->trans_start();
            $this->db->insert('cxtransactions', $data); 
            $this->db->where('UserID', $UserID);
            $this->db->update('cxusers', array('Balance' =>($this->getbalance($UserID)) )); 
            $this->db->trans_complete(); 
            return $this->db->trans_status();
        }
        /**
        * 充值记录
        **/
        function getownrecharge($UserID)
        {
            $this->db->select('money,createtime');
            $this->db->where('userid', $UserID); 
            $this->db->where('TransType',1);
            $this->db->order_by("createtime", "desc"); 
            return $this->db->get("cxtransactions")->result_array();
        }

        function getcustomertranshistory($customerid)
        {
            //'购买时间', '数量','金额','产品','审批状态','审批结果'
            $this->db->select('cxtransactions.CreateTime,Amount,cxtransactions.Money,ProductName,TStatus,ApprovalText');
            $this->db->from('cxtransactions');
            $this->db->join('cxproducts', 'cxproducts.ProductID = cxtransactions.ProductID');
            $this->db->where('CustomerID',$customerid);

            return $this->db->get()->result_array();
        }
        /**
        * 如果余额不足购买则不允许购买
        **/
        function canpurchase($UserID,$Price,$Amount)
        {
            $this->load->model('user_model');
            $item = $this->user_model->get($UserID);

            $t1 = $this->getbalance($UserID);
            $t2 = $Price * $Amount * ($item->Discount);//乘以折扣
            return ($t1-$t2>=0);
        }
        /**
        * 购买产品
        **/
        function purchase($Price)
        {
            $Amount = $this->input->post('Amount');
            $UserID = $this->session->userdata('userid');
            $this->load->model('user_model');
            $item = $this->user_model->get($UserID);
            $data = array(
                'UserID' => $UserID,
                'ProductID' => $this->input->post('ProductID'),
                'CustomerID' => trim($this->input->post('CustomerID')),
                'Money' => $Price,
                'Amount' => $Amount,
                'TransType' => -1,
                'TStatus' => '未审核',
                'Discount' => $item->Discount); 
            $this->db->trans_start();
            $this->db->insert('cxtransactions', $data); 
            $this->db->where('UserID', $UserID);
            $this->db->update('cxusers', array('Balance' =>($this->getbalance($UserID)) )); 
            $this->db->trans_complete(); 
            return $this->db->trans_status();
        }
        /**
        * 待审批订购清单
        **/
        function getapprovalpagelist($pageindex)
        {
            $sql = "select 
                t.Money * IFNULL(t.Amount,1) Money
                ,t.CreateTime
                ,if(t.TransType=1,'充值','购买') TransType
                ,u.UserName
                ,p.ProductName
                ,t.TStatus
                ,t.TransID
                ,u.UserID from cxtransactions t inner join cxusers u on t.UserID = u.UserID
                left join cxproducts p on p.ProductID = t.ProductID where 1=1 ";
            $keyword1 = $this->input->post('txtSearch1');
            if(isset($keyword1) && $keyword1!=0 && $keyword1!='')
            {
               $sql = $sql." and t.CreateTime >=".$this->db->escape($keyword1);
            }
            $keyword2 = $this->input->post('txtSearch2');
            if(isset($keyword2) && $keyword2!=0 && $keyword2!='')
            {
               $sql = $sql." and t.CreateTime <=".$this->db->escape($keyword2);
            }
            if(isset($type))
            {
                $sql = $sql.' and TransType ='.-1;
            }
            $sql = $sql.' and TStatus ='.$this->db->escape('未审核');
            $sql = $sql.' limit '.($pageindex).", 10";
            return $this->db->query($sql)->result_array();

        }
        /**
        * 待审批订购清单总数
        **/
        function getapprovalpagecount()
        {
            $keyword1 = $this->input->post('txtSearch1');
            if(isset($keyword1))
            {
               $this->db->where('CreateTime >=', $keyword1);
            }
            $keyword2 = $this->input->post('txtSearch2');
            if(isset($keyword2))
            {
               $this->db->where('CreateTime <=', $keyword2);
            }
            if(isset($type))
            {
                $this->db->where('TransType =', -1);
            }
            $this->db->where('TStatus =', '未审核');
            return $this->db->count_all_results('cxtransactions');
        }
        /**
        * 保存审批结果
        **/
        function approval()
        {
            $this->db->where('TransID', $this->input->post('TransID'));
            $UserID = $this->input->post('UserID');
            $TStatus = $this->input->post('TStatus');
            $data = array(
                'ApprovalText' =>$this->input->post('ApprovalText'),
                'TStatus' => $TStatus); 
            $this->db->trans_start();
            $this->db->update('cxtransactions', $data);
            if($TStatus=='通过') 
            {
                $this->db->where('UserID', $UserID);
                $this->db->update('cxusers', array('Balance' =>($this->getbalance($UserID)) )); 
            }
            $this->db->trans_complete(); 
            return $this->db->trans_status();
        }

        function get($TransID)
        {
            $this->db->select('TransID,cxtransactions.CreateTime,Amount,ProductName,UserID,Description,Price,cxtransactions.ProductID');
            $this->db->from('cxtransactions');
            $this->db->join('cxproducts','cxtransactions.ProductID = cxproducts.ProductID');
            $this->db->where('TransID', $TransID);
            $query = $this->db->get();
            if ($query->num_rows() > 0)
            {
               return $query->row(); 
            } 
            return null;
        }

        /**
        * 查询个人交易记录，包括充值记录
        **/
        function getownpurchasepagelist($pageindex,$type)
        {
            $sql = "select 
                t.Money * IFNULL(t.Amount,1) Money
                ,t.CreateTime
                ,if(t.TransType=1,'充值','购买') TransType
                ,u.UserName
                ,p.ProductName
                ,t.TStatus
                ,t.TransID
                ,c.UserName CustomerName
                ,c.CustomerID
                ,u.UserID 
                from cxtransactions t inner join cxusers u on t.UserID = u.UserID
                left join cxcustomers c on c.CustomerID = t.CustomerID
                left join cxproducts p on p.ProductID = t.ProductID where 1=1 ";
            $keyword1 = $this->input->post('txtSearch1');
            if(isset($keyword1) && $keyword1!=0 && $keyword1!='')
            {
               $sql = $sql." and t.CreateTime >=".$this->db->escape($keyword1);
            }
            $keyword2 = $this->input->post('txtSearch2');
            if(isset($keyword2) && $keyword2!=0 && $keyword2!='')
            {
               $sql = $sql." and t.CreateTime <=".$this->db->escape($keyword2);
            }
            if(isset($type) && $type==-1){
                $sql = $sql." and t.TransType <=-1";  
            }
            $sql = $sql.' and t.UserID ='.$this->db->escape($this->session->userdata('userid')).' limit '.($pageindex).", 10";
            return $this->db->query($sql)->result_array();
        }
        function getownpurchasepagecount($type)
        {
            $keyword1 = $this->input->post('txtSearch1');
            if(isset($keyword1))
            {
               $this->db->where('CreateTime >=', $keyword1);
            }
            $keyword2 = $this->input->post('txtSearch2');
            if(isset($keyword2))
            {
               $this->db->where('CreateTime <=', $keyword2);
            }
            if(isset($type) && $type==-1){
                $this->db->where('TransType =',$type);
            }
            $this->db->where('UserID =',$this->session->userdata('userid'));
            return $this->db->count_all_results('cxtransactions');
        }



        /**
        * 查询第三方旗下的代理的交易记录，包括充值记录
        **/
        function getthirdpagelist($pageindex)
        {
            $sql = "select 
                t.Money * IFNULL(t.Amount,1) Money
                ,t.CreateTime
                ,if(t.TransType=1,'充值','购买') TransType
                ,u.UserName
                ,p.ProductName
                ,t.TStatus
                ,t.TransID
                ,u.UserID 
                     from cxtransactions t inner join cxusers u on t.UserID = u.UserID
                inner join cxrelationship r on r.AgentUserID = u.UserID 
                left join cxproducts p on p.ProductID = t.ProductID
                      where r.ThirdUserID = ".$this->db->escape($this->session->userdata('userid'));
            $keyword1 = $this->input->post('txtSearch1');
            if(isset($keyword1) && $keyword1!=0 && $keyword1!='')
            {
               $sql = $sql." and t.CreateTime >=".$this->db->escape($keyword1);
            }
            $keyword2 = $this->input->post('txtSearch2');
            if(isset($keyword2) && $keyword2!=0 && $keyword2!='')
            {
               $sql = $sql." and t.CreateTime <=".$this->db->escape($keyword2);
            }
            $keyword3 = $this->input->post('txtSearch3');
            
            if(isset($keyword3) &&  $keyword3!=' '&& $keyword3!=0)
            {
               $sql = $sql." and t.UserID =".$this->db->escape($keyword3);
            }
            $sql = $sql.' limit '.($pageindex).", 10";
            return $this->db->query($sql)->result_array();
        }
        function getthirdpagecount()
        {
            $this->db->from('cxtransactions');
            $this->db->join('cxrelationship','cxrelationship.AgentUserID = cxtransactions.UserID');
            $keyword1 = $this->input->post('txtSearch1');
            if(isset($keyword1))
            {
               $this->db->where('CreateTime >=', $keyword1);
            }
            $keyword2 = $this->input->post('txtSearch2');
            if(isset($keyword2))
            {
               $this->db->where('CreateTime <=', $keyword2);
            }
            $keyword3 = $this->input->post('txtSearch3');
            if(isset($keyword3) &&  $keyword3!=' '&& $keyword3!=0)
            {
               $this->db->where('UserID =', $keyword3);
            }
            $this->db->where('ThirdUserID =',$this->session->userdata('userid'));
            return $this->db->count_all_results();
        }
        /**
        * 如果该交易已审批（包括未通过的），即不允许删除
        **/
        function candel($id)
        {
            $this->db->where('TransID', $id);
            $this->db->where('TStatus', '未审核');
            return $this->db->count_all_results('cxtransactions')>0;
        }
        function del($id)
        {
            $this->db->where('TransID', $id);
            $this->db->delete('cxtransactions'); 
        }
}
