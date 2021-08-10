<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{
		echo "hello from User Modules";
	}

}

/* End of file Dashboard.php */
/* Location: ./application/modules/user/Dashboard.php */