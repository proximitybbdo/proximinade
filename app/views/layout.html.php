<!doctype html>  
<html class="no-js">
<head>
	<meta charset="utf-8" />
	<title><?php echo _t('title'); ?></title>
  <link rel="stylesheet" href="<?php echo _asset('assets/css/bootstrap.min.css'); ?>" />
</head>
<body id="<?php echo $lang; ?>">
  <div class="container">
    <div class="navbar">
      <div class="navbar-inner">
        <div class="container" id="langswitch">
          <ul class="nav pull-right">
            <li><a href="#"><strong>Current lang:</strong> <span id="lang"><?php echo $lang; ?></span></a></li>
          </ul>
          <ul class="nav">
            <li><a id="nl" href="<?php echo url_for('/nl-BE/index'); ?>">Nederlands</a></li>
            <li><a id="fr" href="<?php echo url_for('/fr-BE/index'); ?>">Francais</a></li>
            <li><a href="<?php echo _url('very/deep/link'); ?>">Very deep link</a></li>
          </ul>
        </div>
      </div>
    </header>
    <hr />
    <div id="main">
      <?php echo($content); ?>
    </div>
  </div>
</body>
</html>
