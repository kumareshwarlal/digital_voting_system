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

/* FETCH VOTERS */
$voters = $conn->query("
    SELECT * FROM voters ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Voters</title>

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
    background:linear-gradient(135deg,#1f4037,#99f2c8);
}

/* NAV */
.nav{
    position:fixed;
    top:20px;
    left:20px;
    display:flex;
    gap:10px;
}

.nav a{
    padding:8px 14px;
    background:white;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
    color:#1f4037;
    box-shadow:0 4px 10px rgba(0,0,0,0.3);
}

.nav a:hover{
    background:#1f4037;
    color:white;
}

/* CARD */
.card{
    background:white;
    width:850px;
    padding:30px;
    border-radius:20px;
    box-shadow:0 20px 40px rgba(0,0,0,0.35);
}

h2{
    text-align:center;
    margin-bottom:20px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

th{
    background:#f5f5f5;
}

/* BADGES */
.badge{
    padding:4px 12px;
    border-radius:12px;
    font-size:12px;
    font-weight:600;
    color:white;
}

.manual{ background:#4caf50; }
.csv{ background:#1e88e5; }

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

/* NOTE */
.note{
    margin-top:12px;
    text-align:center;
    color:#e53935;
    font-weight:600;
}
</style>
</head>

<body>

<!-- NAV -->
<div class="nav">
    <a href="javascript:history.back()">⬅ Back</a>
    <a href="admin_dashboard.php">🏠 Home</a>
</div>

<!-- MAIN CARD -->
<div class="card">
<h2>👥 Voters List</h2>

<table>
<tr>
    <th>Name</th>
    <th>Voter ID</th>
    <th>Aadhar</th>
    <th>Type</th>
    <th>Action</th>
</tr>

<?php while($v = $voters->fetch_assoc()){ ?>
<tr>
    <td><?php echo htmlspecialchars($v['name']); ?></td>
    <td><?php echo htmlspecialchars($v['voter_id']); ?></td>
    <td><?php echo htmlspecialchars($v['aadhar']); ?></td>

    <td>
        <?php if($v['source_file'] == NULL){ ?>
            <span class="badge manual">Manual</span>
        <?php } else { ?>
            <span class="badge csv">CSV</span>
        <?php } ?>
    </td>

    <td>
        <?php if($electionRunning){ ?>
            <span class="disabled">❌ Locked</span>
        <?php } else { ?>
            <a class="delete"
               href="delete_voter.php?id=<?php echo $v['id']; ?>"
               onclick="return confirm('Delete this voter permanently?')">
               🗑 Delete
            </a>
        <?php } ?>
    </td>
</tr>
<?php } ?>

</table>

<?php if($electionRunning){ ?>
<p class="note">⚠ Cannot delete voters while election is ongoing</p>
<?php } ?>

</div>

</body>
</html>
