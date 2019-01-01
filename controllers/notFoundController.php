<?php

class notFoundController extends Controller {
	public function index() {
		$this->loadView('404', []);
	}
}