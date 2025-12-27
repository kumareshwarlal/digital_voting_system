<?php
include "db.php";

$msg = "";

if(isset($_POST['add'])){
    $name   = $_POST['name'];
    $voter  = $_POST['voter'];
    $aadhar = $_POST['aadhar'];
    $pass   = md5($voter); // default password

    if($conn->query("INSERT INTO voters(name,voter_id,aadhar,password)
        VALUES('$name','$voter','$aadhar','$pass')")){
        $msg = "Voter added successfully";
    } else {
        $msg = "Error: Voter ID or Aadhar already exists";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Voter</title>

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
background:linear-gradient(135deg,#141e30,#243b55);
}

/* CARD */
.card{
background:white;
width:420px;
padding:30px;
border-radius:15px;
box-shadow:0 15px 35px rgba(0,0,0,0.3);
}

/* TITLE */
.card h2{
text-align:center;
margin-bottom:20px;
color:#243b55;
}

/* INPUTS */
.input-group{
margin-bottom:15px;
}

.input-group label{
display:block;
margin-bottom:6px;
font-weight:500;
color:#333;
}

.input-group input{
width:100%;
padding:12px;
border:1px solid #ccc;
border-radius:8px;
font-size:15px;
outline:none;
}

.input-group input:focus{
border-color:#243b55;
}

/* BUTTON */
button{
width:100%;
padding:12px;
background:#243b55;
color:white;
border:none;
border-radius:8px;
font-size:16px;
cursor:pointer;
transition:0.3s;
}

button:hover{
background:#141e30;
}

/* MESSAGE */
.msg{
margin-top:15px;
text-align:center;
font-size:14px;
color:green;
}

/* BACK LINK */
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
<h2>➕ Add New Voter</h2>

<form method="post">

<div class="input-group">
<label>Voter Name</label>
<input type="text" name="name" placeholder="Enter full name" required>
</div>

<div class="input-group">
<label>Voter ID</label>
<input type="text" name="voter" placeholder="Enter Voter ID" required>
</div>

<div class="input-group">
<label>Aadhar Number</label>
<input type="text" name="aadhar" placeholder="Enter Aadhar number" required>
</div>

<button name="add">Add Voter</button>

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
