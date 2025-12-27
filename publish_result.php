<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

$msg = "";

/* PUBLISH RESULT */
if(isset($_GET['publish_id'])){
    $eid = $_GET['publish_id'];

    $conn->query("
        UPDATE election 
        SET published=1 
        WHERE id='$eid'
    ");

    $msg = "✅ Election result published successfully";
}

/* FETCH COMPLETED & UNPUBLISHED ELECTIONS */
$elections = $conn->query("
    SELECT * FROM election 
    WHERE status='completed' AND published=0
    ORDER BY end_time DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Publish Election Result</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
min-height:100vh;
display:flex;
align-items:center;
justify-content:center;
background:linear-gradient(135deg,#141e30,#243b55);
}

/* CARD */
.card{
background:white;
width:600px;
padding:30px;
border-radius:18px;
box-shadow:0 20px 40px rgba(0,0,0,0.3);
}

.card h2{
text-align:center;
margin-bottom:20px;
color:#243b55;
}

.election{
padding:15px;
border:1px solid #ddd;
border-radius:10px;
margin-bottom:15px;
}

.election h4{
margin-bottom:5px;
color:#333;
}

.election p{
font-size:14px;
color:#666;
margin-bottom:8px;
}

.publish-btn{
display:inline-block;
padding:8px 15px;
background:#00c853;
color:white;
border-radius:8px;
text-decoration:none;
font-size:14px;
}

.publish-btn:hover{
background:#00a845;
}

.msg{
text-align:center;
margin-bottom:15px;
font-weight:500;
color:#2e7d32;
}

.empty{
text-align:center;
color:#999;
}
.back{
text-align:center;
margin-top:15px;
}
.back a{
text-decoration:none;
color:#243b55;
font-size:14px;
}
</style>
</head>

<body>
<?php include "nav_buttons.php"; ?>

<div class="card">

<h2>📢 Publish Election Result</h2>

<?php if($msg!=""){ ?>
<div class="msg"><?php echo $msg; ?></div>
<?php } ?>

<?php if($elections && $elections->num_rows > 0){ ?>

<?php while($e = $elections->fetch_assoc()){ ?>
<div class="election">
<h4><?php echo htmlspecialchars($e['title']); ?></h4>
<p>
<b>Ended on:</b> <?php echo $e['end_time']; ?>
</p>
<a class="publish-btn" href="?publish_id=<?php echo $e['id']; ?>">
Publish Result
</a>
</div>
<?php } ?>

<?php } else { ?>

<div class="empty">
No completed elections available for publishing.
</div>

<?php } ?>

<div class="back">
<a href="admin_dashboard.php">⬅ Back to Dashboard</a>
</div>

</div>

</body>
</html>
