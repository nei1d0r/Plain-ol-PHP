<?php

require_once('../../../private/initialize.php');

// REQUIRE LOGIN
require_admin_login();
$admin = find_admin_by_id($_SESSION['admin_id']);

if(is_post_request()) {

    $user = [];
    $user['first_name'] = trim($_POST['first_name']) ?? '';
    $user['last_name'] = trim($_POST['last_name']) ?? '';
    $user['email'] = trim($_POST['email']) ?? '';
    $user['street'] = trim($_POST['street']) ?? '';
    $user['town'] = trim($_POST['town']) ?? '';
    $user['city'] = trim($_POST['city']) ?? '';
    $user['postcode'] = trim($_POST['postcode']) ?? '';
    $user['password1'] = trim($_POST['password1']) ?? '';
    $user['password2'] = trim($_POST['password2']) ?? '';

    // Check if email is already in use, redirect to login if it does
    if(!find_user_by_email($user['email'])){
        $result = insert_user($user);
        if($result === true) {
            $new_id = mysqli_insert_id($db);
            redirect_to(url_for('client/login.php?message=' . h("Successfully Registered: Please log in")));
        } 
        else {
            $errors = $result;
        }
    }
    else{
        $message = "Email address already in use, please log in or use another";
    }

} else {

    $user = [];
    $user['first_name'] = '';
    $user['last_name'] = '';
    $user['email'] = '';
    $user['street'] = '';
    $user['town'] = '';
    $user['city'] = '';
    $user['postcode'] = '';
    $user['password1'] = '';
    $user['password2'] = '';

}

?>

<?php $page_title = "Register"; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

    <?php echo display_errors($errors); ?>

    <form class="container" method="post" action="register.php">
        <h1>Register</h1><p class="text-danger"><?php echo $message ?? ""; ?></p>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" class="form-control" id="first_name" value="<?php echo h($user['first_name'])?>">
            </div>
            <div class="form-group col-md-6">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control" id="last_name" value="<?php echo h($user['last_name'])?>">
            </div>
        </div>
        <div class="form-group">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo h($user['email'])?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                    <label for="street">Street</label>
                    <input type="text" name="street" class="form-control" id="street" value="<?php echo h($user['street'])?>">
            </div>
            <div class="form-group col-md-6">
                    <label for="town">Town</label>
                    <input type="text" name="town" class="form-control" id="town" value="<?php echo h($user['town'])?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="city">City</label>
                <input type="text" name="city" class="form-control" id="city" value="<?php echo h($user['city'])?>">
            </div>
            <div class="form-group col-md-6">
                <label for="postcode">Postcode</label>
                <input type="text" name="postcode" class="form-control" id="postcode" value="<?php echo h($user['postcode'])?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="password1">Password</label>
                <input type="password" name="password1" class="form-control" id="password1" value="<?php echo h($user['password1'])?>">
            </div>
            <div class="form-group col-md-6">
                <label for="password2">Confirm Password</label>
                <input type="password" name="password2" class="form-control" id="postcode" value="<?php echo h($user['password2'])?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
<div>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
</div>
