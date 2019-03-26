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
    $errors[] = "username cannot be blank";
  }
  // check password present
  if(is_blank($password)){
    $errors[] = "password cannot be blank";
  }
  
  //if there are no errors
  if(empty($errors)){
    // set error message for login attempt
    $login_failed_message = "Log in was unsuccessful";
    $user = find_user_by_email($email);
    if($user){
      // user email found
      if (password_verify($password, $user['password'])){
        login_user($user);
        redirect_to(url_for('/client/index.php'));
      }
      else{
        // username found but password incorrect
        $errors[] = $login_failed_message;
      }
    }
    else{
      // no username found
      $errors[] = $login_failed_message;
    }
  }
}

?>

<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="content" class="container">


  <?php echo display_errors($errors); ?>

  <form class="login" action="login.php" method="post">
    <h1 class="text-success"><?php echo $message ?></h1>
    <h1>Login</h1>
    <div class="form-group">
      <label for="email">Username</label>
      <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo h($email); ?>">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="password" class="form-control" id="password" placeholder="Password">
    </div>
    <div class="form-group">
      <input class="btn btn-primary" type="submit" name="submit" value="Submit"  /> 
    </div>
    
    <a href="<?php echo url_for('/client/register.php'); ?>">Register</a>
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>