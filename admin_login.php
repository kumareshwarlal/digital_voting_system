<?php
session_start();
include "db.php";

$showPopup = false;
$popupMsg = "";
$popupType = ""; // success | error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === "" || $password === "") {
        $showPopup = true;
        $popupMsg = "Please fill all fields";
        $popupType = "error";
    } else {

        // ✅ PLAIN TEXT LOGIN (NO HASHING)
        $sql = "SELECT * FROM admin 
                WHERE username='$username' 
                AND password='$password'";

        $res = $conn->query($sql);

        if ($res && $res->num_rows === 1) {
            $_SESSION['admin'] = $username;
            $showPopup = true;
            $popupMsg = "Welcome Admin! Login successful";
            $popupType = "success";
        } else {
            $showPopup = true;
            $popupMsg = "Invalid username or password";
            $popupType = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
height:100vh;
background:linear-gradient(135deg,#667eea,#43cea2);
display:flex;
justify-content:center;
align-items:center;
}

/* LOGIN CARD */
.card{
background:white;
padding:40px;
border-radius:20px;
width:400px;
text-align:center;
position:relative;
box-shadow:0 20px 40px rgba(0,0,0,0.3);
}

/* HOME LINK */
.top a{
position:absolute;
top:15px;
right:20px;
text-decoration:none;
font-weight:600;
color:#333;
}

/* FORM */
input,button{
width:100%;
padding:12px;
margin:10px 0;
border-radius:10px;
border:1px solid #ccc;
font-size:15px;
}

button{
background:#667eea;
color:white;
border:none;
font-size:16px;
cursor:pointer;
}
button:hover{
background:#5a67d8;
}

/* POPUP */
.popup{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.6);
display:flex;
align-items:center;
justify-content:center;
z-index:999;
}

.popup-box{
padding:35px;
border-radius:20px;
width:380px;
text-align:center;
color:white;
animation:scaleIn 0.4s ease;
}

.success{
background:linear-gradient(135deg,#00c853,#2196f3);
}

.error{
background:linear-gradient(135deg,#ff5252,#ff1744);
}

.popup-box button{
margin-top:15px;
padding:10px 20px;
border:none;
border-radius:8px;
background:white;
font-weight:600;
cursor:pointer;
}

@keyframes scaleIn{
from{transform:scale(0.7);opacity:0}
to{transform:scale(1);opacity:1}
}
</style>
</head>

<body>

<div class="card">
<div class="top">
<a href="index.php">🏠 Home</a>
</div>

<h2>Admin Login</h2>

<form method="post">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit">LOGIN</button>
</form>
</div>

<?php if($showPopup){ ?>
<div class="popup" id="popup">
<div class="popup-box <?php echo $popupType; ?>">

<h2><?php echo $popupType === "success" ? "🎉 Success" : "❌ Error"; ?></h2>
<p><?php echo $popupMsg; ?></p>

<?php if($popupType === "error"){ ?>
<button onclick="closePopup()" style="color:#ff1744;">
🔁 Try Again
</button>
<?php } ?>

<?php if($popupType === "success"){ ?>
<p style="margin-top:10px;font-size:13px;">
Redirecting to dashboard...
</p>
<?php } ?>

</div>
</div>
<?php } ?>

<?php if($popupType === "success"){ ?>
<script>
setTimeout(() => {
    window.location.href = "admin_dashboard.php";
}, 2500);
</script>
<?php } ?>

<script>
function closePopup(){
    document.getElementById("popup").style.display = "none";
}
</script>

</body>
</html>
