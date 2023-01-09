<?php 
    $user = $users->UserDetails($_SESSION['user_id']);
?>
<div class="col-lg-2 col-md-3 col-sm-4 col-xs-1 sidebar top-fixed">
    <div class="brand text-white text-center pb-3 mt-3">SocialApp</div>
    <section class="profile">
        <div class="profile-photo">
            <img src="<?php echo $user->user_photo; ?>" alt="profile-photo">
        </div>
        <div class="profile-welcome text-center text-white mb-3">Welcome,
            <strong><?php echo $user->user_fullname; ?></strong></div>
        <div class="profile-links">
            <ul>
                <li><a href="main-page.php">HOME</a></li>
                <li><a href="my-profile.php?profile=<?php echo $user->id; ?>">My Profile</a></li>
                <li><a href="logout.php" class="btn btn-danger mt-3">Logout</a></li>
            </ul>
        </div>
    </section>
</div>