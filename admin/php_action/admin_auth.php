<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin_config.php';

class Admin_Auth extends Database 
{ 
     public function admin_login($user, $password)
    {
        $sql = "SELECT * FROM admin WHERE username = :user AND password = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user'=>$user, 'password'=>$password]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function getusersCount($tablename){
        $sql = "SELECT * FROM $tablename";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rowCount = $stmt->rowCount();

        return $rowCount;
    }

    public function getverifieduserCount($status){
        $sql = "SELECT * FROM users WHERE verified = :status";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['status'=>$status]);
        $rowCount = $stmt->rowCount();

        return $rowCount;
    }

    public function getCount($tablename){
        $sql = "SELECT * FROM $tablename";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rowCount = $stmt->rowCount();

        return $rowCount;
    }

    public function getGenderCount(){
        $sql = "SELECT gender, count(*) as gender_count FROM users WHERE gender != '' GROUP BY gender";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    public function getVerifiedUser(){
        $sql = "SELECT verified, count(*) as verified_users FROM users WHERE verified != '' GROUP BY verified";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    public function website_hits(){
        $sql = "SELECT * FROM website_hits";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function fetchallUser($val){
        $sql = "SELECT * FROM users WHERE deleted_user != $val";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // $stmt->debugDumpParams();
        return $rows;
    }

    public function getUsrData($id){
        $sql = "SELECT * FROM users WHERE id = :id AND deleted_user !=0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function user_action($id, $val){
        $sql = "UPDATE users SET deleted_user = $val WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);

        return true;
    }

    public function fetchallUserPost(){
        $sql = "SELECT posts.*, users.name, users.email FROM posts INNER JOIN users ON posts.uid = users.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        // $stmt->debugDumpParams();
        $rowCount = $stmt->fetchAll(PDO::FETCH_ASSOC);


        return $rowCount;
    }

    public function deletePostByAdmin($id){
        $sql = "DELETE FROM posts WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);

        return true;
    }

    public function fetchFeeds(){
        $sql = "SELECT feedback.*, users.name, users.email FROM feedback INNER JOIN users ON feedback.uid = users.id WHERE replied != 1 ORDER BY feedback.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        // $stmt->debugDumpParams();
        $rowCount = $stmt->fetchAll(PDO::FETCH_ASSOC);


        return $rowCount;
    }

    public function sendFeedback($usrId, $msg){
        $sql = "INSERT INTO `notification`(`uid`, `user_type`, `message`) VALUES (:usrId, 'User', :msg)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['usrId'=>$usrId, 'msg'=>$msg]);

        return true;
    }

    public function updateReplied($id){
        $sql = "UPDATE feedback SET replied = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);

        return true;
    }

    public function getNotifications(){
        $sql = "SELECT notification.*, users.name, users.email FROM notification INNER JOIN users ON notification.uid = users.id  ORDER BY notification.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        // $stmt->debugDumpParams();
        $rowCount = $stmt->fetchAll(PDO::FETCH_ASSOC);


        return $rowCount;
    }

    public function deleteNotificationAdmin($id){
        $sql = "DELETE FROM `notification` WHERE id = :id AND user_type = 'Admin'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        
        return true;
    }

    public function exportUsers(){
        $sql = "SELECT * FROM users ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

}



?>