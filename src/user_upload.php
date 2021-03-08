<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';
//php src/user_upload.php --f=users.csv --create_table=users -u=root -p=postgres -h=localhost

$longoptions  = array(
    "f:",            // name of CSV file to be parsed --file "users.csv"
    "create_table:",    // this will create table with the table name --create_table "users"
    "dry_run:",          // with value check
    "help",             // this will give the help instruction with the directives options --help
);

$shortoptions  = "";
$shortoptions .= "u::"; // MYSQL username -u="root"
$shortoptions .= "p::"; // MYSQL password -p="*******"
$shortoptions .= "h::"; // MYSQL hostname -h="localhost"

$options = getopt($shortoptions, $longoptions); //to get options from the command line argument list
print_r($options);
$dir = getcwd(); // current directory
$file_name = $options['f'];

$param['username'] = $options['u'];
$param['password'] = $options['p'];
$param['hostname'] = $options['h'];

$param['create_table'] = $options['create_table'];

$objUser = new Users();
$objdatabase =  new Database($param);
 $objUser -> extractData($dir, $file_name,$objdatabase);


?>