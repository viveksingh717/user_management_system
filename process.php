<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once './php/session.php';
require 'config/vendor/autoload.php';

$users = new Auth();
$mail = new PHPMailer(true);

if (isset($_POST['action']) && $_POST['action'] == 'add_post') {
    $title = $users->input_validator($_POST['title']);
    $posts = $users->input_validator($_POST['post']);
    $uid = $user_id;

    $users->add_post($uid, $title, $posts);
    $users->notification($user_id, 'Admin', 'New post added');
}

if (isset($_POST['task']) && $_POST['task'] == 'display_data') {
    $uid = $user_id;
    $posts = $users->get_posts($uid);
    $output = '';

    if (!empty($posts)) {
        $output .= 
        '<div class="table-responsive"> 
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Post</th>
                        <th>Action</th>
                    </tr>
                </thead>
            <tbody>';
        $id = 1;
        foreach ($posts as $post) {
            $output .= '<tr>
            <th>'.$id.'</th>
            <td>'.$post['title'].'</td>
            <td>'.substr($post['post'], 0,75).'...</td>
            <td>
                <a href="javascript:void(0)" class="text-success bg-gradient infoBtn" title="View Details" id="'.$post['id'].'"><i class="fa-solid fa-info-circle fa-lg"></i></a>&nbsp;

                <a href="javascript:void(0)" class="text-info editBtn" title="Edit Details" id="'.$post['id'].'"><i class="fa-solid fa-pencil fa-lg" data-bs-toggle="modal" data-bs-target="#editModal"></i></a>&nbsp;

                <a href="javascript:void(0)" class="text-danger deleteBtn" title="Remove Details" id="'.$post['id'].'"><i class="fa-solid fa-trash fa-lg"></i></a>
            </td>
            </tr>'; 
            $id++;
        }
        $output .= '</tbody></table></div>';

        echo $output;   
    }else{
        echo '<strong class="text-danger text-center">No data found</strong>';
    }
}

if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];

    $row = $users->get_editData($edit_id);

    echo json_encode($row);
}

if (isset($_POST['action']) && $_POST['action'] == 'updateForm') {
    $id = $users->input_validator($_POST['id']);
    $title = $users->input_validator($_POST['title']);
    $post = $users->input_validator($_POST['post']);

    $users->updateData($id, $title, $post);
    $users->notification($user_id, 'Admin', 'Post Updated');

}

if (isset($_POST['delete_id'])) {
    $del_id = $users->input_validator($_POST['delete_id']);
    $users->removePost($del_id);
    $users->notification($user_id, 'Admin', 'Post Deleted');
}

if (isset($_POST['view_id'])) {
    $view_id = $_POST['view_id'];

    $row = $users->get_viewData($view_id);

    echo json_encode($row);
}

if (isset($_FILES['photo'])) {
    $id = $user_id;
    $profile_pic = $_FILES['photo'];
    $name = $users->input_validator($_POST['name']);
    $email = $users->input_validator($_POST['email']);
    $gender = $users->input_validator($_POST['gender']);
    $contact = $users->input_validator($_POST['phone']);

    $old_pic = $_POST['oldPhoto'];

    if (isset($profile_pic['name']) && $profile_pic['name'] != '') {
        $newPhoto = 'uploads/'.$profile_pic['name'];
        move_uploaded_file($profile_pic['tmp_name'], $newPhoto);

        if ($old_pic != null) {
            unlink($old_pic);
        }
    }else{
        $newPhoto = $old_pic;
    }

    $users->update_profileData($name,$email,$contact,$gender,$newPhoto,$id);
    $users->notification($user_id, 'Admin', 'profile Updated');

    // echo json_encode($row);
} 

if (isset($_POST['action']) && $_POST['action'] == 'changePass') {
    $id = $user_id;
    $curntPass = $users->input_validator($_POST['password']);
    $newPass = $users->input_validator($_POST['new_pass']);
    $confPass = $users->input_validator($_POST['conf_pass']);

    if ($curntPass == '') {
        echo $users->showMessage('danger', 'Current password not empty');
    }

    if ($newPass != $confPass) {
        echo $users->showMessage('danger', 'Password not matched');
    }

    $res = $users->changePass($newPass,$id);
    $users->notification($user_id, 'Admin', 'Password changed');

    if ($res == true) {
        echo $users->showMessage('success', 'Password changes successfully');
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'verify_email') {
    $email = $user_email;
    $token = $user_token;
    try {
            // $mail->SMTPDebug = 2;  //debugging
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';                
            $mail->SMTPAuth   = true;                                  
            // $mail->Username   = 'vs4092344@gmail.com';                     
            // $mail->Password   = 'vivek777';
            $mail->Username   = Database::USERNAME;                     
            $mail->Password   = Database::PASSWORD;                               
            // $mail->SMTPSecure = 'ssl';   
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         
            $mail->Port       = 465;                           

            //Recipients
            $mail->setFrom(Database::USERNAME, 'Vivek-Admin');
            $mail->addAddress($email);
           
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body = '<h3>Click on the below link to verify your email.</h3>
            <p><a href="http://localhost/user_management/verify_email.php?email='.$email.'">http://localhost/user_management/verify_email.php?email='.$email.'</a></p>
            </br>
            <p> Regards </p>
            <strong>Vivek Coolhunter!</strong>';

            $mail->send();
            echo $users->showMessage('success', 'We have sent you verification link on your registered email-id, please check email.');
        } catch (Exception $e) {
            echo $users->showMessage('danger', 'Something went wrong, please check your email and try again.');
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'send_feedback') {
    $uid = $user_id;
    $sub = $users->input_validator($_POST['subject']);
    $feed = $users->input_validator($_POST['feedBack']);

    $users->sendFeedback($uid,$sub,$feed);
    $users->notification($user_id, 'Admin', 'Send Feedback');
}

if (isset($_POST['action']) && $_POST['action'] == 'getNotify') {
    $uid = $user_id;
    $notifications = $users->fetchNotification($uid);
    $output = '';

    if ($notifications) {
        foreach ($notifications as  $notify) {
            $output .= '<div class="alert alert-danger alert-dismissible fade show"" role="alert">
                            <button type="button" class="btn-close" id="'.$notify['id'].'" data-bs-dismiss="alert"  aria-label="Close"></button>
                            <strong class="alert-heading">New Notification!</strong> 
                            <p class="mb-0">'.$notify['message'].'</p>
                            <p class="mb-0">Reply From Admin</p><hr class="my-2">
                            <small class="mb-0">'.$users->timeFormate($notify['created_at']).'</small>
                        </div>';
        }
        echo $output;
    }else{
        echo '<div class="alert alert-danger">
                No Notification Yet!
            </div>';
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'checkNotify') {
    $uid = $user_id;
    $checkNotification = $users->fetchNotification($uid);
    $totalNotify = count($checkNotification);

    $output = '';

    if ($checkNotification) {
        $output .= '<span class="badge badge-danger">'.$totalNotify.'</span>';

        echo $output;
    }else{
        echo '';
    }
}

if (isset($_POST['notification_id'])) {
    $notification_id = $_POST['notification_id'];
    $removeNotification = $users->removeNotification($notification_id);
}


?>