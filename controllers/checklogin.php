<?php
class Checklogin extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
        $this->load->helper('form');
        $this->load->helper('url');	
   }

	public function index()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('login', 'Email address', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('templates/header');
			$this->load->view('login/view');
			$this->load->view('templates/footer');
		}
		else
		{
			redirect('home');
		}
	}

	public function check_database($password)
	{
		$this->load->model('user_model');
		$email_address = $this->input->post('login');
		$result = $this->user_model->login($username, $password);
		if($result)
		{
			$sess_array = array();
			foreach($result as $row)
			{
				$sess_array = array(
					'id' => $row->id,
					'username' => $row->username
								);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}


	function login()
	{
		$this->form_validation->set_rules('login', 'Email', 'xss_clean|required|callback_username_check');
		$this->form_validation->set_rules('password', 'Password', 'xss_clean|required|min_length[4]|max_length[12]|callback_password_check');
	
		$this->_username = $this->input->post('username');
		$this->_password = sha1($this->_salt . $this->input->post('password'));
	
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('account/login');
		}
		else
		{	
			$this->auth->login();
		
			$data['message'] = "You are logged in! Now go take a look at the " . anchor('account/dashboard', 'Dashboard');
			$this->load->view('account/success', $data);
		}
	}

	function password_check()
	{
		$query = $this->db->get_where('users', array('email_address' => $this->_email_address, 'password' => $this->_password));
	
		if($query->num_rows() == 0)
		{
			$this->form_validation->set_message('email_address_check', 'There was an error!');
			return FALSE;
		}

		$query->free_result();
	
		return TRUE;	
	}


}
