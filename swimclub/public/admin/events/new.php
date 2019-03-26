<?php

require_once('../../../private/initialize.php');

// REQUIRE LOGIN
require_admin_login();
$admin = find_admin_by_id($_SESSION['admin_id']);

if(is_post_request()) {

    $event = [];
    $event['event_name'] = trim($_POST['event_name']) ?? '';

    $result = insert_event($event);
    if($result === true) {
        $new_id = mysqli_insert_id($db);
        redirect_to(url_for('/admin/events/index.php?message=' . h("Event successfully added")));
    } 
    else {
        $errors = $result;
    }

} else {
    $event = [];
    $event['event_name'] = '';
}

?>

<?php $page_title = "New Event"; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

    <?php echo display_errors($errors); ?>

    <form class="container" method="post" action="new.php">
        <a class="back-link" href="<?php echo url_for('/admin/events/index.php'); ?>">&laquo; Back to List</a>
        <h1>Add Event</h1><p class="text-danger"><?php echo $message ?? ""; ?></p>
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="event_name">Event Name</label>
            <input type="text" name="event_name" class="form-control" id="event_name" value="<?php echo h($event['event_name'])?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
<div>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
</div>
