<?php if (!empty($errors)) : ?>
  <div class="message bg-red-100 my-3 p-3 rounded">
    <ul>
      <?php foreach ($errors as $error) : ?>
        <li>&bull; <?= $error ?></li>
      <?php endforeach; ?>

    </ul>
  </div>
<?php endif; ?>