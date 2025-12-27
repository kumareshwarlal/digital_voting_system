<?php
include "db.php";
$msg = "";

if(isset($_POST['add'])){

    $name  = trim($_POST['name']);
    $party = trim($_POST['party']);
    $symbol = NULL;

    /* HANDLE SYMBOL IMAGE */
    if(isset($_FILES['symbol']) && $_FILES['symbol']['error'] == 0){

        $imgName = $_FILES['symbol']['name'];
        $tmpImg  = $_FILES['symbol']['tmp_name'];
        $ext = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

        if(in_array($ext, ['png','jpg','jpeg','svg'])){

            if(!is_dir("uploads/symbols")){
                mkdir("uploads/symbols",0777,true);
            }

            $symbol = time()."_".$imgName;
            move_uploaded_file($tmpImg, "uploads/symbols/".$symbol);

        } else {
            $msg = "❌ Only PNG, JPG, JPEG, SVG images allowed";
        }
    }

    if($msg=="" && $name!="" && $party!=""){

        if($conn->query("
            INSERT INTO candidates (name, party, symbol)
            VALUES (
                '".$conn->real_escape_string($name)."',
                '".$conn->real_escape_string($party)."',
                ".($symbol ? "'".$conn->real_escape_string($symbol)."'" : "NULL")."
            )
        ")){
            $msg = "✅ Candidate added successfully with symbol";
        } else {
            $msg = "❌ Error: ".$conn->error;
        }
    } elseif($msg=="") {
        $msg = "❌ All fields are required";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Candidate</title>

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

/* EVM MACHINE */
.machine{
    background:#e0e0e0;
    width:480px;
    padding:30px;
    border-radius:22px;
    box-shadow:0 25px 55px rgba(0,0,0,0.45);
}

/* HEADER */
.machine h2{
    text-align:center;
    margin-bottom:20px;
    color:#222;
}

/* EVM ROW */
.row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    background:white;
    padding:14px 16px;
    border-radius:12px;
    margin-bottom:15px;
    box-shadow:0 6px 14px rgba(0,0,0,0.2);
}

/* INPUT */
.row input{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:14px;
    outline:none;
}

/* FILE INPUT */
.row input[type=file]{
    padding:6px;
}

/* LED */
.led{
    width:14px;
    height:14px;
    background:#00c853;
    border-radius:50%;
    box-shadow:0 0 8px #00c853;
    margin-left:12px;
}

/* SUBMIT */
button{
    width:100%;
    margin-top:20px;
    padding:14px;
    background:#00c853;
    border:none;
    border-radius:14px;
    font-size:16px;
    color:white;
    cursor:pointer;
    font-weight:600;
}

button:hover{
    background:#00a843;
}

/* MESSAGE */
.msg{
    margin-top:15px;
    text-align:center;
    font-weight:600;
}

/* BACK */
.back{
    text-align:center;
    margin-top:15px;
}
.back a{
    text-decoration:none;
    color:#1e88e5;
    font-size:14px;
}
</style>
</head>

<body>

<?php include "nav_buttons.php"; ?>

<div class="machine">
<h2>🗳 Add Candidate (EVM)</h2>

<form method="post" enctype="multipart/form-data">

<!-- CANDIDATE NAME -->
<div class="row">
<input type="text" name="name" placeholder="Candidate Name" required>
<span class="led"></span>
</div>

<!-- PARTY NAME -->
<div class="row">
<input type="text" name="party" placeholder="Party Name" required>
<span class="led"></span>
</div>

<!-- SYMBOL IMAGE -->
<div class="row">
<input type="file" name="symbol" accept=".png,.jpg,.jpeg,.svg" required>
<span class="led"></span>
</div>

<button name="add">➕ Add Candidate</button>

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
