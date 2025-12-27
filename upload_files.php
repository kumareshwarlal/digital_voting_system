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

        $fileName = $_FILES['file']['name'];
        $fileTmp  = $_FILES['file']['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if(!in_array($fileExt, ["pdf","csv"])){
            $msg = "❌ Only PDF or CSV files are allowed";
        } else {

            if(!is_dir("uploads")){
                mkdir("uploads");
            }

            $newName = time()."_".$fileName;
            $uploadPath = "uploads/".$newName;

            if(move_uploaded_file($fileTmp, $uploadPath)){

                $conn->query("
                INSERT INTO voter_pdf_uploads (file_name, file_type, uploaded_on)
                VALUES ('$newName', '$fileExt', NOW())
                ");

                /* CSV → AUTO ADD VOTERS */
                if($fileExt == "csv"){
                    $file = fopen($uploadPath, "r");
                    $count = 0;

                    while(($row = fgetcsv($file)) !== false){
                        if(count($row) == 3){
                            $name = $conn->real_escape_string(trim($row[0]));
                            $voter_id = $conn->real_escape_string(trim($row[1]));
                            $aadhar = preg_replace("/\D/", "", $row[2]);

                            if(strlen($aadhar) == 12){
                                $conn->query("
                                INSERT IGNORE INTO voters (name, voter_id, aadhar, source_file)
                                VALUES ('$name','$voter_id','$aadhar','$newName')
                                ");
                                $count++;
                            }
                        }
                    }
                    fclose($file);
                    $msg = "✅ CSV uploaded & $count voters added successfully";
                }

                if($fileExt == "pdf"){
                    $msg = "✅ PDF uploaded successfully (verification only)";
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
<title>Upload Voter File</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{
height:100vh;
display:flex;
align-items:center;
justify-content:center;
background:linear-gradient(135deg,#1e3c72,#2a5298);
}
.card{
background:white;
width:460px;
padding:30px;
border-radius:18px;
box-shadow:0 20px 40px rgba(0,0,0,0.35);
text-align:center;
}
.card h2{color:#1e3c72;margin-bottom:15px;}
.format{
background:#f4f7fb;
border-left:5px solid #2a5298;
padding:12px;
text-align:left;
font-size:13px;
margin-bottom:15px;
border-radius:8px;
}
button{
width:100%;
padding:12px;
background:#2a5298;
color:white;
border:none;
border-radius:10px;
font-size:16px;
cursor:pointer;
}
.msg{margin-top:15px;font-weight:600;}
</style>
</head>

<body>
<?php include "nav_buttons.php"; ?>

<div class="card">
<h2>📤 Upload Voter File</h2>

<div class="format">
<b>CSV / PDF Format</b>
<code>Name,VoterID,123456789012</code>
</div>

<form method="post" enctype="multipart/form-data">
<input type="file" name="file" accept=".pdf,.csv" required>
<button name="upload">Upload File</button>
</form>

<?php if($msg!=""){ ?><div class="msg"><?= $msg ?></div><?php } ?>
</div>
</body>
</html>
