<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Product_model extends CI_Model {

        function __construct() 
        {
            parent::__construct();
            $this -> load -> database();
        }

        function getpagelist($pageindex)
        {
            $keyword = $this->input->post('txtSearch');
            if(isset($keyword))
            {
               $this->db->like('ProductName',$keyword);
            }
            $url =  $this->uri->segment(2);
            if($url=='servicelist'){
                $this->db->where('ProductType', '服务产品');
            }
            elseif ($url=='materiallist') {
                $this->db->where('ProductType', '产品物料');
            }
            return $this->db->get('cxproducts',$pageindex+10,$pageindex)->result_array();
        }
        function getpagecount()
        {
            $keyword = $this->input->post('txtSearch');
            if(isset($keyword))
            {
               $this->db->like('ProductName',$keyword);
            }
            if($url=='servicelist'){
                $this->db->where('ProductType', '服务产品');
            }
            elseif ($url=='materiallist') {
                $this->db->where('ProductType', '产品物料');
            }
        	return $this->db->count_all_results('cxproducts');
        }
        function update($ProductID,$ProductName,$Price,$Description)
        {
        	$data = array(
    			'ProductName' => $ProductName,
    			'Price' => $Price,
    			'Description' => $Description);
        	$this->db->where('ProductID', $ProductID);
			return $this->db->update('cxproducts', $data);
        }
        function insert($ProductName,$Price,$Description){
        	$data = array(
    			'ProductName' => $ProductName,
    			'Price' => $Price,
    			'Description' => $Description);        	
        	return $this->db->insert('cxproducts', $data);
        }
        function candel($id)
        {
            $this->db->where('ProductID',$id);
            return $this->db->count_all_results('cxtransactions')>0;
        }
        function del($id)
        {
        	$this->db->where('ProductID', $id);
			return $this->db->delete('cxproducts'); 
        }

        function get($id)
        {
        	$query = $this->db->get_where('cxproducts', array('ProductID' => $id));
        	if ($query->num_rows() > 0)
			{
			   return $query->row(); 
			} 

        	return null;
        }
}
