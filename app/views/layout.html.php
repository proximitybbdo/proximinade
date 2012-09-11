<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>Cantaloupe - Interim Management</title>
  <meta name="description" content="Cantaloupe - Interim Management" />
  <meta name="author" content="Marc Plancke" />

  <link rel="shortcut icon" href="<?php echo _asset('assets/img/shared/favicon.png'); ?>" />
  <link rel="apple-touch-icon" href="<?php echo _asset('assets/img/shared/apple-touch-icon.png'); ?>" />

  <link rel="stylesheet" href="<?php echo _asset('assets/css/style.css') ?>" /> 	
  <script src="<?php echo _asset('assets/js/libs/modernizr-2.6.1.min.js'); ?>"></script>
</head>
<body>

  <div class="wrapper">
    <header>
      <a id="logo" href="<?php echo url_for('/'); ?>">
        <img src="<?php echo _asset('assets/img/shared/logo.png') ?>" alt="Cantaloupe Interim Management" />
      </a>		
      <nav>
        <ul>
          <li><a <?php if(_get_active('home')) echo 'class="active"'; ?>href="<?php echo url_for('home'); ?>">Home</a></li>
          <li><a href="<?php echo url_for('services'); ?>">Services</a></li>
          <li><a id="join" href="<?php echo url_for('services'); ?>">Join</a></li>
        </ul>
      </nav>
    </header>

    <div id="intro">
      <h1>What is Cantaloupe?</h1>
      <p>
        Cantaloupe is an <strong>Interim Management Consultancy,</strong> 
        exclusively focused in HR. 
        We offer an <strong>innovative business model</strong> along with 
        the highest quality standards to <strong>our client companies</strong> 
        and affiliated HR Interim Managers and Freelance Professionals.
      </p>
      <div id="action">
        <a href="#" id="iamlooking">
          <span>I am looking for</span>
          an HR Interim Manager or Freelancer
        </a>
        <a href="#" id="iam">
          <span>I am</span>
          HR interim manager or <em>Freelancer</em>
        </a>
      </div>
    </div>

  </div>

<footer>

</footer>

<!--[if (gte IE 6)&(lte IE 8)]><script src="<?php echo _asset('assets/js/libs/selectivizr.js'); ?>"></script><![endif]-->	

<script>
  var _gaq = [['_setAccount','xxxxxxxxxxxxx'], ['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<noscript>Your browser does not support JavaScript!</noscript> 
</body>
</html>
