<?php

class User extends MY_Model {
    
    const DB_TABLE = 'user';
    const DB_TABLE_PK = 'id';
    
    /**
     * User id
     * @var int
     */
    public $id;
    
    /**
     * Project id.
     * @var int
     */
    public $project_id;


    /**
     * name
     * @var string
     */
    public $name;

    /**
     * nickname
     * @var string
     */
    public $nick_name;


    /**
     * mobile
     * @var string
     */
    public $mobile;

    /**
     * landline
     * @var string
     */
    public $landline;


    /**
     * email_address
     * @var string
     */
    public $email_address;
    
    
    /**
     * schedule
     * @var datetime
     */
    public $schedule;


    /**
     * birthday
     * @var datetime
     */
    public $birthday;

    /**
     * approved
     * @var string
     */
    public $approved;


}
