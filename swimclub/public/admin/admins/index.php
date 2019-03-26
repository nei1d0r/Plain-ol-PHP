<?php require_once('../../../private/initialize.php'); ?>

<?php
    // REQUIRE LOGIN
    require_admin_login();
    $admin = find_admin_by_id($_SESSION['admin_id']);

    $admins = find_all_admins();
    $message = $_GET['message'] ?? "";
?>

<?php include_once(SHARED_PATH . '/admin_header.php'); ?>

<div class="container">
    <div class="">
        <a class="action" href="<?php echo url_for('/admin/admins/new.php'); ?>">New Admin</a>
    </div>
    <h2 class="text-success"><?php echo $message; ?></h1>
    <table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Email</th>
            <th scope="col">Registered</th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
        <tbody>
            <?php while($admin = mysqli_fetch_assoc($admins)) { ?>
            <tr>
                <td><?php echo h($admin['id']); ?></td>
                <td><a href="mailto:<?php echo h($admin['email']); ?>"><?php echo h($admin['email']); ?></td>
                <td><?php echo h($admin['registered']); ?></td>
                <td><a class="action" href="<?php echo url_for('/admin/admins/edit.php?id=' . h(u($admin['id']))); ?>">Edit</a></td>
                <td><a class="action" href="<?php echo url_for('/admin/admins/delete.php?id=' . h(u($admin['id']))); ?>">Delete</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include_once(SHARED_PATH . '/admin_footer.php'); ?>