<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

/* BACKGROUND */
body{
min-height:100vh;
background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
padding-top:70px;
}

/* HEADER */
h2{
text-align:center;
color:white;
margin-bottom:30px;
font-size:28px;
}

/* GRID */
.menu{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:25px;
max-width:1000px;
margin:auto;
padding:0 20px;
}

/* BOX */
.menu a{
background:white;
color:#203a43;
padding:25px 20px;
text-decoration:none;
border-radius:18px;
font-weight:600;
text-align:center;
box-shadow:0 15px 30px rgba(0,0,0,0.3);
transition:0.3s;
}

/* ICON */
.menu a span{
display:block;
font-size:32px;
margin-bottom:10px;
}

/* HOVER */
.menu a:hover{
transform:translateY(-8px);
background:#203a43;
color:white;
}
</style>
</head>

<body>

<?php include "nav_buttons.php"; ?>

<h2>🛠 Admin Dashboard</h2>

<div class="menu">

<a href="add_voter.php">
<span>➕</span>
Add Voter
</a>

<a href="upload_files.php">
<span>📄</span>
Upload Voter files
</a>

<a href="view_uploaded_files.php">
<span>📂</span>
View Uploaded files
</a>

<a href="view_voters.php">
<span>🗂</span>
View Voters
</a>

<!-- ✅ NEW LINK ADDED -->
<a href="upload_candidates.php">
<span>📥</span>
Upload Candidates (CSV / PDF)
</a>

<a href="view_candidates.php">
<span>👥</span>
View Candidates
</a>

<a href="view_candidate_files.php">
    <span>🗑</span>
    Delete Candidate Files (CSV / PDF)
</a>

<a href="add_candidate.php">
<span>🧑‍💼</span>
Add Candidate
</a>

<a href="manage_elections.php">
<span>🗳</span>
Manage Elections
</a>

<a href="set_election.php">
<span>⏰</span>
Set Election Time
</a>

<a href="publish_result.php">
<span>📢</span>
Publish Result
</a>

<a href="logout.php">
<span>🚪</span>
Logout
</a>

</div>
