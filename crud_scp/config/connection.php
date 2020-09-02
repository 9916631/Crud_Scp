<?php
 
$host = "localhost";
$db = "a9916631_inclassassignment";
$user = "a9916631_zina";
$pwd = "pleasejustwork";

$dsn = "mysql:host=$host; dbname=$db";

try
{
    $conn = new PDO($dsn, $user, $pwd);
}
catch(PDOException $error)
{
    echo "<h3>Sorry, something went wrong, please try again.</h3>" . $error->getMessage();
}

$selectAll = "Select * from subject";

$record = $conn->prepare($selectAll);
$record->execute();

?>