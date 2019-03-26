<?php

require_once('../../../private/initialize.php');

// REQUIRE LOGIN
require_admin_login();
$admin = find_admin_by_id($_SESSION['admin_id']);

if(is_post_request()) {

    $admin = [];
    $admin['email'] = trim($_POST['email']) ?? '';
    $admin['password1'] = trim($_POST['password1']) ?? '';
    $admin['password2'] = trim($_POST['password2']) ?? '';

    // Check if email is already in use, redirect to login if it does
    if($admin['email'] == $_SESSION['admin_email'] || !find_admin_by_email($admin['email'])){
        $result = update_admin($admin);
        if($result === true) {
            $_SESSION['admin_email'] = $admin['email'];
            redirect_to(url_for('/admin/index.php'));
        } else {
            $errors = $result;
            //var_dump($errors);
        }
    }
    else{
        $message = "Email address already in use, use another";
    }

} else {

    $admin = find_admin_by_id($_SESSION['admin_id']);

}

?>

<?php $page_title = "Edit Admin"; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

    <?php echo display_errors($errors); ?>

    <form class="container" method="post" action="edit.php">
        <h1>Edit Admin</h1><p class="text-danger"><?php echo $message ?? ""; ?></p>
        <div class="form-group">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo h($admin['email'])?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="password1">Password</label>
                <input type="password" name="password1" class="form-control" id="password1" value="">
            </div>
            <div class="form-group col-md-6">
                <label for="password2">Confirm Password</label>
                <input type="password" name="password2" class="form-control" id="postcode" value="">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
<div>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
</div>
