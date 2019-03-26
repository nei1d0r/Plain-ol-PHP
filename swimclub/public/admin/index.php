<?php require_once('../../private/initialize.php'); ?>

<?php
    require_admin_login();
    $admin = find_admin_by_id($_SESSION['admin_id']);
?>

<?php
    $admins = find_all_admins();
    $message = $_GET['message'] ?? "";
?>

<?php include_once(SHARED_PATH . '/admin_header.php'); ?>

<h1>Logged in as: <?php echo $admin['email'] ?></h1>
<br/>

<div class="container">
    <ul class="">
        <li><a class="action" href="<?php echo url_for('/admin/clients/index.php'); ?>">Client</a></li>
        <li><a class="action" href="<?php echo url_for('/admin/events/index.php'); ?>">Events</a></li>
        <li><a class="action" href="<?php echo url_for('/admin/user_events/index.php'); ?>">Competitions</a></li>
        <li><a class="action" href="<?php echo url_for('/admin/admins/index.php'); ?>">Admins</a></li>
    </ul>
    <h2 class="text-success"><?php echo $message; ?></h1>
</div>

<?php include_once(SHARED_PATH . '/admin_footer.php'); ?>