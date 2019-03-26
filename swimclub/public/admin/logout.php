<?php
require_once('../../private/initialize.php');

unset($_SESSION['admin_email']);
unset($_SESSION['admin_password']);
unset($_SESSION['admin_id']);
// or you could use
// $_SESSION['username'] = NULL;

redirect_to(url_for('/admin/login.php'));

?>
