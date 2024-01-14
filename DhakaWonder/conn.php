<?php

class myDbConnect{
    
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $db = 'bus';
    public $con;


    function __construct(){
        $this->con = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        $this->checkConn();
    }
    

    function checkConn(){
        if (!$this->con) {
            die("Connection Problem.");
        }
    }

}








?>