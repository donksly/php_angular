<?php
include "Main.php";
//class for deleting single apartment
class DeleteSingle extends Main{

    public $token;

    //initialise class DeleteSingle
    public function __construct($token)
    {
        return $this->delete_apartment($token);
    }

    //function for apartment deletion
    public function delete_apartment($token){

        $apartment_id = $this->fetch_single($token);

        $delete_sql = "DELETE FROM `apartments` WHERE `id`='$apartment_id'";
        $this->query($delete_sql);

        $delete_sql_i = "DELETE FROM `update_delete_requests` WHERE `apartment_id`='$apartment_id'";
        if($this->query($delete_sql_i)){
            $return_value = "Apartment deleted successfully";
        }else{
            $return_value = "Error: please contact admin!";
        }
        return $return_value;
    }

    //get apartment id from token
    public function fetch_single($token){
        $sql = "SELECT `apartment_id` FROM `update_delete_requests` WHERE `token`='$token'";
        $sql_exec = $this->query($sql);
        $fetch_id = $this->fetch_assoc($sql_exec);
        return ($fetch_id['apartment_id']);
    }
}
//call main class
$main = new Main();

//get passed json data from form front end
$info = json_decode(file_get_contents("php://input"));
$token = substr($main->real_escape_string($info->token),7);

//execute class
$delete = new DeleteSingle($token);