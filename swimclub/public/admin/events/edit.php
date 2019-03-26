<?php

require_once('../../../private/initialize.php');

// REQUIRE LOGIN
require_admin_login();
$admin = find_admin_by_id($_SESSION['admin_id']);

$id = $_GET['id'] ?? "";

if(is_post_request()) {

    $event = [];
    $event['event_name'] = trim($_POST['event_name']) ?? '';
    $event['id'] = trim($_POST['event_id']) ?? '';

    $result = update_event($event);
    if($result === true) {
        $new_id = mysqli_insert_id($db);
        redirect_to(url_for('/admin/events/index.php?message=' . h("Successfully edited event")));
    } 
    else {
        $errors = $result;
    }

} else {

    $event = find_event_by_id($id);

}

?>

<?php $page_title = "Register"; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

    <?php echo display_errors($errors);
    
    ?>

    <form class="container" method="post" action="edit.php">
        <h1>Edit Event</h1><p class="text-danger"><?php echo $message ?? ""; ?></p>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="first_name">Event Name</label>
                <input type="text" name="event_name" class="form-control" id="event_name" value="<?php echo h($event['event_name'])?>">
                <input type="hidden" name="event_id" class="form-control" id="event_id" value="<?php echo h($event['id'])?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
<div>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
</div>
