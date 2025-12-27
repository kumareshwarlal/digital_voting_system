<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

/* CHECK IF ANY ELECTION IS ONGOING */
$ongoing = $conn->query("
    SELECT id FROM election WHERE status='ongoing' LIMIT 1
");
$electionRunning = ($ongoing->num_rows > 0);

/* FETCH CANDIDATES */
$candidates = $conn->query("
    SELECT * FROM candidates ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Candidates</title>

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
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#232526,#414345);
}

/* NAV */
.nav{
    position:fixed;
    top:20px;
    left:20px;
    display:flex;
    gap:12px;
}

.nav a{
    padding:10px 16px;
    background:white;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
    color:#333;
    box-shadow:0 4px 12px rgba(0,0,0,0.3);
}

/* CARD */
.card{
    background:white;
    width:980px;
    padding:35px;
    border-radius:20px;
    box-shadow:0 25px 50px rgba(0,0,0,0.35);
}

h2{
    text-align:center;
    margin-bottom:25px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:14px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

th{
    background:#f4f4f4;
    font-weight:600;
}

/* SYMBOL IMAGE */
.symbol img{
    width:42px;
    height:42px;
    object-fit:contain;
}

/* ACTION */
.delete{
    color:#e53935;
    font-weight:600;
    text-decoration:none;
}

.disabled{
    color:#999;
    font-weight:600;
}

/* BADGES */
.badge{
    padding:5px 12px;
    border-radius:12px;
    font-size:12px;
    font-weight:600;
}

.manual{ background:#4caf50; color:white; }
.file{ background:#ff9800; color:white; }

/* NOTE */
.note{
    margin-top:18px;
    text-align:center;
    color:#e53935;
    font-weight:600;
}
</style>
</head>

<body>

<!-- NAVIGATION -->
<div class="nav">
    <a href="javascript:history.back()">⬅ Back</a>
    <a href="admin_dashboard.php">🏠 Home</a>
</div>

<!-- MAIN CARD -->
<div class="card">
<h2>👥 Candidates List</h2>

<table>
<tr>
    <th>Symbol</th>
    <th>Name</th>
    <th>Party</th>
    <th>Type</th>
    <th>Action</th>
</tr>

<?php while($c = $candidates->fetch_assoc()){ ?>
<tr>

    <!-- SYMBOL -->
    <td class="symbol">
        <?php if(!empty($c['symbol']) && file_exists("uploads/symbols/".$c['symbol'])){ ?>
            <img src="uploads/symbols/<?php echo htmlspecialchars($c['symbol']); ?>">
        <?php } else { ?>
            —
        <?php } ?>
    </td>

    <td><?php echo htmlspecialchars($c['name']); ?></td>
    <td><?php echo htmlspecialchars($c['party']); ?></td>

    <td>
        <?php if($c['source_file'] == NULL){ ?>
            <span class="badge manual">Manual</span>
        <?php } else { ?>
            <span class="badge file">CSV / PDF</span>
        <?php } ?>
    </td>

    <td>
        <?php if($electionRunning){ ?>
            <span class="disabled">❌ Locked</span>
        <?php } else { ?>
            <a class="delete"
               href="delete_candidate.php?id=<?php echo $c['id']; ?>"
               onclick="return confirm('Delete this candidate permanently?')">
               🗑 Delete
            </a>
        <?php } ?>
    </td>

</tr>
<?php } ?>

</table>

<?php if($electionRunning){ ?>
<p class="note">⚠ Candidates cannot be deleted while election is ongoing</p>
<?php } ?>

<p class="note">
📁 CSV / PDF candidates can be deleted individually OR by deleting the file
</p>

</div>
</body>
</html>
