<?php foreach(get_errors() as $error) {?>
  <div class="alert alert-danger"><?php print $error; ?></div>
<?php } ?>

<?php foreach(get_messages() as $message) {?>
  <div class="alert alert-success"><?php print $message; ?></div>
<?php } ?>
