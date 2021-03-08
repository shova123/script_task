<?php
require 'vendor/autoload.php';


Class Database{

    private $db;  //The db handle
   
    public function connect($params) {
            $isdb =false;
        
            $host=$params['hostname'];
            $port =5432;
            $dbname ="catalyst"; 
            $user=$params['username'];
            $pword = $params['password'];
            $table_name = $params['create_table'];
            $db  = pg_connect("host=$host port=$port user=$user password=$pword");
            $cmd = 'psql -U postgres -c "SELECT schema_name FROM information_schema.schemata WHERE schema_name = \'catalyst\';"';
            if($this -> exec($cmd)){
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
                    echo 'Success, database "<b>'.$dbname.'</b>" is created.<br>';
                }
                
            }
           
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                                                    id SERIAL PRIMARY KEY,
                                                    firstname CITEXT,
                                                    surname CITEXT,
                                                    email CITEXT,
                                                 )";
            $this->exec($sql);
            return true;

    }

    // For INSERT
    public function insert($data)
    {
        $firstname = $data['firstname'];
        $surname   = $data['surname'] ; 
        $email     = $data['email'] ;
        $sql = "INSERT INTO books (firstname, surname, email) VALUES ('$firstname', '$surname', '$email')";
        $result = pg_query($this->db, $sql);
        if (pg_last_error()) exit(pg_last_error());
        $this->last_id = pg_fetch_result($result, 0);
        return $this->last_id;
    }

    // For UPDATE, DELETE and CREATE TABLE
    public function exec($sql)
    {
        $result = pg_query($this->db, $sql);
        if (pg_last_error()) exit(pg_last_error());
        
        return true;
    }

}

?>