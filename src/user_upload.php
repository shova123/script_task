<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';
//php src/user_upload.php --file=users.csv --create_table=users -u=root -p=postgres -h=localhost
//sudo docker-compose up -d

$longoptions  = array(
    "file:",            // name of CSV file to be parsed --file "users.csv"
    "create_table:",    // this will create table with the table name --create_table "users"
    "dry_run:",          // with value check
    "help",             // this will give the help instruction with the directives options --help
);

$shortoptions  = "";
$shortoptions .= "u::"; // MYSQL username -u="root"
$shortoptions .= "p::"; // MYSQL password -p="*******"
$shortoptions .= "h::"; // MYSQL hostname -h="localhost"

$options = getopt($shortoptions, $longoptions); //to get options from the command line argument list

if(array_key_exists("help",$options)){
    
    $help_message = "
    ++++++ Command Line Directive Details ++++++
    
    --file 'users.csv'      - This is name of the CSV file to be parsed
    --create_table 'users'  - This will create users table to be built
    -u='postgres'               - This is Pgsql username
    -p='*******'            - This is Pgsql password
    -h='localhost'          - This is Pgsql host name
    --help                  - This will gives you directives list directions and its details
    --dry_run check         - This command is to check the program running in your environment
    
    How you should run in command line interface to run smoothly?
    
    - go to your directives -> cd /var/www/html/script_task/
    - run you file -> php src/user_upload.php --file=users.csv --create_table=users -u=postgres -p=postgres -h=localhost
    - run to get help -> php user_upload.php --help
       \n
       ";
    
    fwrite(STDOUT, $help_message);
    exit();
    
}

$dir = getcwd(); // current directory
$file_name = $options['file'];

$param['username'] = $options['u'];
$param['password'] = $options['p'];
$param['hostname'] = $options['h'];

$param['create_table'] = $options['create_table'];

$objUser = new Users();
if(array_key_exists("dry_run",$options) && array_key_exists("file",$options)){
    $dry_run = $options['dry_run'];
    
    if($dry_run != false){ //condition to get --help directives and execute showing help message and exit.
        $objUser ->dryRun($dry_run, $dir, $file_name);
    }
    exit();
}

$objdatabase =  new Database($param);
$objUser -> extractData($dir, $file_name,$objdatabase);


?>