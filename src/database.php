<?php
require 'vendor/autoload.php';


Class Database{

    private $db;  //The db handle
    private $table_name;//table name
   
    function __construct($params) {
            $isdb =false;
        
            $host=$params['hostname'];
            $port =5432;
            $dbname ="catalyst"; 
            $user=$params['username'];
            $pword = $params['password'];
            $this -> table_name = $params['create_table'];
            $this -> db  = pg_connect("host=$host port=$port user=$user password=$pword");
          
          
            $cmd = "select exists(
                SELECT datname FROM pg_catalog.pg_database WHERE datname = 'catalyst'
               );";
            if( pg_query($this->db,$cmd)) {
             
                $sql  = "DROP DATABASE IF EXISTS $dbname";
                pg_query($this -> db, $sql);
                $isdb = false;
            }

            if ($isdb == false) {
                $sql = "CREATE DATABASE $dbname ENCODING 'UTF8'";
                pg_query($this -> db, $sql);

                if(pg_last_error($this -> db)){
                    fwrite(STDOUT, pg_last_error($this -> db));
                    exit();
                } else {

                    fwrite(STDOUT, 'Database "'.$dbname.'" is created.<br>');
                }
                $isdb =true;
            }

            $table_name = $this ->table_name;
            $sql = "CREATE TABLE IF NOT EXISTS $table_name(
                id SERIAL PRIMARY KEY,
                firstname varchar(45) NOT NULL,
                surname varchar(45) NOT NULL,
                email varchar(100) NOT NULL
             )";
            if (pg_query($this->db,$sql)){
                fwrite(STDOUT, 'Table  "'.$table_name.'" is created.<br>');
            } else {
                fwrite(STDOUT, pg_last_error());
                exit();
            }
                       
            return true;

    }

    // For INSERT
    public function insert($data)
    {
        $firstname = $data['firstname'];
        $surname   = $data['surname'] ; 
        $email     = $data['email'] ;
        $table_name = $this -> table_name;
        $sql = "INSERT INTO $table_name (firstname, surname, email) VALUES ('$firstname', '$surname', '$email')";
        $result = pg_query($this->db, $sql);
        if (pg_last_error()){
            fwrite(STDOUT, pg_last_error());
                exit();
        }
        $this->last_id = pg_fetch_result($result, 0);
        return $this->last_id;
    }

}

?>