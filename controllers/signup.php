<?php
// http://codeigniter.com/user_guide/libraries/form_validation.html
class Signup extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
        $this->load->helper('form');
        $this->load->helper('url');	
        $this->load->library('form_validation');
		$this->load->library('email');
		$this->_salt = "123456789987654321";
    }

	public function index()
	{
		$this->load->view('templates/header');
		if($this->user_model->logged_in() === TRUE)
		{
			$this->dashboard(TRUE);
		}
		else
		{
            $this->load->view('login/signup');
		}
		$this->load->view('templates/footer');
	
	}

	public function register()
	{
		$this->form_validation->set_rules('username', 'Username', 'xss_clean|required|callback_user_exists');
		$this->form_validation->set_rules('email', 'Email Address', 'xss_clean|required|valid_email|callback_email_exists');
		$this->form_validation->set_rules('password', 'Password', 'xss_clean|required|min_length[4]|max_length[12]|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'xss_clean|required|matches[password]|sha1');
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('templates/header');
            $this->load->view('login/signup');
			$this->load->view('templates/footer');
		}
		elseif (!$this->user_exists($this->input->post('username')))
		{
			$data["error"] = "Username already exists";
			$this->load->view('templates/header');
			$this->load->view('login/signup',$data);
			$this->load->view('templates/footer');
		}		
		elseif (!$this->email_exists($this->input->post('email')))
		{
			$data["error"] = "Email already registered";
			$this->load->view('templates/header');
			$this->load->view('login/signup',$data);
			$this->load->view('templates/footer');
		}		
		else
		{
			$data['user_username'] = $this->input->post('username');
			$data['user_email'] = $this->input->post('email');
//			$data['user_password'] = sha1($this->_salt . $this->input->post('password'));
			$data['user_password'] = $this->input->post('password');
			$data['verification'] = md5( rand(0,1000) );	
			if($this->user_model->create($data) === TRUE)
			{
				$text = "
Thanks for signing up! 

Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below. 
					
Username : " . $data['user_username'] . "
Password : " . $data['user_password'] . "

Please click this link to activate your account: 

" .  base_url() . "verify/vercode/" . $data['verification'] . "

				";
				
//    'smtp_host' => 'smtpout.secureserver.net',

$config = array(
    'protocol' => 'sendmail',
    'smtp_port' => 25,
    'smtp_host' => 'smtpout.secureserver.net',
    'smtp_user' => 'admin@seexvids.com',
    'smtp_pass' => 'seevidsad55min',
    'mailtype'  => 'html', 
);

$config1 = array(
    'protocol' => 'smtp',
	'smtp_timeout' => 800,
    'smtp_port' => 25,
    'smtp_host' => 'relay-hosting.secureserver.net',
);

				$this->email->initialize($config);
				$this->email->from('admin@seexvids.com', 'Admin');
				$this->email->to($data['user_email']); 
				$this->email->subject('Registration to seexvids.com');
				$this->email->message($text);	
				$this->email->send();

				$data['message'] = "The user account has now been created! You can login " . anchor('login', 'here') . ".";
				$this->load->view('templates/header');
				$this->load->view('login/success', $data);
				$this->load->view('templates/footer');
				
			}
			else
			{
				$data['error'] = "There was a problem when adding your account to the database.";
				$this->load->view('templates/header');
				$this->load->view('login/error', $data);
				$this->load->view('templates/footer');
			}
		}
	}

	public function dashboard($condition = FALSE)
	{
		if($condition === TRUE OR $this->auth->logged_in() === TRUE)
		{
			$this->load->view('templates/header');
			$this->load->view('login/dashboard');
			$this->load->view('templates/footer');
		}
		else
		{
			$this->load->view('templates/header');
			$this->load->view('account/details');
			$this->load->view('templates/footer');
		}
	}

	public function user_exists($user)
	{
		$query = $this->db->get_where('users', array('user_username' => $user));
		if($query->num_rows() > 0)
		{
			$this->form_validation->set_message('user_exists', 'The %s ' .  $user . ' already exists in our database, please use a different one.');
			return false;
		}
		$query->free_result();
		return true;
	}
	
	public function email_exists($email)
	{
		$query = $this->db->get_where('users', array('user_email' => $email));
		
		if($query->num_rows() > 0)
		{
			$this->form_validation->set_message('email_exists', 'The %s ' .  $email . ' already exists in our database, please use a different one.');
			return FALSE;
		}
		$query->free_result();
		return TRUE;
	}
}
?>
