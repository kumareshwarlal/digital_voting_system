<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

$files = $conn->query("
    SELECT * FROM candidate_file_uploads
    ORDER BY uploaded_on DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Candidate Upload Files</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
min-height:100vh;
background:linear-gradient(135deg,#141e30,#243b55);
display:flex;
align-items:center;
justify-content:center;
padding:40px;
}

/* CARD */
.card{
background:white;
width:900px;
padding:30px;
border-radius:20px;
box-shadow:0 25px 50px rgba(0,0,0,0.35);
animation:fadeIn 0.8s ease;
}

@keyframes fadeIn{
from{opacity:0;transform:translateY(20px)}
to{opacity:1;transform:translateY(0)}
}

/* HEADER */
.card h2{
text-align:center;
margin-bottom:10px;
color:#203a43;
}

.desc{
text-align:center;
font-size:14px;
color:#555;
margin-bottom:25px;
}

/* TABLE */
table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:14px;
text-align:center;
border-bottom:1px solid #ddd;
}

th{
background:#f4f6f8;
color:#333;
font-weight:600;
}

/* BADGES */
.badge{
padding:5px 12px;
border-radius:14px;
font-size:12px;
color:white;
font-weight:600;
}

.csv{background:#1e88e5;}
.pdf{background:#e53935;}

/* ACTION */
.delete{
color:#e53935;
font-weight:600;
text-decoration:none;
}

.delete:hover{
text-decoration:underline;
}

/* EMPTY */
.empty{
text-align:center;
color:#777;
font-weight:600;
padding:20px;
}

/* NOTE */
.note{
margin-top:20px;
background:#fff3cd;
border-left:5px solid #ffc107;
padding:12px;
border-radius:10px;
font-size:13px;
color:#856404;
}
</style>
</head>

<body>
<?php include "nav_buttons.php"; ?>
<div class="card">

<h2>📂 Candidate Upload Files</h2>
<p class="desc">
All candidate files uploaded using CSV or PDF are listed below.<br>
Deleting a file will <b>automatically remove all candidates</b> added from that file.
</p>

<table>
<tr>
<th>File Name</th>
<th>Type</th>
<th>Uploaded On</th>
<th>Action</th>
</tr>

<?php if($files->num_rows == 0){ ?>
<tr>
<td colspan="4" class="empty">
❌ No candidate files uploaded yet
</td>
</tr>
<?php } ?>

<?php while($f = $files->fetch_assoc()){ ?>
<tr>
<td><?php echo htmlspecialchars($f['file_name']); ?></td>

<td>
<span class="badge <?php echo $f['file_type']; ?>">
<?php echo strtoupper($f['file_type']); ?>
</span>
</td>

<td><?php echo date("d M Y, h:i A", strtotime($f['uploaded_on'])); ?></td>

<td>
<a class="delete"
href="delete_candidate_file.php?id=<?php echo $f['id']; ?>"
onclick="return confirm('Delete this file and ALL candidates added by it?')">
🗑 Delete
</a>
</td>
</tr>
<?php } ?>

</table>

<div class="note">
⚠ <b>Important:</b><br>
• Candidates uploaded via CSV or PDF <b>cannot be deleted individually</b><br>
• To remove them, you must delete the corresponding file from this page
</div>

</div>

</body>
</html>
