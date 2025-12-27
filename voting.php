<?php
session_start();
include "db.php";

if(!isset($_SESSION['voter'])){
    header("Location: voter_login.php");
    exit;
}

$voter = $_SESSION['voter'];
$msg = "";
$showPopup = false;

/* HANDLE VOTE */
if(isset($_POST['vote'])){
    $election_id  = (int)$_POST['election_id'];
    $candidate_id = (int)$_POST['candidate'];

    $check = $conn->query("
        SELECT id FROM votes
        WHERE voter_id='{$voter['id']}'
        AND election_id='$election_id'
    ");

    if($check->num_rows > 0){
        $msg = "❌ You have already voted in this election";
    } else {
        $e = $conn->query("
            SELECT id FROM election
            WHERE id='$election_id'
            AND status='ongoing'
        ")->fetch_assoc();

        if(!$e){
            $msg = "❌ Election is not active";
        } else {
            $conn->query("
                INSERT INTO votes (voter_id, candidate_id, election_id)
                VALUES ('{$voter['id']}', '$candidate_id', '$election_id')
            ");
            $showPopup = true;
        }
    }
}

/* FETCH ONGOING ELECTIONS */
$elections = $conn->query("
    SELECT * FROM election
    WHERE status='ongoing'
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Cast Your Vote</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Poppins',sans-serif;
    min-height:100vh;
    padding:40px;
    color:white;
    background:
      radial-gradient(circle at top,#222,#000 70%),
      linear-gradient(180deg,#000,#111);
}

.container{max-width:900px;margin:auto;}

.card{
    background:#fdfdfd;
    color:#000;
    padding:35px;
    margin-bottom:40px;
    border-radius:22px;
    box-shadow:
        0 40px 90px rgba(0,0,0,0.9),
        inset 0 1px 0 rgba(255,255,255,0.8);
}

.evm-table{
    width:100%;
    border-collapse:collapse;
}

.evm-table th, .evm-table td{
    padding:16px;
    text-align:center;
    border-bottom:1px solid #ccc;
}

.evm-table th{
    background:#f0f0f0;
}

.symbol img{
    width:42px;
    height:42px;
}

.vote-btn{
    width:46px;
    height:46px;
    border-radius:50%;
    background:linear-gradient(145deg,#1e88e5,#0d47a1);
    border:4px solid white;
    cursor:pointer;
    box-shadow:
        inset 0 4px 8px rgba(255,255,255,0.5),
        0 8px 14px rgba(0,0,0,0.6);
    transition:.2s;
}

.vote-btn:active{transform:scale(0.88);}

.vote-btn.active{
    background:linear-gradient(145deg,#00e676,#00c853);
    box-shadow:
        0 0 30px rgba(0,255,120,0.9),
        inset 0 4px 8px rgba(255,255,255,0.7);
}

.vote-btn.disabled{
    background:#999;
    cursor:not-allowed;
    box-shadow:none;
}

button.submit{
    width:100%;
    margin-top:25px;
    padding:16px;
    background:linear-gradient(145deg,#00c853,#009624);
    border:none;
    border-radius:14px;
    font-size:16px;
    color:white;
    cursor:pointer;
    box-shadow:0 10px 25px rgba(0,0,0,0.6);
}

.popup{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.85);
    display:flex;
    align-items:center;
    justify-content:center;
}

.popup-box{
    background:linear-gradient(145deg,#00c853,#1e88e5);
    padding:40px;
    border-radius:25px;
    width:420px;
    text-align:center;
    color:white;
    box-shadow:0 35px 80px rgba(0,0,0,.9);
    animation:zoom .5s ease;
}

@keyframes zoom{
    from{transform:scale(.6);opacity:0}
    to{transform:scale(1);opacity:1}
}
</style>
</head>

<body>

<div class="container">
<h1 style="text-align:center;margin-bottom:30px;">🗳 Ongoing Elections</h1>

<?php if($msg!=""){ ?>
<p style="text-align:center;color:#ff5252;font-weight:600;"><?php echo $msg; ?></p>
<?php } ?>

<?php while($e = $elections->fetch_assoc()){ ?>

<div class="card">
<h2><?php echo htmlspecialchars($e['title']); ?></h2>

<?php
$check = $conn->query("
    SELECT id FROM votes
    WHERE voter_id='{$voter['id']}'
    AND election_id='{$e['id']}'
");
?>

<?php if($check->num_rows > 0){ ?>
<p style="text-align:center;color:red;font-weight:600;">
❌ You have already voted in this election
</p>
<?php } else { ?>

<form method="post">
<input type="hidden" name="election_id" value="<?php echo $e['id']; ?>">
<input type="hidden" name="candidate" id="selectedCandidate">

<table class="evm-table">
<tr>
<th>S.No</th>
<th>Candidate</th>
<th>Symbol</th>
<th>Vote</th>
</tr>

<?php
$i=1;
$candidates = $conn->query("SELECT * FROM candidates");
while($c = $candidates->fetch_assoc()){
?>
<tr>
<td><?php echo $i++; ?></td>
<td><?php echo htmlspecialchars($c['name']." (".$c['party'].")"); ?></td>
<td class="symbol">
<?php if(!empty($c['symbol']) && file_exists("uploads/symbols/".$c['symbol'])){ ?>
<img src="uploads/symbols/<?php echo htmlspecialchars($c['symbol']); ?>">
<?php } else { echo "—"; } ?>
</td>
<td>
<div class="vote-btn"
     data-id="<?php echo $c['id']; ?>"
     onclick="selectVote(this)">
</div>
</td>
</tr>
<?php } ?>
</table>

<button class="submit" name="vote">Submit Vote</button>
</form>

<?php } ?>
</div>
<?php } ?>
</div>

<!-- 🔊 VOTE SOUND -->
<audio id="voteSound" preload="auto">
<source src="https://actions.google.com/sounds/v1/alarms/beep_short.ogg" type="audio/ogg">
</audio>

<?php if($showPopup){ ?>
<div class="popup">
<div class="popup-box">
<h2>🎉 Vote Recorded</h2>
<p>Your vote has been securely stored</p>
<p>Redirecting...</p>
</div>
</div>

<script>
document.getElementById("voteSound").play();
setTimeout(()=>location.href="voter_dashboard.php",3000);
</script>
<?php } ?>

<script>
let voted = false;

function selectVote(btn){
    if(voted) return;
    voted = true;

    btn.classList.add('active');
    document.getElementById('selectedCandidate').value = btn.dataset.id;

    const sound = document.getElementById("voteSound");
    sound.currentTime = 0;
    sound.play();

    document.querySelectorAll('.vote-btn').forEach(b=>{
        if(b !== btn){
            b.classList.add('disabled');
        }
    });
}
</script>

</body>
</html>
