<h1>Homepage</h1>
<h2>Lang</h2>
<span id="lang"><?php echo $lang; ?></span>
<hr />
<form action="<?php echo url_for('index_post'); ?>" method="post">
  <label for="email">e-mail</label>
  <input type="text" name="email" id="email" />
  <input type="submit" />
</form>
