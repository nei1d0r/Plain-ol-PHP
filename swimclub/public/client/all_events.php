<?php require_once('../../private/initialize.php'); ?>

<?php include SHARED_PATH . '../header.php' ?>

<?php 

// REQUIRE LOGIN
require_login();
$user = find_user_by_id($_SESSION['user_id']);

$events = find_all_user_events();

?>

<div class="container">
        <hr/>
        <div class="">
            <h2>All Events</h2>
        </div>
        <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Event</th>
                <th scope="col">Result</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
            <tbody>
                <?php while($event = mysqli_fetch_assoc($events)) { ?>
                <tr>
                    <td><?php echo h($event['first_name']) . " " . h($event['last_name']); ?></td>
                    <td><?php echo h($event['event_name']); ?></td>
                    <td><?php echo h($event['result']); ?></td>
                    <td><?php echo h($event['event_date']); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php include SHARED_PATH . '../footer.php' ?>