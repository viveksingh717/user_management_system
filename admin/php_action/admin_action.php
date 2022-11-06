<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once 'admin_auth.php';

$admin_process = new Admin_Auth();

if (isset($_POST['action']) && $_POST['action'] == 'adminLogin') {
    $admin_user = $admin_process->input_validator($_POST['username']);
    $pass = $admin_process->input_validator($_POST['password']);
    
    $admin_logged = $admin_process->admin_login($admin_user, $pass);

    if ($admin_logged != null) {
        echo 'admin_login';
        $_SESSION['admin_name'] = $admin_logged['username'];

    }else{
        echo $admin_process->showMessage('danger', 'Something went wrong!');
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'fetchusr') {
    $ouput = '';
    $usrdata = $admin_process->fetchallUser(0);
    
    if (!empty($usrdata)) {
        $output = '';
        $id=1;

        $output .= '<div class="table-responsive"> <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Gender</th>
                                <th>Image</th>
                                <th>Is-Verified</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <tbody>';
                    foreach ($usrdata as $row) { 
                        if ($row['photo']) {
                            $path = $row['photo'];
                        }else{
                            $path = 'assets/images/PICA.jpg';
                        }
                        $output .= '<tr>
                                        <th>'.$id.'</th>
                                        <td>'.$row['name'].'</td>
                                        <td>'.$row['email'].'</td>
                                        <td>'.$row['phone'].'</td>
                                        <td>'.$row['gender'].'</td>
                                        <td><img src="../'.$path.'" class="rounded-circle" width="40px"></td>
                                        <td>'.$row['verified'].'</td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-success viewBtn" title="View Details" id="'.$row['id'].'"><i class="fa-solid fa-info-circle fa-lg" data-toggle="modal" data-target="#showModal"></i></a>&nbsp;

                                            <a href="javascript:void(0)" class="text-danger deleteBtn" title="Remove Details" id="'.$row['id'].'"><i class="fa-solid fa-trash fa-lg"></i></a>
                                        </td>
                                    </tr>';
                        $id++;
                    }

                    $output .= '</tbody></table> </div>';
                    echo $output;
                        
    }else{
        echo '<strong class="text-danger text-center">No data found</strong>';
    }
}

if (isset($_POST['viewId'])) {
    $id = $_POST['viewId'];
    $usrData = $admin_process->getUsrData($id);

    echo json_encode($usrData);
}

if (isset($_POST['delete_id'])) {
    $del_id = $_POST['delete_id'];

    $admin_process->user_action($del_id, 0);
    // $users->notification($user_id, 'Admin', 'Post Deleted');
}

if (isset($_POST['action']) && $_POST['action'] == 'getDeletedUsr') {
    $ouput = '';
    $deleteduser = $admin_process->fetchallUser(1);
    
    if (!empty($deleteduser)) {
        $output = '';
        $id=1;

        $output .= '<div class="table-responsive"><table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Image</th>
                                <th>Is-Verified</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <tbody>';
                    foreach ($deleteduser as $row) { 
                        if ($row['photo']) {
                            $path = '../'.$row['photo'];
                        }else{
                            $path = '../assets/images/PICA.jpg';
                        }
                        $output .= '<tr>
                                        <th>'.$id.'</th>
                                        <td>'.$row['name'].'</td>
                                        <td>'.$row['email'].'</td>
                                        <td>'.$row['phone'].'</td>
                                        <td><img src="'.$path.'" class="rounded-circle" width="40px"></td>
                                        <td>'.$row['verified'].'</td>
                                        <td>
                                            <button class="btn btn-secondary  bg-gradient restoreBtn fw-bold" id="'.$row['id'].'"> Restore </button>
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

if (isset($_POST['restore_id'])) {
    $restore_id = $_POST['restore_id'];

    $admin_process->user_action($restore_id, 1);
    // $users->notification($user_id, 'Admin', 'Post Deleted');
}

if (isset($_POST['action']) && $_POST['action'] == 'fetchPost') {
    $ouput = '';
    $posts = $admin_process->fetchallUserPost();

    // echo '<pre>';print_r($posts);echo '</pre>';exit();
    
    if (!empty($posts)) {
        $output = '';
        $id=1;

        $output .= '<div class="table-responsive"><table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Title</th>
                                <th>Post</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <tbody>';
                    foreach ($posts as $row) { 
                        $output .= '<tr>
                                        <th>'.$id.'</th>
                                        <td>'.$row['name'].'</td>
                                        <td>'.$row['email'].'</td>
                                        <td>'.$row['title'].'</td>
                                        <td>'.$row['post'].'</td>
                                        <td>'.$row['created_at'].'</td>
                                        
                                        <td>
                                        <a href="javascript:void(0)" class="text-danger deletePost" title="Remove Details" id="'.$row['id'].'"><i class="fa-solid fa-trash fa-lg"></i></a>
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

if (isset($_POST['delete_id'])) {
    $del_id = $_POST['delete_id'];

    $admin_process->deletePostByAdmin($del_id);
    // $users->notification($user_id, 'Admin', 'Post Deleted');
}

if (isset($_POST['action']) && $_POST['action'] == 'feeds') {
    $ouput = '';
    $feeds = $admin_process->fetchFeeds();

    // echo '<pre>';print_r($posts);echo '</pre>';exit();
    
    if (!empty($feeds)) {
        $output = '';
        $id=1;

        $output .= '<div class="table-responsive"><table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Feedback</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <tbody>';
                    foreach ($feeds as $row) { 
                        $output .= '<tr>
                                        <th>'.$id.'</th>
                                        <td>'.$row['name'].'</td>
                                        <td>'.$row['email'].'</td>
                                        <td>'.$row['subject'].'</td>
                                        <td>'.$row['feedback'].'</td>
                                        <td>'.$row['created_at'].'</td>
                                        
                                        <td>
                                            <a href="javascript:void(0)" class="text-danger reply" title="Reply" usr_id="'.$row['uid'].'" feed_id="'.$row['id'].'"><i class="fa-solid fa-reply fa-lg" data-toggle="modal" data-target="#feedbackModal"></i></a>
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

if (isset($_POST['feed_id']) && isset($_POST['usr_id'])) {
    $feedId = $admin_process->input_validator($_POST['feed_id']);
    $usrId = $admin_process->input_validator($_POST['usr_id']);
    $message = $admin_process->input_validator($_POST['feedMessage']);

    $admin_process->sendFeedback($usrId, $message);
    $admin_process->updateReplied($feedId);
}

if (isset($_POST['action']) && ($_POST['action'] == 'notification')) {
    $notification = $admin_process->getNotifications();
    $output = '';

    if ($notification) {
        foreach ($notification as  $notify) {
            $output .= '<div class="alert alert-dark alert-dismissible fade show"" role="alert">
                            <button type="button" class="btn-close" id="'.$notify['id'].'" data-bs-dismiss="alert"  aria-label="Close"></button>
                            <strong class="alert-heading">New Notification!</strong> 
                            <p class="mb-0">'.$notify['message'].' by '.$notify['name'].'</p>
                            <p class="mb-0">'.$notify['email'].'</p><hr class="my-2">
                            <small class="mb-0">'.$admin_process->timeFormate($notify['created_at']).'</small>
                        </div>';
        }
        echo $output;
    }else{
        echo '<div class="alert alert-danger">
                No Notification Yet!
            </div>';
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'notificationAlert') {
    // $uid = $user_id;
    $checkNotification = $admin_process->getNotifications();
    $totalNotify = count($checkNotification);

    $output = '';

    if ($checkNotification) {
        $output .= '<span class="badge badge-danger">'.$totalNotify.'</span>';

        echo $output;
    }else{
        echo '';
    }
}

if (isset($_POST['notificationId'])) {
    $notificationId = $_POST['notificationId'];
    $removeNotification = $admin_process->deleteNotificationAdmin($notificationId);
}

if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    header("Content-Disposition: attachment; filename=users.xlsx"); 
    header("Content-Type: application/vivek.ms-excel"); 
    // header("Pragma : no-cache");
    // header("Expires : 0");

    $data = $admin_process->exportUsers();    
        echo '<table align=center>';
        echo '<tr>
                <th scope="col">Sr.</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Contact</th>
                <th scope="col">Gender</th>
                <th scope="col">DOB </th>
                <th scope="col">Is-Verified</th>
                <th scope="col">Created At</th>
            </tr>';
            $i=1;
            foreach ($data as $item) {
                echo '<tr>
                        <th scope="row">'.$i.'</th>
                        <td>'.$item['name'].'</td>
                        <td>'.$item['email'].'</td>
                        <td>'.$item['phone'].'</td>
                        <td>'.$item['gender'].'</td>
                        <td>'.$item['dob'].'</td>
                        <td>'.$item['verified'].'</td>
                        <td>'.$item['created_at'].'</td>
                    </tr>';
                    $i++;
            }
        echo '</table>';
    
}





?>