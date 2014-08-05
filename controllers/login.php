<?php
class Login extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));	
		$this->load->model('user_model');
	}

	public function index()
	{
		if($this->user_model->logged_in() === TRUE)
		{
			$this->load->view('templates/header');
			$this->load->view('login/dashboard');
			$this->load->view('templates/footer');
		}
		else
		{
			$this->load->view('templates/header');
			$this->load->view('login/view');
			$this->load->view('templates/footer');
		}	
	}	

	public function checklog()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('login', 'Email Address', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('templates/header');
			$this->load->view('login/view');
			$this->load->view('templates/footer');
		}
		else
		{
			$email_address = $this->input->post('login');
			$password = $this->input->post('password');			
			$arrResult = $this->valid_credentials($email_address, $password);
			if ($arrResult["error"] == "" )
			{
				$data = array(
					'id'	=> $arrResult["id"], 
					'login' => $this->input->post('login'),
					'name' => $arrResult["name"],
					'is_logged_in' => true
				);
				$this->session->set_userdata($data);
				redirect('/member');
//				$this->load->view('templates/header');
	//			$this->load->view('login/dashboard', $data);
	//			$this->load->view('templates/footer');
			}
			else
			{
				$data["error"] = $arrResult["error"];
				$this->load->view('templates/header');
				$this->load->view('login/view',$data);
				$this->load->view('templates/footer');
			}		
		}
		
	}

	public function valid_credentials($username, $password)
	{
		$err_message  = "";
		$id = "";
		$name = "";
		$query = $this->db->get_where('user', array('email_address' => $username, 'user_password' => $password));
		if($query->num_rows() > 0)
		{
			$arrUser = $query->result_array();
			if ($arrUser[0]["approved"] != 1)
			{
				$err_message = "Your account is still inactive";
			}		
			else
			{
				$id = $arrUser[0]["email_address"];
				$name = $arrUser[0]["name"];
			}	
		}
		else
		{
			$err_message = "Invalid username/password";
		}	
		$query->free_result();
		return array( "error" => $err_message, "id" => $id, "name" => $name );
	}


	public function logout()
	{
		$data = array(
			'id'	=> 0, 
			'username' => "",
			'is_logged_in' => false
		);
		$this->session->set_userdata($data);
		$this->session->sess_destroy();
		$this->load->view('templates/header');
		$this->load->view('login/view');
		$this->load->view('templates/footer');
	}
}
