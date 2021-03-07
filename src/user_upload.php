<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';

$command = array(
    "files:",
    "create_table:",
    "u::",
    "p::",
    "h::"
);
$file_name = getopt("f:");
var_dump($file_name);
// execution_command($file);
$dir = getcwd(); // current directory
$objUser = new Users();
$objUser ->extractData($dir, $file_name);
?>