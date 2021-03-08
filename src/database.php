<?php
require 'vendor/autoload.php';


Class Database{

    private $db;  //The db handle
    private $table_name;
   
   function __construct($params) {
            $isdb =false;
        
            $host=$params['hostname'];
            $port =5432;
            $dbname ="catalyst"; 
            $user=$params['username'];
            $pword = $params['password'];
            $this -> table_name = $params['create_table'];
            $this -> db  = pg_connect("host=$host port=$port user=$user password=$pword");
          
            // $cmd = "SELECT schema_name FROM information_schema.schemata WHERE schema_name ='catalyst'";
            $cmd = "select exists(
                SELECT datname FROM pg_catalog.pg_database WHERE lower(datname) = lower('catalyst')
               );";
            if( pg_query($this->db,$cmd)){
                $sql = "DROP DATABASE [IF EXISTS] $dbname";
                $isdb =true;
            }

            if ($isdb == false) {
                $sql = "CREATE DATABASE $dbname ENCODING 'UTF8'";
                pg_query($this -> db, $sql);
                if (pg_last_error($this -> db)){
                    fwrite(STDOUT, pg_last_error($this -> db));
                    exit();
                }
                else{
                    fwrite(STDOUT, 'Success, database "<b>'.$dbname.'</b>" is created.<br>');
                }
                
            }
            $sql = ["CREATE TABLE IF NOT EXISTS $this ->table_name (
                id SERIAL PRIMARY KEY,
                firstname CITEXT,
                surname CITEXT,
                email CITEXT,
             );"];
           pg_query($this->db,$sql);
           
            return true;

    }

    // For INSERT
    public function insert($data)
    {
        $firstname = $data['firstname'];
        $surname   = $data['surname'] ; 
        $email     = $data['email'] ;
        $sql = "INSERT INTO $this -> table_name (firstname, surname, email) VALUES ('$firstname', '$surname', '$email')";
        $result = pg_query($this->db, $sql);
        if (pg_last_error()) exit(pg_last_error());
        $this->last_id = pg_fetch_result($result, 0);
        return $this->last_id;
    }

    // For UPDATE, DELETE and CREATE TABLE
    public function exec($sql)
    {
        
        // $result = pg_query($this->db, $sql);
        // if (pg_last_error()) exit(pg_last_error());
        
        return true;
    }

}

?>