<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Class Database 
{
    const USERNAME = 'vs4092344@gmail.com';
    const PASSWORD = 'vivek777';

    private $host = "localhost";
    private $user = "vivek";
    private $password = "Vivek@777";
    private $db_name = "db_user_system";

    public $conn;

    public function __construct(){
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->user,$this->password);
        } catch (PDOException $e) {
            echo 'Connection failed : '. $e->getMessage();
        }

        return $this->conn;
    }

    public function input_validator($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    public function showMessage($type, $message)
    {
        return '<div class="alert alert-'.$type.'" role="alert">
                   <strong>'.$message.'</strong>
                </div>'; 
    }

    // show time formate in ago 

    public function timeFormate($timestamp)
    {
        date_default_timezone_set('Asia/Kolkata');

        if (isset($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        $time = time() - $timestamp;

        switch ($time) {
            //for second
            case $time <= 60:
                return 'Just Now';
                break;
            //for minute    
            case $time >= 60 && $time < 3600:
                return (round($time/60) == 1) ? '-a minute ago' : round($time/60).'-minute ago';
                break;
            //for hour     
            case $time >= 3600 && $time < 86400:
                return (round($time/3600) == 1) ? '-an hour ago' : round($time/3600).'-hour ago';
                break;
            //for days     
            case $time >= 86400 && $time < 604800:
                return (round($time/86400) == 1) ? '-a day ago' : round($time/86400).'-days ago';
                break;  
            //for week     
            case $time >= 604800 && $time < 2600640:
                return (round($time/604800) == 1) ? '-a week ago' : round($time/604800).'-weeks ago';
                break;  
            //for month     
            case $time >= 2600640 && $time < 31207680:
                return (round($time/2600640) == 1) ? '-a month ago' : round($time/2600640).'-months ago';
                break; 
            //for year     
            case $time >= 31207680:
                return (round($time/31207680) == 1) ? '-a yesr ago' : round($time/31207680).'-years ago';
                break;                    
            
        }
    }

}

$obj = new Database();


?>