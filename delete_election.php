<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: manage_elections.php");
    exit;
}

$eid = $_GET['id'];

/* FETCH ELECTION */
$res = $conn->query("SELECT * FROM election WHERE id='$eid'");
$election = $res->fetch_assoc();

if(!$election){
    header("Location: manage_elections.php");
    exit;
}

/* BLOCK IF ONGOING */
if($election['status'] === 'ongoing'){
    echo "<script>
        alert('❌ Cannot delete an ongoing election');
        window.location.href='manage_elections.php';
    </script>";
    exit;
}

/* DELETE RELATED VOTES */
$conn->query("DELETE FROM votes WHERE election_id='$eid'");

/* DELETE ELECTION */
$conn->query("DELETE FROM election WHERE id='$eid'");

echo "<script>
    alert('✅ Previous election deleted successfully');
    window.location.href='manage_elections.php';
</script>";
