<?php
$conn = new mysqli("localhost","root","","digital_voting_system");
if($conn->connect_error){
    die("Database Connection Failed");
}
?>

