<?php
Class Project_model extends  MY_Model
{

    const DB_TABLE = 'project';
    const DB_TABLE_PK = 'id';
    
    /**
     * User id
     * @var int
     */
    public $id;
    
    /**
     * admin
     * @var string
     */
    public $admin;

    /**
     * approved
     * @var string
     */
    public $approved;



}

