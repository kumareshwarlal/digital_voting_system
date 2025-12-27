<?php
session_start();
include "db.php";

$msg = "";

if(isset($_POST['login'])){

    $login_id = isset($_POST['login_id']) ? trim($_POST['login_id']) : "";
    $password = isset($_POST['password']) ? md5(trim($_POST['password'])) : "";

    if($login_id=="" || $password==""){
        $msg = "❌ Please fill all fields";
    } else {

        $sql = "SELECT * FROM voters 
                WHERE (voter_id='$login_id' OR aadhar='$login_id') 
                AND password='$password'";

        $res = $conn->query($sql);

        if($res && $res->num_rows == 1){
            $_SESSION['voter'] = $res->fetch_assoc();
            header("Location: voter_dashboard.php");
            exit;
        } else {
            $msg = "❌ Invalid login details";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Voter Login</title>

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

.card{
background:white;
width:400px;
padding:30px;
border-radius:15px;
box-shadow:0 15px 35px rgba(0,0,0,0.3);
}

h2{
text-align:center;
margin-bottom:20px;
color:#243b55;
}

.input-group{
margin-bottom:15px;
}

.input-group label{
display:block;
margin-bottom:6px;
}

.input-group input{
width:100%;
padding:12px;
border-radius:8px;
border:1px solid #ccc;
}

button{
width:100%;
padding:12px;
background:#243b55;
color:white;
border:none;
border-radius:8px;
font-size:16px;
cursor:pointer;
}

.msg{
margin-top:15px;
text-align:center;
color:red;
font-size:14px;
}
</style>
</head>

<body>
<?php include "nav_buttons.php"; ?>

<div class="card">
<h2>🗳 Voter Login</h2>

<form method="post">

<div class="input-group">
<label>Voter ID / Aadhar</label>
<input type="text" name="login_id" placeholder="Enter Voter ID or Aadhar" required>
</div>

<div class="input-group">
<label>Password</label>
<input type="password" name="password" placeholder="Password = Voter ID" required>
</div>

<button name="login">Login</button>

<?php if($msg!=""){ ?>
<div class="msg"><?php echo $msg; ?></div>
<?php } ?>

</form>
</div>

</body>
</html>
