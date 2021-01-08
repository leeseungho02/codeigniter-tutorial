<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once 'common.php';

class Main extends common
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// isNotLogin();
		$this->pageView('index');
	}
}
