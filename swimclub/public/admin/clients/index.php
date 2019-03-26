<?php require_once('../../../private/initialize.php'); ?>

<?php

    // REQUIRE LOGIN
    require_admin_login();
    $admin = find_admin_by_id($_SESSION['admin_id']);
    
    $clients = find_all_users();
    $message = $_GET['message'] ?? "";
?>

<?php include_once(SHARED_PATH . '/admin_header.php'); ?>

<div class="container">
    <div class="">
        <a class="action" href="<?php echo url_for('/admin/clients/new.php'); ?>">New Client</a>
    </div>
    <h2 class="text-success"><?php echo $message; ?></h1>
    <table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Registered</th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
        <tbody>
            <?php while($client = mysqli_fetch_assoc($clients)) { ?>
            <tr>
                <td><?php echo h($client['id']); ?></td>
                <td><?php echo h($client['first_name'] ." ". $client['last_name']); ?></td>
                <td><a href="mailto:<?php echo h($client['email']); ?>"><?php echo h($client['email']); ?></td>
                <td><?php echo h($client['registered']); ?></td>
                <td><a class="action" href="<?php echo url_for('/admin/clients/edit.php?id=' . h(u($client['id']))); ?>">Edit</a></td>
                <td><a class="action" href="<?php echo url_for('/admin/clients/delete.php?id=' . h(u($client['id']))); ?>">Delete</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include_once(SHARED_PATH . '/admin_footer.php'); ?>