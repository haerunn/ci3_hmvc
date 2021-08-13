<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$data['form_url'] = base_url()."admin";
		$this->load->view('admin/index', $data ?? null, FALSE);
	}

	function create()
	{
		try {
			$post = $this->input->post();
			$directory = APPPATH."modules/".$post['brand'];

			// **
			// check if directory already exist
			if ( !file_exists( $directory ) && !is_dir( $directory ) ) {
				// **
				// create directory if not exist
				if (mkdir($directory)) {
					// **
					// continue to create controllers folder, and its index controllers
					if (mkdir($directory."/controllers")) {
						$index_controller = fopen($directory."/controllers/Dashboard.php","w");
						$content_controller = "<?php
						defined('BASEPATH') OR exit('No direct script access allowed');

						class Dashboard extends CI_Controller {

							public function index()
							{
								\$this->load->view('index', \$data ?? null, FALSE);
							}

						}

						/* End of file Dashboard.php */
						/* Location: ./application/controllers/$post[brand]/Dashboard.php */
						?>";
						fwrite($index_controller, $content_controller);
					}
					mkdir($directory."/models");
					mkdir($directory."/views");

					// **
					// create uploads directory
					$dir_uploads = mkdir($directory."/uploads");
					if (!$dir_uploads) {
						throw new Exception('Uploads directory failed to create');
					}

					// **
					// upload file
					$config['upload_path'] = $directory."/uploads";
					$config['allowed_types'] = 'zip';
					$config['max_size']  = '3000';
					
					$this->load->library('upload', $config);
					
					if ( ! $this->upload->do_upload('file')){
						$error = array('error' => $this->upload->display_errors());
					}
					else{
						$data = array('upload_data' => $this->upload->data());
						$zip = new ZipArchive;

						// **
						// unzip uplaoded file
						if ($zip->open($data['upload_data']['full_path']) === TRUE) {
							$zip->extractTo($directory."/uploads/unzipped");
							$zip->close();

							// **
							// define directory for unzipped file
							$dir_unzip = $directory."/uploads/unzipped/".$data['upload_data']['raw_name'];
							
							// **
							// copy assets from unzipped directory to directory brand assets
							rcopy($dir_unzip."/assets/", FCPATH."/assets/".$post['brand']."/");
							
							// **
							// move index.php to view
							rename($dir_unzip."/index.php", $directory."/views/index.php");

							// **
							// replace {base_url}
							$fname = $directory."/views/index.php";
							$fhandle = fopen($fname,"r");
							$content = fread($fhandle,filesize($fname));
							$content = str_replace("{assets}", base_url()."assets/${post['brand']}/", $content);

							$fhandle = fopen($fname,"w");
							fwrite($fhandle,$content);
							fclose($fhandle);
						}
					}
				}
			}			
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/admin/Dashboard.php */