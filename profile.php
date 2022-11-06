<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'php/header.php';

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mt-4 shadow-lg p-3 mb-4">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="profile" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</button>

                        <button class="nav-link" id="nav-edit-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-edit-profile" type="button" role="tab" aria-controls="nav-edit-profile" aria-selected="false">Edit-Profile</button>

                        <button class="nav-link" id="nav-change-password-tab" data-bs-toggle="tab" data-bs-target="#nav-change-password" type="button" role="tab" aria-controls="nav-change-password" aria-selected="false">Change Password</button>
                    </div>
                </nav>

                <div class="card-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="card-deck">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid grey"><b>User-ID : </b><?= $user_id; ?></p>
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid grey"><b>User-Name : </b><?= $user_name; ?></p>
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid grey"><b>User-Email : </b><?= $user_email; ?></p>
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid grey"><b>User-Contact : </b><?= $user_contact; ?></p>
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid grey"><b>Gender : </b><?= $user_gender; ?></p>
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid grey"><b>DOB : </b><?= $user_dob; ?></p>
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid grey"><b>Register Date : </b><?= $dateFormate; ?></p>
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid grey"><b>Email-Verify : </b><?= $user_verified; ?>

                                            <?php 
                                                if ($user_verified == 'Not Verified') : ?>
                                                    <a href="#" id="email_verify" class="float-right">Verify Now</a>
                                            
                                            <?php endif; ?>
                                        
                                            </p>
                                            <div class="text-danger lead" id="msgSent"></div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-5"> 
                                    <div class="card align-self-center">
                                        <?php 
                                        if (!$user_photo) :?>
                                            <img src="assets/images/PICA.jpg" class="img-thumbnail img-fluid" alt="User-Logo">
                                        <?php else :  ?>
                                            <img src="<?= $user_photo; ?>" class="img-thumbnail img-fluid" alt="User-Logo">
                                        <?php endif ; ?>   
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-edit-profile" role="tabpanel" aria-labelledby="nav-edit-profile-tab">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="card align-self-center">
                                        <?php 
                                            if (!$user_photo) :?>
                                            <img src="assets/images/PICA.jpg" class="img-thumbnail img-fluid" alt="User-Logo">
                                        <?php else :  ?>
                                            <img src="<?= $user_photo; ?>" class="img-thumbnail img-fluid" alt="User-Logo">
                                        <?php endif ; ?>                  
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="text-center text-muted">User Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" enctype="multipart/form-data" id="update_profile_form">
                                                <div class="form-group mb-3">
                                                    <label class="fw-bold">Name</label>
                                                    <input type="text" class="form-control" name="name" value="<?= $user_name?>">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="fw-bold">Email Address</label>
                                                    <input type="email" class="form-control" name="email" value="<?= $user_email?>">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="fw-bold">Contact</label>
                                                    <input type="text" class="form-control" name="phone" value="<?= $user_contact?>">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="fw-bold">Gender</label>
                                                    <select class="form-control" id="gender" name="gender">
                                                        <option value="" disabled <?php if ($user_gender == null) {
                                                            echo 'selected';
                                                        } ?>>--Select--</option>
                                                        <option value="Male" <?php if ($user_gender == 'male') {
                                                            echo 'selected';
                                                        } ?>>Male</option>
                                                        <option value="Female" <?php if ($user_gender == 'female') {
                                                            echo 'selected';
                                                        } ?>>Female</option>
                                                    </select>
                                                </div> 
                                                <div class="form-group mb-3">
                                                    <label class="fw-bold">Photo</label>
                                                    <input type="file" class="form-control"  name="photo">
                                                </div>
                                                <input type="hidden" class="form-control" name="oldPhoto" value="<?= $user_photo?>">

                                                <div class="form-group mb-3">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary bg-gradient" id="update_profile">Update Profile</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-change-password" role="tabpanel" aria-labelledby="nav-change-password-tab">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="card">
                                        <div class="card-header bg-success bg-gradient text-light text-center lead">Change Your Password</div>
                                        <div class="card-body">
                                            <p class="text-center lead mt-2" id="successMsg"></p>
                                            <form method="post" class="p-3" id="changePass_form"> 
                                                <div class="form-group mb-3">
                                                    <label class="fw-bold">Enter Your Current Password</label>
                                                    <input type="password" class="form-control" name="password" id="currPass" placeholder="Enter Your password" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="fw-bold">Enter Your New Password</label>
                                                    <input type="password" class="form-control" name="new_pass" id="newPass"  placeholder="Enter New Password" required minlength="5">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="fw-bold">Confirm Password</label>
                                                    <input type="password" class="form-control" name="conf_pass" id="conPass" placeholder="Confirm Password" required minlength="5">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <div class="d-grid">
                                                        <button class="btn btn-danger bg-gradient" type="button" id="update_pass">Update Password</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="text-center text-danger lead mt-2" id="errorBox"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                <img src="assets/images/tech.png" class="img-fluid" alt="Change-password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 

require_once 'php/footer.php';

?>