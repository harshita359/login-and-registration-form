<?php
session_start();

error_reporting(E_ALL);
ini_set("display_errors",1);
/*this file contains database configuration assuming you are running mysql using "root" and password ""*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'login_register'); 

//try connecting to the databas
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//check the connection
if($conn == false)
{
    die('Error: Connot connect');
}

