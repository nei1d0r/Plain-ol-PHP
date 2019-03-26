<?php require_once('../../../private/initialize.php'); ?>

<?php
    // REQUIRE LOGIN
    require_admin_login();
    $admin = find_admin_by_id($_SESSION['admin_id']);
    
    $events = find_all_events();
    $message = $_GET['message'] ?? "";
?>

<?php include_once(SHARED_PATH . '/admin_header.php'); ?>

<div class="container">
    <div class="">
        <a class="action" href="<?php echo url_for('/admin/events/new.php'); ?>">New Event</a>
    </div>
    <h2 class="text-success"><?php echo $message; ?></h1>
    <table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
        <tbody>
            <?php while($event = mysqli_fetch_assoc($events)) { ?>
            <tr>
                <td><?php echo h($event['id']); ?></td>
                <td><?php echo h($event['event_name']); ?></td>
                <td><a class="action" href="<?php echo url_for('/admin/events/edit.php?id=' . h(u($event['id']))); ?>">Edit</a></td>
                <td><a class="action" href="<?php echo url_for('/admin/events/delete.php?id=' . h(u($event['id']))); ?>">Delete</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include_once(SHARED_PATH . '/admin_footer.php'); ?>