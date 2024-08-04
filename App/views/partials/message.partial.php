<?php

use Framework\Session;
?>

<?php
$successMessage = Session::getFlashMessage('success');
?>

<?php if ($successMessage) : ?>
  <div class="message bg-green-100 p-3 my-3 text-center">
    <?= $successMessage ?>
  </div>
<?php endif; ?>

<?php
$errorMessage = Session::getFlashMessage('error');
?>

<?php if ($errorMessage) : ?>
  <div class="message bg-red-100 p-3 my-3 text-center">
    <?= $errorMessage ?>
  </div>
<?php endif; ?>