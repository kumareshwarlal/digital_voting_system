<?php
session_start();
include "db.php";

$v=$_SESSION['voter'];
$cid=$_POST['cid'];

$conn->query("INSERT INTO votes(voter_id,candidate_id)
VALUES('{$v['id']}','$cid')");

$conn->query("UPDATE voters SET has_voted=1 WHERE id='{$v['id']}'");

echo "Vote Cast Successfully";
