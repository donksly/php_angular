<?php

//Class main has all the global functions and variables
class Main{

    //list of global variables that include database connections
    public $db_server = '127.0.0.1';
    public $db_user = 'root';
    public $db_user_password = '*********';
    public $db_table = 'angular_php';
    public $project_name = "animus_angular_php";

    /*******begin mysqli functions********/

    public function real_escape_string($string)
    {
        $connection = $this->connect();
        return mysqli_real_escape_string($connection, $string);
    }

    public function connect()
    {
        $db_server = $this->db_server;
        $db_user = $this->db_user;
        $db_user_password = $this->db_user_password;
        $table = $this->db_table;

        $mysqli = mysqli_init();
        mysqli_options($mysqli, MYSQLI_READ_DEFAULT_GROUP, "max_allowed_packet=900M");
        mysqli_real_connect($mysqli, $db_server, $db_user, $db_user_password, $table);

        return $mysqli;

    }

    public function query($query)
    {
        $connection = $this->connect();
        return mysqli_query($connection, $query);
    }

    public function num_rows($resource)
    {
        return mysqli_num_rows($resource);
    }

    public function fetch_assoc($resource)
    {
        return mysqli_fetch_assoc($resource);
    }

    public function fetch_array($resource)
    {
        return mysqli_fetch_array($resource);
    }

    /*******end of mysqli functions********/

    //date formating function from time()
    public function generate_date_and_seconds($new_date){
        $the_date = (date('l F jS, Y - g:ia',$new_date));
        return $the_date;
    }

    //function for generating unique tokens for delete actions
    public function generate_delete_token($apartment_name){
        $token = md5($apartment_name.time().rand(1,4654));
        return $token;
    }

    //function for generating unique tokens for update actions
    public function generate_update_token($apartment_name){
        $token = md5($apartment_name.time().rand(1,4654)."upDateToken");
        return $token;
    }

    //function for sending email
    public function send_user_email($to,$subject,$message){

        $headers = 'From: Animus Gmbh' . "\r\n" .
            'Reply-To: '."no-reply@animus.com". "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        return mail($to, $subject, $message,$headers);

    }

    //get the recently/currently created apartment id
    public function get_current_apartment_id(){
        $sql = "SELECT `id` FROM `apartments` GROUP BY `id` DESC LIMIT 1";
        $sql_exec = $this->query($sql);
        if($this->num_rows($sql_exec)==0){
            $current_id = 1;
        }else{
            $current_id = ($this->fetch_assoc($sql_exec)['id']);
        }
        return $current_id;
    }

    //generate edit and delete links to be sent via email
    function create_edit_delete_links($apartment_id,$email,$request_type,$token){
        $time = time();
        $insert = "INSERT INTO `update_delete_requests`(`apartment_id`,`email`,`request_type`,`token`,`created_on`)
        VALUES('$apartment_id','$email','$request_type','$token','$time')";
        $sql_exec = $this->query($insert);
        return $sql_exec;
    }
}