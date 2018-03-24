<?php
error_reporting(E_WARNING);
include "Main.php";
//class for validating sent token
class TokenValidate extends Main{

    //global variables
    public $token;
    public $token_type;

    //function that authenticates token
    public function validate_token($t,$type){
        $sql = "SELECT `id` FROM `update_delete_requests` WHERE `token`='$t' AND `request_type`='$type'";
        $sql_exec = $this->query($sql);
        return $this->num_rows($sql_exec);
    }

    //get details of apartment that corresponds to the token
    public function fetch_single($token){
        $sql = "SELECT `apartments`.`id`,`apartments`.`name`,`apartments`.`move_in_date`,`apartments`.`street`,`apartments`.`postal_code`,
        `apartments`.`town`,`apartments`.`country`,`apartments`.`email`
                FROM `apartments` INNER JOIN `update_delete_requests` ON `apartments`.`id`=`update_delete_requests`.`apartment_id`
                WHERE `update_delete_requests`.`token`='$token'";
        $sql_exec = $this->query($sql);
        $output = array();
        while($all = $this->fetch_assoc($sql_exec)){
            $output[] = $all;
        }
        return json_encode($output);
    }

}
//call main class
$main = new Main();

//get passed json data from form front end
$info = json_decode(file_get_contents("php://input"));
$token = substr($main->real_escape_string($info->token),7);
$type = $main->real_escape_string($info->type);

//execute class
$validate = new TokenValidate($token, $type);
if($validate->validate_token($token,$type)==0){
    //on invalid token
    echo 0;
}else{
    //on valid token
    echo $validate->fetch_single($token);
}
