<?php
 require 'vendor/autoload.php';

 class Users
  {

      private $database;
    
      function __construct()
      {
          $this -> database = new Database();
      }

      function validateFileName($filename) {

        $csv_explode = explode(".", $csv_file);
        if($csv_explode[0] == "users" && $csv_explode[1]=='csv'){
          $this -> extractData($csv_file) ;
        } else {
            $this -> handleError('file');
        }

      }

      function validateEmail($input_email){
        $input_email = trim($input_email);// removing the unwanted space from the strings
        $input_email = strtolower($input_email); //string to lower case

        return filter_var($input_email, FILTER_VALIDATE_EMAIL);// filter_var php function to filter the email
      }

      function validateName($name) {
        $name = trim($name);// removing the unwanted space from the strings
        $name = strtolower($name); //string to lower case
        $name = ucfirst($name); //strings first character to be capitalised
        return $name;
      }

      function handleError($error_type){

        switch ($error_type) {
          case "email":
            fwrite(STDOUT, "\n \n Email Validation failed!!! \n");
            
            break;
          case "file":
            fwrite(STDOUT, "\n File name incorrect | Must be users.csv : ERROR! \n");
            exit();
            
            break;
                     
          default:
          fwrite(STDOUT, "\n Error in your execution command series: \n Please check --help command\n");
            
        } 
          
      }

      function extractData($dir, $file_name)
      {
          if(is_dir($dir)){
            if ($dh = opendir($dir)) {
                
                $dir_path = $dir."/".$file_name['f']; // csv file path /var/www/html/script_task/users.csv
                echo $dir;
                $file_info = pathinfo($dir_path); //pathinfo return array value of file information
                        
                $csvFile = fopen($dir_path,'r');
                
                $countRows = 0;
                
                while(($row_line = fgetcsv($csvFile, 1000, ",")) !== FALSE){
    
                    $name    = $row_line[0];
                    $surname = $row_line[1];
                    $email   = $row_line[2];
    
                    $name    = $this -> validateName($name);
                    $surname = $this -> validateName($surname);
                    
                    if($name != "Name" || $surname != "Surname"){ // Condition to exclude first line of parsed CSV file which has column indexing name that should'nt be inserted in the DB table
    
                        $email = $this ->validateEmail($email); // validation function call to validate email filters
                        
                        //if only email validate insertion of data occurs
                        if($email == TRUE){  
                            $data['firstname'] = $name;
                            $data['surname']   =$surname;
                            $data['email'] = $email; 
                            $this -> database -> insert($data); 
                            $countRows++;
                        
                        } else {

                          $this -> handleError ('email');

                        }       
                    } 
                
                }

                if(!empty($countRows)){

                    fwrite(STDOUT, "\n Total:$countRows number of rows has been inserted \n");

                }
                
          }
        }
  

      }

      
 }
 

?>