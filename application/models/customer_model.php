<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Customer_model extends CI_Model {

        function __construct() {
            parent::__construct();   
            $this -> load -> database();
        }
        function getpagelist($pageindex)
        {
            $keyword = $this->input->post('txtSearch');
            if(isset($keyword))
            {
               $this->db->like('UserName',$keyword);
            }
            if($this->session->userdata("usertype")!=0){
                $this->db->where('UserID',$this->session->userdata("userid"));
            }
            return $this->db->get('cxcustomers',$pageindex+10,$pageindex)->result_array();
        }
        function getpagecount()
        {
            $keyword = $this->input->post('txtSearch');
            if(isset($keyword))
            {
               $this->db->like('UserName',$keyword);
            }
        	return $this->db->count_all_results('cxcustomers');
        }
        function insert()
        {
            $data = array(
                'UserID' => $this->session->userdata('userid'),
                'Company' => $this->input->post('Company'),
                'UserName' =>  $this->input->post('UserName'),
                'Position' => $this->input->post('Position'),
                'Phone' => $this->input->post('Phone'),
                'Address' =>  $this->input->post('Address'),
                'Email' => $this->input->post('Email')
                );         
            return $this->db->insert('cxcustomers', $data);
        }
        function update()
        {
            $data = array(
                'Company' => $this->input->post('Company'),
                'UserName' =>  $this->input->post('UserName'),
                'Position' => $this->input->post('Position'),
                'Phone' => $this->input->post('Phone'),
                'Address' =>  $this->input->post('Address'),
                'Email' => $this->input->post('Email')
                );    
            $this->db->where('CustomerID', $this->input->post('CustomerID'));     
            return $this->db->update('cxcustomers', $data);
        }
        /**
        *  获取客户信息
        **/
        function get($id)
        {
            $query = $this->db->get_where('cxcustomers', array('CustomerID' => $id));
            if ($query->num_rows() > 0)
            {
               return $query->row(); 
            } 
            return null;
        }
        /**
        * 判断是否能删除客户信息，如果购买了服务，则不能删除
        **/
        function candel($id)
        {
            $this->db->where('CustomerID', $id);
            $this->db->from('cxtransactions');
            return $this->db->count_all_results();
        }
        /**
        * 删除客户
        **/
        function del($id)
        {   
            $this->db->where('CustomerID', $id);     
            return $this->db->delete('cxcustomers');
        }
        /**
        * 获取某代理商的客户列表
        **/
        function getcustomerforpurchase()
        {
            $this->db->select('CustomerID,Company,UserName');
            $this->db->where('UserID',  $this->session->userdata('userid')); 
            $rows = $this->db->get("cxcustomers")->result(); 
            $result = array(' '=>'--请选择--');
            foreach ($rows as $row)
            {
                $key = $row->CustomerID.' ';
                $value = ($row->Company).'【'.($row->UserName).'】';
                $item = array($key=>$value);
                $result = array_merge($result,$item);
            }
            return $result;
        }
}
