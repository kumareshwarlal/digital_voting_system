<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: view_voters.php");
    exit;
}

$id = (int)$_GET['id'];

/* CHECK IF ELECTION IS ONGOING */
$ongoing = $conn->query("
    SELECT id FROM election WHERE status='ongoing' LIMIT 1
");

if($ongoing->num_rows > 0){
    echo "<script>
        alert('❌ Cannot delete voters while election is ongoing');
        window.location.href='view_voters.php';
    </script>";
    exit;
}

/* DELETE VOTER */
$conn->query("DELETE FROM voters WHERE id='$id'");

echo "<script>
    alert('✅ Voter deleted successfully');
    window.location.href='view_voters.php';
</script>";
exit;
?>
