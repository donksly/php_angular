<?php
error_reporting(E_WARNING);
include "Main.php";

//call main class
$main = new Main();

//get passed json data from form front end
$info = json_decode(file_get_contents("php://input"));

//get php time
$time = time();

//check if the passed json is empty
if((count((array)$info))>0){

    //declare variables with the list of specific json items
    $apartment_id = $main->real_escape_string($info->id);
    $apartment_name = $main->real_escape_string($info->name);
    $move_in_date = $main->real_escape_string($info->move_in_date);
    $street = $main->real_escape_string($info->street);
    $postal_code = $main->real_escape_string($info->postal_code);
    $town = $main->real_escape_string($info->town);
    $country = $main->real_escape_string($info->country);
    $email = $main->real_escape_string($info->email);
    $return_me = "";

    //execute if request is to update
    if($button_name = "Update Details"){
        $id = $info->id;

        //update apartment details
        $update = "UPDATE `apartments` SET `name`='$apartment_name',`move_in_date`='$move_in_date',`street`='$street',
        `postal_code`='$postal_code',`town`='$town',`country`='$country',`email`='$email',`updated_on`='$time' WHERE `id`='$id'";

        //check if query has executed successfully
        if($main->query($update)){
            $return_me = "Apartment updated successfully";
        }else{
            $return_me = "Error: failure in updating apartment please contact admin!";
        }
        echo ($return_me);
    }

}




