<?php
include "Main.php";

//class for deleting apartment from list
class Delete extends Main{

    public $id;

    //initiate class Delete
    public function __construct($id)
    {
        return $this->delete_apartment($id);
    }

    //delete apartment and its edit and delete token info
    public function delete_apartment($apartment_id){

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
}

//call main class
$main = new Main();

//get passed json data from form front end
$info = json_decode(file_get_contents("php://input"));
$apartment_id = $main->real_escape_string($info->id);

//execute class
$delete = new Delete($apartment_id);