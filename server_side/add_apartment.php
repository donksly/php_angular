<?php
include "Main.php";
//call main class
$main = new Main();

//get passed json data from form front end
$info = json_decode(file_get_contents("php://input"));
$time = time();

//check if the passed json is empty
if((count((array)$info))>0){

    //declare variables with the list of specific json items
    $apartment_name = $main->real_escape_string($info->name);
    $move_in_date = $main->real_escape_string($info->move_in_date);
    $street = $main->real_escape_string($info->street);
    $postal_code = $main->real_escape_string($info->postal_code);
    $town = $main->real_escape_string($info->town);
    $country = $main->real_escape_string($info->country);
    $email = $main->real_escape_string($info->email);
    $button_name = $info->btnName;

    //global return variable
    $return_me = "";
    if($button_name = "Save Apartment"){

        //add apartments to database
        $insert = "INSERT INTO `apartments`(`name`,`move_in_date`,`street`,`postal_code`,`town`,`country`,`email`,`created_on`)
        VALUES('$apartment_name','$move_in_date','$street','$postal_code','$town','$country','$email', '$time')";
        if($main->query($insert)){

            //get newly generated tokens for edit and delete
            $update_token = $main->generate_update_token($apartment_name);
            $delete_token = $main->generate_update_token($apartment_name);

            //add apartment edit links
            $main->create_edit_delete_links($main->get_current_apartment_id(),$email,"edit",$update_token);
            $main->create_edit_delete_links($main->get_current_apartment_id(),$email,"delete",$delete_token);

            //send emails
            $message = "Animus added your apartment, to edit set details <a href='$main->db_server/ANGULAR_&_LARAVEL_1/edit.php?token=$update_token' target='_blank'><strong>click here</strong></a> to delete click on
            <a href='$main->db_server/ANGULAR_&_LARAVEL_1/delete.php?token=$delete_token' target='_blank'><strong>delete apartment</strong></a>";
            $send_mail = $main->send_user_email($email,'Apartement Added',$message);

            echo $return_me = "Apartment added successfully and links sent";
        }else{
            echo $return_me = "Error: failure in adding apartment please contact admin!";
        }
    }
    //update apartment from admin
    if($button_name = "Update Details"){
        $id = $info->id;
        $update = "UPDATE `apartments` SET `name`='$apartment_name',`move_in_date`='$move_in_date',`street`='$street',
        `postal_code`='$postal_code',`town`='$town',`country`='$country',`email`='$email',`updated_on`='$time' WHERE `id`='$id'";
        if($main->query($update)){
            $return_me = "Apartment updated successfully";
        }else{
            $return_me = "Error: failure in updating apartment please contact admin!";
        }
        echo ($return_me);
    }

}




