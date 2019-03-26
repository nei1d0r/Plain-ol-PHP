<?php

require_once('../../../private/initialize.php');

// REQUIRE LOGIN
require_admin_login();
$admin = find_admin_by_id($_SESSION['admin_id']);

if(!isset($_GET['id'])) {
  redirect_to(url_for('/admin/admins/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  $result = delete_admin($id);
  redirect_to(url_for('/admin/admins/index.php'));

} else {
  $admin = find_admin_by_id($id);
}

?>

<?php $page_title = 'Delete Client'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content" class="container">  

  <div class="jumbotron">
  <a class="back-link" href="<?php echo url_for('/admin/clients/index.php'); ?>">&laquo; Back to List</a>
    <h1 class="display-4">Delete Admin!</h1>
    <p class="lead">Are you sure you want to delete this admin: </p>
    <h2><?php echo h($admin['email'])?></h2>
    <hr class="my-4">
      <form action="<?php echo url_for('/admin/clients/delete.php?id=' . h(u($admin['id']))); ?>" method="post">
        <div id="operations">
          <input class="btn btn-danger btn-lg" type="submit" name="commit" value="Delete Client" />
        </div>
      </form>
      
</div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>