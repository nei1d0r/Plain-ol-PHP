<?php require_once('../../private/initialize.php')?>

<?php include SHARED_PATH . '../header.php' ?>

<?php
    require_login();
    $user = find_user_by_id($_SESSION['user_id']);
    $events = find_user_events_by_id($_SESSION['user_id']);
?>

<div id="content">
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Hi, <?php echo $user['first_name']; ?></h1>
            <p class="lead">Welcome to your portal page</p>
        </div>
    </div>

    <div class="container">
        <h2>Name<h2>
        <h4>First: <?php echo $user['first_name']; ?></h4>
        <h4>Last: <?php echo $user['last_name']; ?></h4>
        <h4>Email: <?php echo $_SESSION['user_email']; ?></h4>
        <hr/>
        <h2>Address:<h2>
        <h4><?php echo $user['street']; ?></h4>
        <h4><?php echo $user['town']; ?></h4>
        <h4><?php echo $user['city']; ?></h4>
        <h4><?php echo $user['postcode']; ?></h4>

        <button class="btn btn-primary"> <a class="text-light" href="<?php echo url_for('client/edit.php')?>">Edit Details</a></button>
    </div>

    <div class="container">   
        <hr/>
        <h2>Associated Accounts</h2>
        <button class="btn btn-primary"> 
            <a class="text-light" href="<?php echo url_for('client/register_associate.php')?>">Add Associated Member</a>
        </button>
    </div>

    <hr/>

    <div class="container">
        
        <div class="">
            <h2>Your Events</h2>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Event</th>
                    <th scope="col">Result</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($event = mysqli_fetch_assoc($events)) { ?>
                <tr>
                    <td><?php echo h($event['event_name']); ?></td>
                    <td><?php echo h($event['result']); ?></td>
                    <td><?php echo h($event['event_date']); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <button class="btn btn-primary"> 
            <a class="text-light" href="<?php echo url_for('client/all_events.php')?>">View All Events</a>
        </button>
    </div>
</div>

<?php include SHARED_PATH . '../footer.php' ?>  
