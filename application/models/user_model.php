<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class User_model extends CI_Model {

        function __construct() {
            parent::__construct();               
            // 载入并初始化数据库类
            $this -> load -> database();
            $this->load->helper('security');
        }

        function getpagelist($pageindex,$type)
        {
            $this->db->select("*");
            $this->db->from('cxusers');
            if($this->session->userdata('usertype')==2){
                
                $this->db->join('cxrelationship','cxrelationship.AgentUserID=cxusers.userid and cxrelationship.ThirdUserID = '.$this->session->userdata('userid'));
            }
            $keyword = $this->input->post('txtSearch');
            if(isset($keyword))
            {
               $this->db->like('UserName',$keyword);
            }
            $this->db->where('UserType',$type);
            $this->db->limit($pageindex+10,$pageindex);
            return $this->db->get()->result_array();
        }
        function getpagecount($type)
        {
            $this->db->from('cxusers');
            if($this->session->userdata('usertype')==2){
                
                $this->db->join('cxrelationship','cxrelationship.AgentUserID=cxusers.userid and cxrelationship.ThirdUserID = '.$this->session->userdata('userid'));
            }
            $keyword = $this->input->post('txtSearch');
            if(isset($keyword))
            {
               $this->db->like('UserName',$keyword);
            }
	        $this->db->where('UserType',$type);
        	return $this->db->count_all_results();
        }
      
        function insert($type)
        {
            $data = array(
                'LoginId' => $this->input->post('LoginId'),
                'UserName' =>$this->input->post('UserName'),
                'Password' =>do_hash($this->input->post('Password'), 'md5'),
                'Balance' => 0,
                'Phone' =>$this->input->post('Phone'),
                'IDCard' =>$this->input->post('IDCard'),
                'Email' =>$this->input->post('Email'),
                'UserType' => $type,
                'Discount' => $this->input->post('Discount')
                );         
            return $this->db->insert('cxusers', $data);
        }
        function update()
        {
            $data = array(
                'LoginId' => $this->input->post('LoginId'),
                'UserName' =>$this->input->post('UserName'),
                //'Password' =>$this->input->post('Password'),
                'Phone' =>$this->input->post('Phone'),
                'IDCard' =>$this->input->post('IDCard'),
                'Email' =>$this->input->post('Email'),
                'Discount' => $this->input->post('Discount')
                );    
            $this->db->where('UserID', $this->input->post('UserID'));     
            return $this->db->update('cxusers', $data);
        }

        function get($id)
        {
            $query = $this->db->get_where('cxusers', array('UserID' => $id));
            if ($query->num_rows() > 0)
            {
               return $query->row(); 
            } 
            return null;
        }
        /**
        * 删除用户
        **/
        function del($UserID)
        {
        	$this->db->trans_start();
            $this->db->where('ThirdUserID',$UserID);
            $this->db->delete('cxrelationship');
            $this->db->where('UserID',$UserID);
            $this->db->delete('cxusers');
            $this->db->trans_complete(); 
        }
        /**
        * 判断是否能删除用户，返回null表示可以删除
        **/
        function candel($UserID)
        {
            $this->db->where('UserID',$UserID);
            if($this->db->count_all_results('cxtransactions')>0)
            {
                return '该代理商购买了相关产品，不能删除，否则购买记录将被清除';
            }
            $this->db->where('UserID',$UserID);
            if($this->db->count_all_results('cxcustomers')>0)
            {
                return '该代理商设置了客户信息，不能删除，否则客户信息也将被清除';
            }
            $this->db->where('ThirdUserID',$UserID);
            if($this->db->count_all_results('cxrelationship')>0)
            {
                return '该第三方商家设置了代理商，不能删除，否则代理商信息也将被清除';
            }
            return null;
        }
        function changepwd()
        {
            $this->db->where('UserID', $this->input->post('UserID'));
            $data = array('Password' =>do_hash($this->input->post('Password'), 'md5'));  
            return $this->db->update('cxusers', $data);       
        }
        /**
        * 登录认证检查账号是否合法
        **/
        function validateuser()
        {
            $this->db->where("Password",do_hash($this->input->post('password'), 'md5'));
            $this->db->where("LoginId",$this->input->post('login_name'));
            $query = $this->db->get('cxusers');            
            if ($query->num_rows() > 0)
            {
               return $query->row(); 
            } 
            return null;
        }
        /**
        * 查询已被选择的代理商
        **/
        function getselecteduser($UserID)
        {
            $sql = 'select u.UserName,u.UserID,u.LoginId from cxusers u inner join cxrelationship r on u.UserID = r.AgentUserID where u.UserType=1 and r.ThirdUserID = ?';
            $rows = $this->db->query($sql, array($UserID))->result(); 
            $result = array();
            foreach ($rows as $row)
            {
                $key = $row->UserID.' ';
                $value = ($row->UserName).'【'.($row->LoginId).'】';
                $item = array($key=>$value);
                $result = array_merge($result,$item);
            }
            return $result;
        }
        function getunselectuser($UserID)
        {
            $sql = 'select u.UserName,u.UserID,u.LoginId from cxusers u where u.usertype = 1 and not exists(select 1 from cxrelationship r where u.UserID = r.AgentUserID and r.ThirdUserID = ?)';
            $rows = $this->db->query($sql, array($UserID))->result(); 
            $result = array();
            foreach ($rows as $row)
            {
                $key = $row->UserID.' ';
                $value = ($row->UserName).'【'.($row->LoginId).'】';
                $item = array($key=>$value);
                //print_r($item);
                $result = array_merge($result,$item);
                
            }

            return $result;
        }
        /**
        * 保存第三方商家和代理商的关系
        **/
        function saverelationship($ar,$UserID)
        {
            $this->db->where('ThirdUserID',$UserID);
            $this->db->trans_start();
            $this->db->delete('cxrelationship');
            foreach ($ar as  $value) {
                if(isset($value) && $value!=''){
                    $data  = array('ThirdUserID' =>trim($UserID) ,'AgentUserID'=>trim($value));
                    $this->db->insert('cxrelationship',$data);
                }
            }
            $this->db->trans_complete(); 
            return $this->db->trans_status();
        }
        /**
        * 获取代理商列表
        **/
        function getagentlist($UserID)
        {
            $sql = 'select u.UserName,u.UserID 
            from cxusers u left join cxrelationship c on u.UserID = c.AgentUserID
            where u.UserType=1';
            if($this->session->userdata('usertype')!=0){
                $sql=$sql.' and c.ThirdUserID='.$this->db->escape_str($UserID);
            }
            $rows = $this->db->query($sql)->result(); 
            $result = array(' '=>'--请选择代理商--');
            foreach ($rows as $row)
            {
                $key = $row->UserID.' ';
                $value = $row->UserName;
                $item = array($key=>$value);
                //print_r($item);
                $result = array_merge($result,$item);
            }
            return $result;
        }
}

