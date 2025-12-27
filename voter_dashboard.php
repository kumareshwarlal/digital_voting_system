<?php
session_start();

if(!isset($_SESSION['voter'])){
    header("Location: voter_login.php");
    exit;
}

$voter = $_SESSION['voter'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Voter Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
height:100vh;
display:flex;
align-items:center;
justify-content:center;
background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
}

/* CARD */
.dashboard{
background:white;
width:420px;
padding:35px;
border-radius:18px;
box-shadow:0 20px 40px rgba(0,0,0,0.3);
text-align:center;
animation:fadeIn 1s ease;
}

@keyframes fadeIn{
from{opacity:0;transform:translateY(20px)}
to{opacity:1;transform:translateY(0)}
}

.dashboard h2{
color:#2c5364;
margin-bottom:10px;
}

.dashboard p{
font-size:15px;
color:#555;
margin-bottom:25px;
}

/* BUTTONS */
.actions a{
display:flex;
align-items:center;
justify-content:center;
gap:10px;
padding:12px;
margin-bottom:12px;
text-decoration:none;
border-radius:10px;
font-weight:500;
transition:0.3s;
}

.vote{
background:#00c853;
color:white;
}
.vote:hover{background:#00a845;}

.history{
background:#2196f3;
color:white;
}
.history:hover{background:#1e88e5;}

.logout{
background:#e53935;
color:white;
}
.logout:hover{background:#d32f2f;}

.actions i{
font-size:18px;
}
</style>
</head>

<body>
<?php include "nav_buttons.php"; ?>

<div class="dashboard">

<h2>Welcome <?php echo htmlspecialchars($voter['name']); ?> 🎉</h2>
<p>You are logged in successfully</p>

<div class="actions">
<a href="voting.php" class="vote">
<i class="fa-solid fa-check-to-slot"></i> Cast Your Vote
</a>

<a href="previous_elections.php" class="history">
<i class="fa-solid fa-clock-rotate-left"></i> Previous Election Results
</a>

<a href="logout.php" class="logout">
<i class="fa-solid fa-right-from-bracket"></i> Logout
</a>
</div>

</div>

</body>
</html>
