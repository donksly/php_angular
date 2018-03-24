<?php
error_reporting(E_WARNING);
include "Main.php";
//class for displaying the list of all apartments
class Display extends Main{

    //function that gets all apartments from the database
    public function fetch_all(){
        $sql = "SELECT `id`,`name`,`move_in_date`,`street`,`postal_code`,`town`,`country`,`email`
                FROM `apartments` GROUP BY `id` DESC ";
        $sql_exec = $this->query($sql);
        $output = array();
        while($all = $this->fetch_assoc($sql_exec)){
            $output[] = $all;
        }
        //return result in json format
        return json_encode($output);
    }
}

//execute class
$display = new Display();
echo ($display->fetch_all());