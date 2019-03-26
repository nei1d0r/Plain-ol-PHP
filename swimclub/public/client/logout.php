<?php
require_once('../../private/initialize.php');

unset($_SESSION['user_email']);
unset($_SESSION['user_password']);
unset($_SESSION['user_first_name']);
unset($_SESSION['user_id']);
// or you could use
// $_SESSION['username'] = NULL;

redirect_to(url_for('/client/login.php'));

?>
