<h1 class="page-header">Homepage</h1>

<p><strong>Current lang:</strong> <span id="lang"><?php echo $lang; ?></span></p>
<hr />
<form action="<?php echo url_for('index_post'); ?>" method="post">
  <label for="email">e-mail</label>
  <input type="text" name="email" id="email" />
  <input type="submit" />
</form>
