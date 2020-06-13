<?php 
define ('DB_HOST', 'host'); 
define ('DB_USER', 'user');
define ('DB_PASSWORD', 'password');
define ('DB_NAME', 'database'); 
$db = @new mysqli (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

if (mysqli_connect_errno()) { 
    print 'Can\'t connect to database. Please try again later.'; 
    exit; 
} 
?>