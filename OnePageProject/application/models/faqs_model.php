<?php if(!defined('BASEPATH')) die('No direct script access allowed!');

class faqs_model extends CI_Model {
	var $CI;

	/*
	Constructor
	*/
	function __construct(){
        	// Call the Model constructor
        	parent::__construct();
		$this->CI 	=& get_instance();
		
		$this->table_faqs		= $this->CI->config->item('table_faqs');		
		$this->table_faqs_details		= $this->CI->config->item('table_faqs_details');		
	}
	
	function get($where=false, $answers=false){
		if( $answers === true){
			$sql = "SELECT faq.*, faq_d.* "
					. "FROM ".$this->table_faqs." as faq "
					. "LEFT JOIN ".$this->table_faqs_details." as faq_d "
					. "ON faq_d.faq_id=faq.answer_id ";
			
			$query = $this->db->query($sql);
			$answers = $query->result_array();
			$query->free_result();

			$answers_list = array();
			foreach($answers as $key=>$value ){
				$answers_list[$value['question_id']][] = $value;
			}
			return $answers_list;
		}		
		
		$this->db->select('*');
		$this->db->from($this->table_faqs_details);			
		if($where !== false)
			$this->db->where($where, null, false);		
			
		$query = $this->db->get();	
		
		$result = $query->result_array();
		//$result = array_unique($result[0]);
		$query->free_result();
		
		return $result;
	
	/*	$id=0;
		$this->db->insert($this->table_faqs, $data);
		
		if($this->db->affected_rows() ){
			$id = $this->db->insert_id($this->table);
		}*/
	}
	
	function count_all($where=false,$like=false){
		$this->db->select('count('.$this->table_faqs_details.'.faq_id) as no_faqs');
		$this->db->from($this->table_faqs_details);		
			
		if($where !== false)
			$this->db->where($where, null, false);
			
		if($like !== false)
			$this->db->like($like);
			
		$query=$this->db->get();		
		$result=$query->row_array();
		
		$query->free_result();
		
		if($result)	return $result['no_faqs'];
		else return 0;
	}
}