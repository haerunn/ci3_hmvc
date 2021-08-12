<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$this->load->view('admin/index', $data ?? null, FALSE);
	}

	function create()
	{
		$post = $this->input->post();
		print_r($post);
		$directory = APPPATH."modules/".$post['brand'];

		// **
		// check if directory already exist
		if ( !file_exists( $directory ) && !is_dir( $directory ) ) {
			if (mkdir($directory)) {
				if (mkdir($directory."/controllers")) {
					$index_controller = fopen($directory."/controllers/Dashboard.php","w");
					$content_controller = "<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		echo 'this is index of $post[brand]';
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/$post[brand]/Dashboard.php */
?>";
					fwrite($index_controller, $content_controller);
				}
				mkdir($directory."/models");
				mkdir($directory."/views");
			}
		}
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/admin/Dashboard.php */