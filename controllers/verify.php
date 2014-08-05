<?php
class Verify extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model','',TRUE);
        $this->load->helper('url');	
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
            $this->load->view('login/verify');
		}
		$this->load->view('templates/footer');
	
	}

	public function vercode($verification_code)
	{
		$this->load->model('user_model');
		if ($this->user_model->checkVerification($verification_code) )
		{
			$data['message'] =  "Your account has been activated";
		}
		else
		{
			$data['message'] = "Wrong Confirmation code";
		}	
		$this->load->view('templates/header');
		$this->load->view('login/success', $data);
		$this->load->view('templates/footer');
	}
}
?>
