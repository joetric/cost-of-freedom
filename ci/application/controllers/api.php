<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller {
	public function index()
	{
		$this->load->view('home');
	}
	public function birth_certificate($state, $county='') {
		$this->load->database();
		$this->db->where('state', $state);
		if($county!=='all') {
			$this->db->where('county', $county);
		}
		$result = $this->db->get('birth_certificate_info')->result();
		$result_json = json_encode($result);
		header('Content-type: application/json');
		echo $result_json;
	}
	public function voter_id_docs($state) {
		$this->load->database();
		$this->db->select('id_type, '.$state);
		$this->db->where($state.' != \'\'');
		$this->db->where('id_type != \'NOTES\'');
		$result = $this->db->get('document_by_state')->result();
		$docs = array();
		foreach($result as $row) {
			$docs[] = $row->$state == 'X' ? $row->id_type : $row->id_type.' ('.$row->$state.')';
		}
		$result = array('documents'=>$docs);
		$result_json = json_encode($result);
		header('Content-type: application/json');
		echo $result_json;
	}
}	