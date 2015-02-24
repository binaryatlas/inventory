<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if($this->authldap->is_authenticated()) {
		$tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered table-hover dataTable no-footer" aria-describedby="dataTables-example_info">');
        $this->table->set_template($tmpl);
 
        $this->table->set_heading("make","model","purchaseDate","installDate","greenTag","serial","ServiceTag");
		$this->load->view('welcome_message');
		}
		else {
			$this->load->view('auth/login_form');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */