<?php
class Login extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	function form_insert($data){
		$this->db->insert('usuariosln', $data);
	}
}