<?php
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Previous Elections</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
background:linear-gradient(135deg,#141e30,#243b55);
padding:40px 20px;
color:white;
}

/* TITLE */
h1{
text-align:center;
margin-bottom:40px;
}

/* CARD */
.box{
background:white;
color:black;
padding:25px;
border-radius:18px;
margin:0 auto 40px;
max-width:950px;
box-shadow:0 20px 40px rgba(0,0,0,0.35);
animation:fadeIn 0.6s ease;
}

@keyframes fadeIn{
from{opacity:0;transform:translateY(20px)}
to{opacity:1;transform:translateY(0)}
}

.box h2{
text-align:center;
margin-bottom:20px;
color:#243b55;
}

/* TABLE */
table{
width:100%;
border-collapse:collapse;
margin-bottom:25px;
}

th, td{
padding:12px;
text-align:center;
border-bottom:1px solid #ddd;
}

th{
background:#f5f7fa;
}

/* SYMBOL IMAGE */
.symbol img{
width:40px;
height:40px;
object-fit:contain;
}

/* CHART */
.chart-wrap{
display:flex;
justify-content:center;
}
canvas{
max-width:420px;
}
</style>
</head>

<body>

<?php include "nav_buttons.php"; ?>

<h1>📊 Previous Election Results</h1>

<?php
$elections = $conn->query("
    SELECT * FROM election
    WHERE status='completed' AND published=1
    ORDER BY id DESC
");

while($e = $elections->fetch_assoc()){

/* TOTAL VOTES FOR THIS ELECTION */
$totalVotes = $conn->query("
    SELECT COUNT(*) AS t FROM votes
    WHERE election_id='{$e['id']}'
")->fetch_assoc()['t'];

/* VOTES PER CANDIDATE (WITH PARTY + SYMBOL) */
$cand = $conn->query("
    SELECT 
        c.name,
        c.party,
        c.symbol,
        COUNT(v.id) AS votes
    FROM candidates c
    LEFT JOIN votes v 
        ON c.id = v.candidate_id
        AND v.election_id='{$e['id']}'
    GROUP BY c.id
");

$labels = [];
$data = [];
$colors = [];
?>

<div class="box">
<h2><?php echo htmlspecialchars($e['title']); ?></h2>

<table>
<tr>
<th>Symbol</th>
<th>Candidate</th>
<th>Party</th>
<th>Votes</th>
<th>Percentage</th>
</tr>

<?php
while($r = $cand->fetch_assoc()){

$percent = ($totalVotes > 0)
    ? round(($r['votes'] / $totalVotes) * 100, 2)
    : 0;

$labels[] = $r['name']." (".$r['party'].")";
$data[] = $r['votes'];
$colors[] = "hsl(".rand(0,360).",70%,60%)";
?>
<tr>

<td class="symbol">
<?php if(!empty($r['symbol']) && file_exists("uploads/symbols/".$r['symbol'])){ ?>
    <img src="uploads/symbols/<?php echo htmlspecialchars($r['symbol']); ?>">
<?php } else { ?>
    —
<?php } ?>
</td>

<td><?php echo htmlspecialchars($r['name']); ?></td>
<td><?php echo htmlspecialchars($r['party']); ?></td>
<td><?php echo $r['votes']; ?></td>
<td><?php echo $percent; ?>%</td>

</tr>
<?php } ?>
</table>

<div class="chart-wrap">
<canvas id="chart<?php echo $e['id']; ?>"></canvas>
</div>

<script>
new Chart(document.getElementById("chart<?php echo $e['id']; ?>"),{
type:'pie',
data:{
labels:<?php echo json_encode($labels); ?>,
datasets:[{
data:<?php echo json_encode($data); ?>,
backgroundColor:<?php echo json_encode($colors); ?>
}]
},
options:{
plugins:{
legend:{position:'bottom'}
}
}
});
</script>

</div>

<?php } ?>

</body>
</html>
