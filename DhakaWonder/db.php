<?php 
include_once 'conn.php';


class dataExtract{
    public $res_obj;
    public $dbcon;
    private $qr;
    
    function __construct($qt=NULL){
        if ($qt === NULL) {
            $this->qr = "SELECT * FROM destination";
            $this->dbcon = new myDbConnect();
            $this->res_obj = mysqli_query($this->dbcon->con, $this->qr);    
            $this->mFetchToArray();
        }elseif ($qt === "route") {
            
            $this->dbcon = new myDbConnect();
        }elseif ($qt === "Slide") {
            $this->qr = "SELECT * FROM destination LIMIT 5";
            // $this->qr = "SELECT * FROM destination LIMIT 5";
            $this->dbcon = new myDbConnect();
            $this->res_obj = mysqli_query($this->dbcon->con, $this->qr);    
            $this->mFetchToArray();
        }elseif ($qt === "guid") {
            $this->qr = "SELECT * FROM destination LIMIT 5";
            // $this->qr = "SELECT * FROM destination LIMIT 5";
            $this->dbcon = new myDbConnect();
            $this->res_obj = mysqli_query($this->dbcon->con, $this->qr);    
            $this->mFetchToArray();
        }else {
            $this->qr = $qt;
            $this->dbcon = new myDbConnect();
            $this->res_obj = mysqli_query($this->dbcon->con, $this->qr);    
            return  $this->res_obj;
        }
        
    }

    private $ARRAY_INDEX = 0;
    private $d_id = array();
    private $d_name = array();
    private $d_desc = array();
    private $d_loc = array();
    private $d_bs = array();
    private $d_off = array();
    private $d_on = array();
    private $d_ticket = array();
    private $d_type = array();
    private $d_img = array();
   
    function mFetchToArray(){

        while ($r = mysqli_fetch_assoc($this->res_obj)) {
            array_push($this->d_id, $r['dest_id']);
            array_push($this->d_name, $r['dest_name']);
            array_push($this->d_desc, $r['dest_desc']);
            array_push($this->d_loc, $r['dest_addr']);
            array_push($this->d_bs, $r['dest_bus_stand']);
            array_push($this->d_off, $r['dest_offDay']);
            array_push($this->d_on, $r['dest_onDay']);
            array_push($this->d_ticket, $r['dest_ticket_price']);
            array_push($this->d_type, $r['dest_type']);
            array_push($this->d_img, $r['dest_img']);
        }
    }
    function setArrayIndex($ind){
        $this->ARRAY_INDEX = $ind;        
    }
    function getArrayIndex(){
        return  $this->ARRAY_INDEX ;
    }
    function get_d_id_array(){
        return  $this->d_id ;
    }
    function get_d_name_array(){
        return  $this->d_name ;
    }
    function get_d_desc_array(){
        return  $this->d_desc ;
    }
    function get_d_loc_array(){
        return  $this->d_loc ;
    }
    function get_d_bs_array(){
        return  $this->d_bs ;
    }
    function get_d_off_array(){
        return  $this->d_off ;
    }
    function get_d_on_array(){
        return  $this->d_on ;
    }
    function get_d_ticket_array(){
        return  $this->d_ticket ;
    }
    function get_d_type_array(){
        return  $this->d_type;
    }
    function get_d_img_array(){
        return  $this->d_img ;
    }
}

class getSlideData{
    // echo $d_name[0];
}


?>
