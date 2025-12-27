<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

$msg = "";

/* SAVE ELECTION */
if(isset($_POST['save'])){
    $title = trim($_POST['title']);
    $start = $_POST['start_time'];
    $end   = $_POST['end_time'];

    if($title=="" || $start=="" || $end==""){
        $msg = "❌ All fields are required";
    } elseif(strtotime($start) >= strtotime($end)){
        $msg = "❌ End time must be after start time";
    } else {

        // Mark old elections as completed
        $conn->query("UPDATE election SET status='completed' WHERE status!='completed'");

        // Insert new election
        $sql = "INSERT INTO election (title, start_time, end_time, status, published)
                VALUES ('$title','$start','$end','upcoming',0)";

        if($conn->query($sql)){
            $msg = "✅ Election scheduled successfully";
        } else {
            $msg = "❌ Database Error: ".$conn->error;
        }
    }
}

/* AUTO UPDATE STATUS */
$conn->query("
UPDATE election 
SET status = CASE
    WHEN NOW() < start_time THEN 'upcoming'
    WHEN NOW() BETWEEN start_time AND end_time THEN 'ongoing'
    ELSE 'completed'
END
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Set Election</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

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
background:linear-gradient(135deg,#000428,#004e92);
}

/* CARD */
.card{
background:white;
width:460px;
padding:30px;
border-radius:15px;
box-shadow:0 15px 35px rgba(0,0,0,0.3);
}

/* TITLE */
.card h2{
text-align:center;
margin-bottom:20px;
color:#004e92;
}

/* INPUT */
.input-group{
margin-bottom:15px;
}
.input-group label{
display:block;
margin-bottom:6px;
font-weight:500;
}
.input-group input{
width:100%;
padding:12px;
border-radius:8px;
border:1px solid #ccc;
font-size:15px;
}

/* BUTTON */
button{
width:100%;
padding:12px;
background:#004e92;
color:white;
border:none;
border-radius:8px;
font-size:16px;
cursor:pointer;
transition:0.3s;
}
button:hover{
background:#000428;
}

/* MESSAGE */
.msg{
margin-top:15px;
text-align:center;
font-size:14px;
font-weight:500;
}

/* BACK */
.back{
text-align:center;
margin-top:15px;
}
.back a{
text-decoration:none;
color:#004e92;
font-size:14px;
}
</style>
</head>

<body>
<?php include "nav_buttons.php"; ?>

<div class="card">
<h2>🗓 Set Election</h2>

<form method="post">

<div class="input-group">
<label>Election Title</label>
<input type="text" name="title" placeholder="e.g. Student Council Election 2025" required>
</div>

<div class="input-group">
<label>Start Date & Time</label>
<input type="datetime-local" name="start_time" required>
</div>

<div class="input-group">
<label>End Date & Time</label>
<input type="datetime-local" name="end_time" required>
</div>

<button name="save">Save Election</button>

<?php if($msg!=""){ ?>
<div class="msg"><?php echo $msg; ?></div>
<?php } ?>

</form>

<div class="back">
<a href="admin_dashboard.php">⬅ Back to Dashboard</a>
</div>
</div>

</body>
</html>
