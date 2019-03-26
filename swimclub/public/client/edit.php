<?php

require_once('../../private/initialize.php');

// REQUIRE LOGIN
require_login();
$user = find_user_by_id($_SESSION['user_id']);

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
    if($user['email'] == $_SESSION['email'] || !find_user_by_email($user['email'])){
        $result = update_user($user);
        if($result === true) {
            $_SESSION['email'] = $user['email'];
            redirect_to(url_for('/client/index.php'));
        } else {
            $errors = $result;
            //var_dump($errors);
        }
    }
    else{
        $message = "Email address already in use, use another";
    }

} else {

    $user = find_user_by_id($_SESSION['id']);

}

?>

<?php $page_title = "Edit"; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="content">

    <?php echo display_errors($errors); ?>

    <form class="container" method="post" action="edit.php">
        <h1>Edit Details</h1><p class="text-danger"><?php echo $message ?? ""; ?></p>
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
<?php include(SHARED_PATH . '/footer.php'); ?>
</div>
