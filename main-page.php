<?php

require "config/init.php";
//check if user is logged in. If not then redirect to index
$users->logged_out_redirect();

//Save all user details into $user object
$user = $users->UserDetails($_SESSION['user_id']);

$allUsers = $users->GetAllUsers($_SESSION['user_id']);

include "includes/header.php";
?>

<div class="container-fluid container-bg container-full-height">
    <div class="row">
        <?php include "includes/sidebar.php";?>
        <div class="col-lg-10 col-md-9 col-sm-8 col-xs-1">
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
            <div class="page-title">Dashboard</div>
            <div class="dashboard-cards">
                <?php foreach ($users->GetAllUsers($_SESSION['user_id']) as $profile): ?>
                    <div class = "dash-card text-center">
                        <?php $follow = $users->xFollowsY($user->id,$profile->id); ?>
                        <a href="profile.php?profile=<?php echo $profile->id; ?>">
                            <img src="<?php echo $profile->user_photo; ?>" alt="" srcset="">
                            <div class=""><?php echo $profile->user_fullname; ?></div>
                        </a>
                        <div class="buttons">
                            <p>Following: <strong><?= $follow?"YES":"NO";?></strong></p>
                        </div>
                </div>
                <?php endforeach;?>
        </div>
    </div>
</div>
<?php include "includes/footer.php";?>