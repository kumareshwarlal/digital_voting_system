<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: view_candidates.php");
    exit;
}

$candidate_id = (int)$_GET['id'];

/* CHECK ELECTION STATUS */
$ongoing = $conn->query("
    SELECT id FROM election WHERE status='ongoing' LIMIT 1
");

if($ongoing->num_rows > 0){
    echo "<script>
        alert('❌ Cannot delete candidate while election is ongoing');
        window.location.href='view_candidates.php';
    </script>";
    exit;
}

/* DELETE CANDIDATE */
$conn->query("
    DELETE FROM candidates WHERE id='$candidate_id'
");

echo "<script>
    alert('✅ Candidate deleted successfully');
    window.location.href='view_candidates.php';
</script>";
exit;
?>
