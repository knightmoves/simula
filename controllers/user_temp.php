<?php
class User_temp extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
        $this->load->helper('url');	
		$this->load->library('session');
        $this->load->library('form_validation');
	}

	public function index()
	{
		$this->load->model('user_model');
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

        $this->load->model('Project_model');
        $projects = $this->Project_model->get();
        $arrProjects = array();
        foreach ($projects as $id => $project) {
            $arrProjects[$id] = $project->name;
        }        
		var_dump($arrProjects);
	
	}	

    /**
     * Add a Magazine.
     */
    public function add() {

    	
    	$config = array(
            'upload_path' => 'upload',
            'allowed_types' => 'jpg|png',
            'max_size' => 250,
            'max_width' => 1920,
            'max_heigh' => 1080,
        );
        $this->load->library('upload', $config);
        $this->load->helper('form');
        $this->load->view('templates/header');
        
        
        // Populate publications.
        $this->load->model('Publication');
        $publications = $this->Publication->get();
        $publication_form_options = array();
        foreach ($publications as $id => $publication) {
            $publication_form_options[$id] = $publication->publication_name;
        }        
        // Validation.
        $this->load->library('form_validation');
        $this->form_validation->set_rules(array(
           array(
               'field' => 'publication_id',
               'label' => 'Publication',
               'rules' => 'required',
           ),
           array(
               'field' => 'issue_number',
               'label' => 'Issue number',
               'rules' => 'required|is_numeric',
           ),
           array(
               'field' => 'issue_date_publication',
               'label' => 'Publication date',
               'rules' => 'required|callback_date_validation',
           ),
        ));
        $this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
        $check_file_upload = FALSE;
        if (isset($_FILES['issue_cover']['error']) && ($_FILES['issue_cover']['error'] != 4)) {
            $check_file_upload = TRUE;
        }
        if (!$this->form_validation->run() || ($check_file_upload && !$this->upload->do_upload('issue_cover'))) {
            $this->load->view('magazine_form', array(
                'publication_form_options' => $publication_form_options, 
            ));
        }
        else {
            $this->load->model('Issue');
            $issue = new Issue();
            $issue->publication_id = $this->input->post('publication_id');
            $issue->issue_number = $this->input->post('issue_number');
            $issue->issue_date_publication = $this->input->post('issue_date_publication');
            $upload_data = $this->upload->data();
            if (isset($upload_data['file_name'])) {
                $issue->issue_cover = $upload_data['file_name'];
            }
            $issue->save();
            $this->load->view('magazine_form_success', array(
                'issue' => $issue,
            ));
        }
        $this->load->view('bootstrap/footer');
    }
    
    /**
     * Date validation callback.
     * @param string $input
     * @return boolean
     */
    public function date_validation($input) {
        $test_date = explode('-', $input);
        if (!@checkdate($test_date[1], $test_date[2], $test_date[0])) {
            $this->form_validation->set_message('date_validation', 'The %s field must be in YYYY-MM-DD format.');
            return FALSE;
        }
        return TRUE;
    }


	public function uploadvideos($error = array())
	{
		$this->load->view('templates/header');
		$username = $this->session->userdata('username');
		if (!empty($username) )
		{
			$data['title'] = array(
									"id" 		=> "title", 
									"name" 		=> "title", 
									"maxlength" => "50",
									"style"     => 'clear:left',
									"title"     => set_value('title'),								 
								 );
			$data['categories'] = $this->category_model->get_categoriesselect();
			$data["error"] = $error;
			$this->load->view('login/upload', $data);
		}	
		else
		{
			$this->load->view('login/view');
		}	
		$this->load->view('templates/footer');

	}

	public function do_upload()
	{
		var_dump($_POST);
		var_dump($_FILES);
//		die();
		$this->form_validation->set_rules('title', 'Video Title', 'required');
		$this->load->model('user_model');
		if($this->form_validation->run() == FALSE)
		{
			$this->uploadvideos();
		}
		else	
		{
			$error = array();
			$config['upload_path'] = './uploads/';
			$config['max_size']	= '110000';
			$config['max_width']  = '110240';
			$config['max_height']  = '17680';
			$config['allowed_types'] = 'x-flv|flv|3gpp|3gp|mpg';
			$userfile = $config['file_name'] = $this->session->userdata('id') . "_" . time() . "_" . $_FILES["userfile"]["name"];
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('userfile'))
			{
				$data = array('upload_data' => $this->upload->data('userfile'));
			}					
			else
			{
				$error[] = "flv file " . $this->upload->display_errors();
				$this->uploadvideos($error);
			}	
			if (empty($error) ) 
			{	
				$config['allowed_types'] = 'jpeg|jpg|png';
				$imagefile = $config['file_name'] = $this->session->userdata('id') . "_" . time() . "_" . $_FILES["imagefile"]["name"];
				$this->upload->initialize($config); 
				if ($this->upload->do_upload('imagefile'))
				{
					$data = array( 	'upload_data' => $this->upload->data('imagefile'));
				}					
				else
				{
					$error[] = "image  file " . $this->upload->display_errors();
					$this->uploadvideos($error);
				}	
			}	
			if (empty($error))
			{
				$this->load->model('video_model');
				$insertdata['vid_title'] = $this->input->post('title');
				$insertdata['vid_flv'] = $userfile;
				$insertdata['vid_flv_img'] = $imagefile;
				$insertdata['vid_category'] = $this->input->post('category');
				$insertdata['vid_userid'] = $this->session->userdata('id');
				$insertdata['vid_dateadded'] = date("Y-m-d, g:i:a");
				$this->video_model->create($insertdata); 
				$this->load->view('templates/header');
				$this->load->view('login/upload_success', $data);
				$this->load->view('templates/footer');
			}
			else
			{	
				$data['title'] = array(
										"id" 		=> "title", 
										"name" 		=> "title", 
										"maxlength" => "50",
										"style"     => 'clear:left',
										"title"     => set_value('title'),								 
									 );
				$data['categories'] = $this->category_model->get_categoriesselect();
				$data["error"] = array();
				$this->load->view('templates/header');
				$this->load->view('login/upload', $data);
				$this->load->view('templates/footer');
			}	
		}
	}
	
}
?>

