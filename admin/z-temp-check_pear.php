<?php
ini_set('open_basedir','/var/www/vhosts/instylenewyork.com/httpdocs/:/tmp/:/usr/share/pear/');
require_once('System.php');
var_dump(class_exists('System', false));

/*
| ---------------------------------------
| Should output only the following:
| bool(true)
*/
?> 