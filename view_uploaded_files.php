<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

$files = $conn->query("
    SELECT * FROM voter_pdf_uploads
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Uploaded Voter Files</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
body{
font-family:'Poppins',sans-serif;
background:linear-gradient(135deg,#141e30,#243b55);
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
color:white;
}

.card{
background:white;
color:black;
padding:30px;
width:750px;
border-radius:15px;
box-shadow:0 20px 40px rgba(0,0,0,0.3);
}

h2{
text-align:center;
margin-bottom:20px;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:12px;
text-align:center;
border-bottom:1px solid #ddd;
}

th{
background:#f5f5f5;
}

.badge{
padding:4px 10px;
border-radius:12px;
font-size:12px;
color:white;
}

.pdf{background:#e53935;}
.csv{background:#1e88e5;}

.delete{
color:#e53935;
font-weight:600;
text-decoration:none;
}

.actions{
margin-top:20px;
text-align:center;
}
.actions a{
margin:0 10px;
text-decoration:none;
font-weight:600;
color:#243b55;
}
</style>
</head>

<body>

<?php include "nav_buttons.php"; ?>

<div class="card">
<h2>📂 Uploaded Voter Files</h2>

<table>
<tr>
<th>File Name</th>
<th>Type</th>
<th>Uploaded On</th>
<th>Action</th>
</tr>

<?php while($f = $files->fetch_assoc()){ 
$type = $f['file_type'] ?? 'pdf';
?>
<tr>
<td><?php echo htmlspecialchars($f['file_name']); ?></td>

<td>
<span class="badge <?php echo $type; ?>">
<?php echo strtoupper($type); ?>
</span>
</td>

<td><?php echo $f['uploaded_on']; ?></td>

<td>
<a class="delete"
   href="delete_file.php?id=<?php echo $f['id']; ?>"
   onclick="return confirm('Delete this file and all related voters?')">
🗑 Delete
</a>
</td>
</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>
