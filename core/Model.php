<?php

class Model {
	protected $database;

	public function __construct() {
		global $database;
		$this->database = $database;
	}
}