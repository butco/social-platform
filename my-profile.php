<?php

require "config/init.php";
//check if user is logged in. If not then redirect to index
$users->logged_out_redirect();

$profilePhotoName = "";
$newEmail = "";
$newFullName = "";
$newPassword = "";
$newProfilePhoto = "";

$edit_errors = null;
$edit_success = null;

//Save all user details into $user object
$user = $users->UserDetails($_SESSION["user_id"]);

//Update button is pressed
if (isset($_POST['btnUpdate'])) {
    //check if values changed
    if (empty($_POST['inputFullName']) || empty($_POST['inputEmail'])) {
        $edit_errors = "Please fill in your full name and email address!";
        $_SESSION["msg_error"] = $edit_errors;
    } else {
        if (sanitise_inputs($_POST['inputFullName']) !== $user->user_fullname) {
            $newFullName = sanitise_inputs($_POST['inputFullName']);
        } else {
            $newFullName = $user->user_fullname;
        }
        if (sanitise_inputs($_POST['inputEmail']) !== $user->user_email) {
            $newEmail = sanitise_inputs($_POST['inputEmail']);
        } else {
            $newEmail = $user->user_email;
        }
        if (empty($_POST['inputPassword'])) {
            $newPassword = $user->user_password;
        } else {
            $newPassword = password_hash($_POST['inputPassword'], PASSWORD_DEFAULT);
        }
        if (!empty($_FILES['profileImage']['name'])) {
            $profilePhotoName = $_FILES['profileImage']['name'];
            $target = "assets/images/users/" . $profilePhotoName;
            $imageFileType = strtolower(pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION));
            if ($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType !== "jpeg"
                && $imageFileType !== "gif") {
                $edit_errors .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
                $_SESSION["msg_error"] = $edit_errors;
                $newProfilePhoto = $user->user_photo;
            }
            if (filesize($_FILES['profileImage']['tmp_name']) > 1000000) {
                $edit_errors .= "Sorry, your file is too large! ";
                $_SESSION["msg_error"] = $edit_errors;
                $newProfilePhoto = $user->user_photo;
            }
            if (!file_exists($target) && empty($edit_errors)) {
                move_uploaded_file($_FILES['profileImage']['tmp_name'], $target);
                $newProfilePhoto = $target;
            } else {
                $newProfilePhoto = $target;
            }
            //
        } else {
            $_SESSION["msg_error"] = $edit_errors;
            $newProfilePhoto = $user->user_photo;
        }

        //do the update in the DB
        if (empty($_SESSION["msg_error"])) {
            if ($users->Update($user->id, $newEmail, $newPassword, $newFullName, $newProfilePhoto, $newGroupId, $newActive)) {
                $edit_success = "Update successfully!";
                $_SESSION["msg_success"] = $edit_success;
                header("location:my-profile.php?profile=" . $user->id);
                exit;
            }
        }
    }
}

//DELETE button is pressed
if (isset($_POST["btnDelete"])) {
    $userToDelete = $users->UserDetails($_SESSION["userToDelete"]);
    if ($users->DeleteUser($userToDelete->id)) {
        $_SESSION["msg_success"] = "The user <strong>" . $userToDelete->user_fullname . "</strong> was deleted!";
    } else {
        $_SESSION["msg_error"] = "The user <strong>" . $userToDelete->user_fullname . "</strong> was not deleted!";
    }
    header("location:index.php");
}

include "includes/header.php";
?>
<div class="container-fluid container-bg container-full-height">
    <div class="row">
        <?php include "includes/sidebar.php";?>
        <div class="col-lg-10 col-md-9 col-sm-8 col-xs-1">
            <div class="row edit-profile">
                <div class="col-lg-6 col-md-8 m-auto">
                    <div class="card edit-profile-card m-auto">
                        <div class="card-title text-center mt-5">
                            <h3>Update Details</h3>
                        </div>
                        <div class="card-body">
                            <?php if (isset($_SESSION["msg_error"]) && !empty($_SESSION["msg_error"])): ?>
                            <div class="alert alert-danger" role="alert">
                                <strong><?php echo $_SESSION["msg_error"];unset($_SESSION["msg_error"]); ?></strong>
                            </div>
                            <?php endif;?>
                            <?php if (isset($_SESSION["msg_success"]) && !empty($_SESSION["msg_success"])): ?>
                            <div class="alert alert-success" role="alert">
                                <strong><?php echo $_SESSION["msg_success"];unset($_SESSION["msg_success"]); ?></strong>
                            </div>
                            <?php endif;?>
                            <form action="my-profile.php?profile=<?php echo $user->id; ?>" method="POST"
                                enctype="multipart/form-data">
                                <div class="edit-profile-photo">
                                    <div class="form-group">
                                        <img src="<?php echo (isset($_POST["profileImage"]) ? $_POST["profileImage"] : $user->user_photo); ?>"
                                            alt="" id="profilePhoto" class="card-img-top mb-3" onclick="triggerClick()">
                                        <input type="file" name="profileImage" onchange="previewProfilePhoto(this)"
                                            id="profileImage" style="display:none;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fullNameInput">Full Name</label>
                                    <input type="text" class="form-control" id="fullNameInput" autocomplete="off"
                                        autofocus name="inputFullName"
                                        value="<?php echo (isset($_POST["inputFullName"]) ? $_POST["inputFullName"] : $user->user_fullname); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="emailInput">Email address</label>
                                    <input type="email" class="form-control" id="emailInput" autocomplete="off"
                                        name="inputEmail" aria-describedby="emailHelp"
                                        value="<?php echo (isset($_POST["inputEmail"]) ? $_POST["inputEmail"] : $user->user_email); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="passInput">Password</label>
                                    <input type="password" class="form-control" name="inputPassword" id="passInput">
                                </div>
                                
                                <div class="buttons">
                                    <button type="submit" class="btn btn-secondary btn-block btn-update"
                                        name="btnUpdate">UPDATE</button>
                                    
                                    <button type="submit" class="btn btn-secondary btn-block btn-delete"
                                        name="btnDelete">DELETE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php";?>