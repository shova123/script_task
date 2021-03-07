<?php
 require 'vendor/autoload.php';

 class Users
  {
    
      function __construct()
      {
          
      }

      function validateEmail($input_email){
        $input_email = trim($input_email);// removing the unwanted space from the strings
        $input_email = strtolower($input_email); //string to lower case

        return filter_var($input_email, FILTER_VALIDATE_EMAIL);// filter_var php function to filter the email
      }

      function validateFileType(){

      }

      function validateName($name){
        $name = trim($name);// removing the unwanted space from the strings
        $name = strtolower($name); //string to lower case
        $name = ucfirst($name); //strings first character to be capitalised
        return $name;
      }

      function handleError($error_type){

        switch ($error_type) {
          case "email":
            fwrite(STDOUT, "\n Invalid Email Format");
            
            break;
          case "file":
            fwrite(STDOUT, "\n Error in file format\n");
            
            break;
                     
          default:
          fwrite(STDOUT, "\n Error in your execution command series: \n Please check --help command\n");
            
        } 
          
      }

      function extractData($dir, $file_name)
      {
        if(is_dir($dir)){
          if ($dh = opendir($dir)) {
              
              $dir_path = $dir."/"."$file_name"; // csv file path /var/www/html/catalystIT/users.csv
              
              $file_info = pathinfo($dir_path); //pathinfo return array value of file information
              $file_ext = $file_info['extension'];
              if(!empty($file_ext) && $file_ext == "csv"){
      
                  $csvFile = fopen($dir_path,'r');
                  
                  $countRows = 0;
                  
                  while(($row_line = fgetcsv($csvFile, 1000, ",")) !== FALSE){
      
                      $name = $row_line[0];
                      $surname = $row_line[1];
                      $email = $check_email = $row_line[2];
      
                      $name = $this ->validateName($name);
                      $surname = validateName($surname);
                      
                      if($name != "Name" || $surname != "Surname"){// Condition to exclude first line of parsed CSV file which has column indexing name that should'nt be inserted in the DB table
      
                          $email = $this ->validateEmail($email); // validation function call to validate email filters
                          
                          //if only email validate insertion of data occurs
                          if($email == TRUE){    
                          
                          }else{
                              fwrite(STDOUT, "\n \n $check_email Email Validation failed!!! \n");
                          }       
                      } 
                  
                  }
              }else{
                  fwrite(STDOUT, "\n File found on the directory is not .CSV file format: ERROR! \n");
              }    
              if(!empty($countRows)){
                  fwrite(STDOUT, "\n Total:$countRows number of rows has been inserted \n");
              }
              
          }
      }
  

      }

      function insertData()
      {

        
      }
 }
 

?>