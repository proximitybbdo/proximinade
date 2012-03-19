<?php

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

foreach (glob(__DIR__.'/../../../../bin/app/config/*.php') as $filename){
  require_once($filename);
}

require_once __DIR__.'/goutte.phar'; 

