# script_task
Interview  Questions and solutions
<h1>Requirements:</h1>
os:ubuntu 18.04
php-v:7.4
Postgresq1l -v : 13

<h2>commands</h2>
command:php src/user_upload.php --file=users.csv --create_table=users -u=root -p=postgres -h=localhost
docker command:sudo docker-compose up -d

This is simple program that accepts csv file from command: php src/user_upload.php --file=users.csv --create_table=users -u=postgres -p=postgres -h=localhost 
each paramenter functionality is described below:
    
    --file 'users.csv'      - This is name of the CSV file to be parsed
    --create_table 'users'  - This will create users table to be built
    -u='postgres'               - This is Pgsql username
    -p='*******'            - This is Pgsql password
    -h='localhost'          - This is Pgsql host name
    --help                  - This will gives you directives list directions and its details
    --dry_run check         - This command is to check the program running in your environment
    
        
    - go to  directives from root using command -> cd /var/www/html/script_task/
    - run you file -> php src/user_upload.php --file=users.csv --create_table=users -u=postgres -p=postgres -h=localhost
    - run to get help -> php user_upload.php --help
       \n
    -command for dry_run test is :php src/user_upload.php --dry_run check --file users.csv

    The folders contain docker file with enviroment setup
    php version 7.4 and pgsql version 13.
    To run conatiner enter command :docker-compose up -d 
