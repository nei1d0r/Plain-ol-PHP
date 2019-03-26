<?php
require_once('../../private/initialize.php');

$errors = [];
$email = '';
$password = '';
$message = $_GET['message'] ?? "";

if(is_post_request()) {

  // VALIDATE LOGIN AND SET SESSION DATA HERE

  $email = trim($_POST['email']) ?? '';
  $password = trim($_POST['password']) ?? '';

  // check email present
  if(is_blank($email)){
    $errors[] = "email cannot be blank";
  }
  // check password present
  if(is_blank($password)){
    $errors[] = "password cannot be blank";
  }
  
  //if there are no errors
  if(empty($errors)){
    // set error message for login attempt
    $login_failed_message = "Log in was unsuccessful";
    $admin = find_admin_by_email($email);
    if($admin){
      // admin email found
      if (password_verify($password, $admin['password'])){
        login_admin($admin);
        redirect_to(url_for('/admin/index.php'));
      }
      else{
        // admin found but password incorrect
        $errors[] = $login_failed_message;
      }
    }
    else{
      // no admin found
      $errors[] = $login_failed_message;
    }
  }
}

?>

<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content" class="container">


  <?php echo display_errors($errors); ?>

  <form class="login" action="login.php" method="post">
    <h1 class="text-success"><?php echo $message ?></h1>
    <h1>Login</h1>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo h($email); ?>">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="password" class="form-control" id="password" placeholder="Password">
    </div>
    <div class="form-group">
      <input class="btn btn-primary" type="submit" name="submit" value="Submit"  /> 
    </div>
  </form>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>