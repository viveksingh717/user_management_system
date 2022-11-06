<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

class Auth extends Database 
{
    public function register($name, $email, $password)
    {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];

        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        $arr = $stmt->execute($data);

        return true;
    } 
    
    public function check_user_exist($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email AND password = :password AND deleted_user = !0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email, 'password'=>$password]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function currentUserData($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email AND deleted_user = !0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function update_token($token, $email)
    {
        $sql = "UPDATE users SET token = :token, token_expire = DATE_ADD(NOW(),INTERVAL 10 MINUTE) WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['token'=>$token, 'email'=>$email]);

        return true;
    }

    public function reset_pass($email, $token){
        $sql = "SELECT * FROM users WHERE email=:email AND token = :token AND token != '' AND token_expire > NOW() AND deleted_user != 0";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email, 'token'=>$token]);
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function update_password($email, $pass)
    {
        $sql = "UPDATE users SET token= '', password = :pass WHERE email=:email AND deleted_user !=0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email, 'pass'=>$pass]);

        return true;
    }

    public function add_post($uid, $title, $post)
    {
        $data = [
            'uid' => $uid,
            'title' => $title,
            'post' => $post,
        ];

        $sql = "INSERT INTO posts (uid, title, post) VALUES (:uid, :title, :post)";
        $stmt = $this->conn->prepare($sql);
        $arr = $stmt->execute($data);

        return true;
    }
    
    public function get_posts($uid){
        $sql = "SELECT * FROM posts WHERE uid = :uid ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid]);
        $rowsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rowsData;
    }

    public function get_editData($id){
        $sql = "SELECT * FROM posts WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $rowsData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $rowsData;
    }

    public function updateData($id, $title, $post)
    {
        $sql = "UPDATE posts SET title= :title, post = :post, updated_at = NOW() WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['title'=>$title, 'post'=>$post, 'id'=>$id]);

        return true;
    }

    public function removePost($id){
        $sql = "DELETE FROM `posts` WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);

        return true;
    }

    public function get_viewData($id){
        $sql = "SELECT * FROM posts WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $rowsData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $rowsData;
    }

    public function update_profileData($name,$email,$phone,$gender,$photo,$id)
    {
        $sql = "UPDATE `users` SET `name`= :name,`email`=:email,`phone`=:phone,`gender`=:gender,`photo`=:photo WHERE id=:id AND deleted_user != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['name'=>$name, 'email'=>$email, 'phone'=>$phone, 'gender'=>$gender, 'photo'=>$photo, 'id'=>$id]);

        // $stmt->debugDumpParams();
        return true;
    }

    public function changePass($new_pass,$id)
    {
        $sql = "UPDATE `users` SET `password`= :new_pass WHERE id=:id AND deleted_user != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['new_pass'=>$new_pass, 'id'=>$id]);

        // $stmt->debugDumpParams();
        return true;
    }

    public function verify_user($email){
        $sql = "UPDATE users SET verified = 1 WHERE email = :email AND deleted_user != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);

        return true;
    }

    public function sendFeedback($uid, $sub, $feed){
        $sql = "INSERT INTO `feedback`(`uid`, `subject`, `feedback`) VALUES (:uid, :sub, :feed)";
        $stmt =$this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid, 'sub'=>$sub, 'feed'=>$feed]);

        $stmt->debugDumpParams();

        return true;
    }

    public function notification($uid, $type, $msg){
        $sql = "INSERT INTO `notification`(`uid`, `user_type`, `message`) VALUES (:uid, :type, :msg)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid, 'type'=>$type, 'msg'=>$msg]);

        return true;
    }

    public function fetchNotification($uid){
        $sql = "SELECT * FROM `notification` WHERE user_type = 'User' AND uid = :uid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid]);
        $rowsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rowsData;
    }

    public function removeNotification($id){
        $sql = "DELETE FROM `notification` WHERE user_type = 'User' AND id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        
        return true;
    }
}



?>