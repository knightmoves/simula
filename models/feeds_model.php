<?php
class Feeds_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_feeds($limit_records = 40)
	{
		$query = $this->db->get('feeds_user');
		$query->order_by("date_submitted", "desc"); 
		$query->limit($limit_records);
		return $query->result_array();
	}

	public function create($data)
	{	
		if($this->db->insert('feeds_user', $data))
		{
			return TRUE;
		}
		return FALSE;
	}

	public function feeds_count() 
	{
        return $this->db->count_all("feeds");
    }


}
