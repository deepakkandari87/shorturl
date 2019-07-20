<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shorturlmodel extends CI_Model {

	private $table = 'shortern_url';

	/*
	 Get detail
	 */
	public function getAllData(){

		$query = $this->db->select('*')
					  ->from($this->table)
					  ->get();

		return $query->num_rows() > 0 ? $query->result() : [];
	}

	/*
	 Get detail
	 */
	public function getDetail($url){

		$query = $this->db->select('*')
			 ->from($this->table)
			 ->where('long_url', $url)
			 ->get()->row();

		return !empty($query) ? $query : [];
	}

	/*
	 Get detail by key
	 */
	public function getDetailByKey($key){

		$query = $this->db->select('*')
			 ->from($this->table)
			 ->where('id', $key)
			 ->get()->row();

		return !empty($query) ? $query : [];
	}

	/*
	 save data
	 */
	public function saveData($url){
		
		if(empty($url)) return false;

		$detail = $this->getDetail($url);

		// if url not exists 
		if(empty($detail)) {
	
			if($this->db->insert($this->table, ['long_url' => $url])){

				return $this->db->insert_id();
			} else {
				return false;
			}
			
		} else {
			
			return $detail->id;
		}
	}
}