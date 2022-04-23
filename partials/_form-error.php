<?php if(isset($_SESSION['error'])): ?>
  <div class="error">
    <strong><?= $_SESSION['error'] ?></strong>
  </div>
<?php endif;
  unset($_SESSION['error']);
?>
