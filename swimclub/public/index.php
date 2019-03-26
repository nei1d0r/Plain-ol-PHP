<?php require_once('../private/initialize.php')?>

<?php include SHARED_PATH . '../header.php' ?>

<div class="row container-fluid bg-dark justify-center">
    <div class="container-fluid col bg-dark align-center justify-center">
        <a href="<?php echo url_for('/client/index.php')?>">Client Login</a>
    </div>

    <div class="container-fluid col bg-light">
        <a href="<?php echo url_for('admin/index.php')?>">Admin Login</a>
    </div>
</div>
<?php include SHARED_PATH . '../footer.php' ?>