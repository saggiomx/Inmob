<?php
require_once '../assets/restler/restler.php';

#set autoloader
#do not use spl_autoload_register with out parameter
#it will disable the autoloading of formats
spl_autoload_register('spl_autoload');

$r = new Restler();

//$r->addAuthenticationClass('BasicAuthentication');
$r->handle();