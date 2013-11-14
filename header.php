<?php

class Header {
	private $name;
	private $data = array();

	function __construct($n) {
		$this->name = $n;
	}

	public function add_data($value, $id) {
		$this->data[$id] = $value;
	}

	public function get_data($id) {
		if(array_key_exists($id, $this->data)) {
			return $this->data[$id];
		}
		return null;
	}

	public function get_name() {
		return $this->name;
	}
}