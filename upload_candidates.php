<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

$msg = "";

if(isset($_POST['upload'])){

    if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){

        $original = $_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));

        if(!in_array($ext,['csv','pdf'])){
            $msg = "❌ Only CSV or PDF files are allowed";
        } else {

            /* CREATE REQUIRED FOLDERS */
            if(!is_dir("uploads")) mkdir("uploads",0777,true);
            if(!is_dir("uploads/symbols")) mkdir("uploads/symbols",0777,true);

            $newName = time()."_".$original;
            $path = "uploads/".$newName;

            if(move_uploaded_file($tmp,$path)){

                /* SAVE FILE RECORD */
                $conn->query("
                    INSERT INTO candidate_file_uploads
                    (file_name,file_type,uploaded_on)
                    VALUES ('$newName','$ext',NOW())
                ");

                $count = 0;

                /* CSV → AUTO ADD CANDIDATES */
                if($ext === "csv"){
                    $file = fopen($path,"r");
                    fgetcsv($file); // skip header

                    while(($row = fgetcsv($file)) !== false){

                        // Expect exactly: name, party, symbol
                        if(count($row) == 3){

                            $name   = trim($row[0]);
                            $party  = trim($row[1]);
                            $symbol = trim($row[2]);

                            if($name != ""){

                                /* VALIDATE SYMBOL FILE PATH */
                                if($symbol == "" || !file_exists("uploads/symbols/".$symbol)){
                                    $symbol = NULL;
                                }

                                $conn->query("
                                    INSERT INTO candidates
                                    (name, party, symbol, source_file)
                                    VALUES (
                                        '".$conn->real_escape_string($name)."',
                                        '".$conn->real_escape_string($party)."',
                                        ".($symbol ? "'".$conn->real_escape_string($symbol)."'" : "NULL").",
                                        '$newName'
                                    )
                                ");

                                $count++;
                            }
                        }
                    }

                    fclose($file);
                    $msg = "✅ $count candidates added successfully from CSV";
                }

                /* PDF → RECORD ONLY */
                if($ext === "pdf"){
                    $msg = "✅ PDF uploaded successfully (reference only)";
                }

            } else {
                $msg = "❌ File upload failed";
            }
        }
    } else {
        $msg = "❌ Please select a file";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Upload Candidates</title>

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
width:540px;
padding:35px;
border-radius:22px;
box-shadow:0 25px 50px rgba(0,0,0,0.35);
animation:fadeIn .8s ease;
}

@keyframes fadeIn{
from{opacity:0;transform:translateY(20px)}
to{opacity:1;transform:translateY(0)}
}

/* HEADER */
.card h2{
text-align:center;
color:#203a43;
margin-bottom:10px;
}

.desc{
text-align:center;
font-size:14px;
color:#555;
margin-bottom:20px;
}

/* INPUT */
input[type=file]{
width:100%;
padding:12px;
border:1px solid #ccc;
border-radius:10px;
margin-bottom:15px;
}

/* BUTTON */
button{
width:100%;
padding:14px;
background:#00c853;
border:none;
border-radius:12px;
font-size:16px;
color:white;
font-weight:600;
cursor:pointer;
transition:.3s;
}

button:hover{
background:#009624;
}

/* MESSAGE */
.msg{
text-align:center;
font-weight:600;
margin-top:15px;
}

/* FORMAT BOX */
.format{
margin-top:20px;
background:#f4f7fb;
border-left:5px solid #2196f3;
padding:14px;
border-radius:12px;
font-size:13px;
color:#333;
}

.format code{
display:block;
background:#e9eef5;
padding:8px;
margin-top:6px;
border-radius:8px;
font-size:12px;
}

/* NOTE */
.note{
margin-top:15px;
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

<h2>📥 Upload Candidates</h2>
<p class="desc">
Upload candidates using <b>CSV</b> (auto insert) or <b>PDF</b> (record only).
</p>

<form method="post" enctype="multipart/form-data">
<input type="file" name="file" accept=".csv,.pdf" required>
<button name="upload">Upload File</button>
</form>

<?php if($msg!=""){ ?>
<p class="msg"><?php echo $msg; ?></p>
<?php } ?>

<div class="format">
<b>📊 CSV Format (Auto Add Candidates)</b>
<code>
name,party,symbol<br>
M K Stalin,DMK,dmk.png<br>
Annamalai,BJP,bjp.png
</code>
</div>

<div class="note">
⚠ <b>Important:</b><br>
• Symbol images must exist inside <b>uploads/symbols/</b><br>
• File names are case-sensitive<br>
• CSV/PDF candidates can be removed only by deleting the uploaded file
</div>

</div>

</body>
</html>
