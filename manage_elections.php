<?php
session_start();
include "db.php";

/* ===============================
   AUTO CLOSE ELECTIONS BY TIME
   =============================== */
$conn->query("
    UPDATE election
    SET status = 'completed'
    WHERE status = 'ongoing'
    AND end_time < NOW()
");

/* ADMIN CHECK */
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

/* FETCH ALL ELECTIONS */
$elections = $conn->query("
    SELECT * FROM election
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Elections</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

/* BACKGROUND */
body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
}

/* NAV BUTTONS */
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
    color:#203a43;
    box-shadow:0 6px 15px rgba(0,0,0,0.3);
    transition:0.3s;
}

.nav a:hover{
    background:#203a43;
    color:white;
}

/* CARD */
.card{
    background:white;
    width:760px;
    padding:35px;
    border-radius:22px;
    box-shadow:0 30px 60px rgba(0,0,0,0.35);
    animation:fadeIn 0.7s ease;
}

@keyframes fadeIn{
    from{opacity:0;transform:translateY(30px)}
    to{opacity:1;transform:translateY(0)}
}

.card h2{
    text-align:center;
    margin-bottom:30px;
    color:#203a43;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:14px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

th{
    background:#f4f6f8;
    font-weight:600;
}

tr:hover{
    background:#f1f1f1;
}

/* STATUS */
.status-ongoing{
    color:#1e88e5;
    font-weight:600;
}

.status-completed{
    color:#2e7d32;
    font-weight:600;
}

/* ACTIONS */
.delete{
    color:#e53935;
    font-weight:600;
    text-decoration:none;
}

.disabled{
    color:#999;
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

<!-- CARD -->
<div class="card">
    <h2>🗳 Manage Elections</h2>

    <table>
        <tr>
            <th>Election Title</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php while($e = $elections->fetch_assoc()){ ?>
        <tr>
            <td><?php echo htmlspecialchars($e['title']); ?></td>
            <td><?php echo $e['start_time']; ?></td>
            <td><?php echo $e['end_time']; ?></td>

            <td>
                <?php if($e['status'] === 'ongoing'){ ?>
                    <span class="status-ongoing">Ongoing</span>
                <?php } else { ?>
                    <span class="status-completed">Completed</span>
                <?php } ?>
            </td>

            <td>
                <?php if($e['status'] === 'completed'){ ?>
                    <a class="delete"
                       href="delete_election.php?id=<?php echo $e['id']; ?>"
                       onclick="return confirm('Delete this election permanently?')">
                        🗑 Delete
                    </a>
                <?php } else { ?>
                    <span class="disabled">Not Allowed</span>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
