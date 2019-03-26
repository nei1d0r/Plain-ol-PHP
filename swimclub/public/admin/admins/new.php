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
    if(!find_admin_by_email($admin['email'])){
        $result = insert_admin($admin);
        if($result === true) {
            $new_id = mysqli_insert_id($db);
            redirect_to(url_for('/admin/admins/index.php?message=' . h("Admin successfully added")));
        } 
        else {
            $errors = $result;
        }
    }
    else{
        $message = "Email address already in use, please log in or use another";
    }

} else {

    $admin = [];
    $admin['email'] = '';
    $admin['password1'] = '';
    $admin['password2'] = '';

}

?>

<?php $page_title = "New Admin"; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

    <?php echo display_errors($errors); ?>

    <form class="container" method="post" action="new.php">
        <a class="back-link" href="<?php echo url_for('/admin/admins/index.php'); ?>">&laquo; Back to List</a>
        <h1>Add admin</h1><p class="text-danger"><?php echo $message ?? ""; ?></p>
        <div class="form-group">
            <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="<?php echo h($admin['email'])?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="password1">Password</label>
            <input type="password" name="password1" class="form-control" id="password1" value="<?php echo h($admin['password1'])?>">
            </div>
            <div class="form-group col-md-6">
            <label for="password2">Confirm Password</label>
            <input type="password" name="password2" class="form-control" id="postcode" value="<?php echo h($admin['password2'])?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
<div>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
</div>
