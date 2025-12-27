<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: view_uploaded_files.php");
    exit;
}

$file_id = (int)$_GET['id'];

/* CHECK IF ELECTION IS ONGOING */
$ongoing = $conn->query("
    SELECT id FROM election WHERE status='ongoing' LIMIT 1
");

if($ongoing->num_rows > 0){
    echo "<script>
        alert('❌ Cannot delete voter files while election is ongoing');
        window.location.href='view_uploaded_files.php';
    </script>";
    exit;
}

/* FETCH FILE */
$res = $conn->query("
    SELECT * FROM voter_pdf_uploads WHERE id='$file_id'
");

if($res->num_rows == 0){
    header("Location: view_uploaded_files.php");
    exit;
}

$file = $res->fetch_assoc();
$fileName = $file['file_name'];

/* DELETE VOTERS FROM THIS FILE */
$conn->query("
    DELETE FROM voters WHERE source_file='$fileName'
");

/* DELETE PHYSICAL FILE */
$path = "uploads/".$fileName;
if(file_exists($path)){
    unlink($path);
}

/* DELETE FILE RECORD */
$conn->query("
    DELETE FROM voter_pdf_uploads WHERE id='$file_id'
");

echo "<script>
    alert('✅ File and related voters deleted successfully');
    window.location.href='view_uploaded_files.php';
</script>";
exit;
?>
