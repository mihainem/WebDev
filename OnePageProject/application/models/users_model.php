<?php if(!defined('BASEPATH')) die('No direct script access allowed!');

class users_model extends CI_Model {
	var $CI;

	/*
	Constructor
	*/
	function __construct(){
        	// Call the Model constructor
        	parent::__construct();
		$this->CI 	=& get_instance();
		
		$this->table		= $this->CI->config->item('table_users');		
		//$this->table_details		= $this->CI->config->item('table_users_details');		
	}
	
	function get($where=false){	
		
		$this->db->select('*');
		$this->db->from($this->table);			
		if($where !== false)
			$this->db->where($where, null, false);		
			
		$query = $this->db->get();	
		
		$result = $query->result_array();
		
		$query->free_result();
		if( !empty($result) ){
			return $result;
		}
		return false;
	
	/*	$id=0;
		$this->db->insert($this->table_users, $data);
		
		if($this->db->affected_rows() ){
			$id = $this->db->insert_id($this->table);
		}*/
	}
	
	function count_all($where=false,$like=false){
		$this->db->select('count('.$this->table.'.id) as count');
		$this->db->from($this->table);		
			
		if($where !== false)
			$this->db->where($where, null, false);
			
		if($like !== false)
			$this->db->like($like);
			
		$query=$this->db->get();		
		$result=$query->row_array();
		
		$query->free_result();
		
		if($result)	return $result['count'];
		else return 0;
	}
}