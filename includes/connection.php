<?php
try {
    $host = 'studentnet.dundeeandangus.ac.uk';
    $dbname = 'db_T_Bain';
    $username = 'T_Bain';
    $password = 'TBpassword';
    
    $con = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8',$username,$password);
    echo 'Connection successful';
} catch (Exception $ex) {
    echo $ex->getMessage() . '<br />';
    die('Connection failed');
}