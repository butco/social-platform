<?php

require "config/init.php";
//check if user is logged in. If not then redirect to index
$users->logged_out_redirect();

if (isset($_GET["profile"]) && !empty($_GET["profile"])) {
    //Save all user details into $user object
    $userToView = $users->UserDetails($_GET["profile"]);
    $follow = $users->xFollowsY($_SESSION['user_id'],$_GET['profile']);
}
else {
    header("location:main-page.php");
    exit;
}

//Follow button is pressed
if (isset($_POST['btnToggleFollow'])) {
    if ($users->ToggleFollow($_SESSION['user_id'], $userToView->id)) {
        header("location:main-page.php");
        exit;
    }
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
                        <div class="card-body text-center">
                            <div class="profile-image">
                                <img src="<?php echo $userToView->user_photo; ?>" alt="" srcset="">
                            </div>
                            <div class=""><strong>Full Name: </strong><?php echo $userToView->user_fullname; ?></div>
                            <div class=""><strong>Email: </strong><?php echo $userToView->user_email; ?></div>
                            <div class=""><strong>Registered Date: </strong><?php echo $userToView->user_created_at; ?></div>
                            <div class="buttons">
                                <form action="profile.php?profile=<?php echo $userToView->id; ?>" method="POST">
                                    <button type="submit" class="btn btn-secondary btn-block btn-update"
                                        name="btnToggleFollow"><?= $follow?"UNFOLLOW":"FOLLOW";?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php";?>