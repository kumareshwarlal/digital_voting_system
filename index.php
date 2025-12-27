<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Online Voting System</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}

body{
background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
color:white;
overflow-x:hidden;
}

/* HEADER */
header{
display:flex;
justify-content:space-between;
align-items:center;
padding:20px 60px;
}
.logo{
font-size:28px;
font-weight:700;
}
header a{
text-decoration:none;
margin-left:15px;
padding:10px 20px;
background:#00ff99;
color:#000;
border-radius:8px;
font-weight:600;
}

/* HERO */
.hero{
display:flex;
align-items:center;
justify-content:space-between;
padding:80px 60px;
}
.hero-text{max-width:600px;}
.hero-text h1{font-size:46px;margin-bottom:15px;}
.hero-text p{font-size:18px;line-height:1.6;opacity:.9;}
.hero img{
width:420px;
animation:float 3s infinite ease-in-out;
}
@keyframes float{
0%{transform:translateY(0)}
50%{transform:translateY(-15px)}
100%{transform:translateY(0)}
}

/* SECTION */
.section{padding:70px 60px;}
.section h2{
text-align:center;
margin-bottom:20px;
font-size:34px;
}
.section p.center{
text-align:center;
max-width:900px;
margin:0 auto 40px;
opacity:.9;
}

/* FLIP CARDS */
.cards{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
gap:30px;
}
.card{background:transparent;perspective:1000px;}
.card-inner{
position:relative;
width:100%;
height:260px;
transform-style:preserve-3d;
transition:transform .8s;
}
.card:hover .card-inner{transform:rotateY(180deg);}
.card-front,.card-back{
position:absolute;
width:100%;
height:100%;
border-radius:15px;
padding:25px;
backface-visibility:hidden;
display:flex;
flex-direction:column;
justify-content:center;
align-items:center;
text-align:center;
}
.card-front{background:rgba(255,255,255,.1);}
.card-back{
background:#00ff99;
color:black;
transform:rotateY(180deg);
}
.card i{font-size:45px;margin-bottom:15px;}

/* STEPS */
.steps{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
gap:30px;
}
.step{
background:rgba(255,255,255,.08);
padding:30px;
border-radius:15px;
text-align:center;
}
.step span{
font-size:36px;
font-weight:700;
color:#00ff99;
}

/* FOOTER */
footer{
background:#000;
padding:20px;
text-align:center;
margin-top:40px;
font-size:14px;
opacity:.8;
}
</style>
</head>

<body>

<!-- HEADER -->
<header>
<div class="logo">🗳 Online Voting System</div>
<div>
<a href="admin_login.php">Admin Login</a>
<a href="voter_login.php">Voter Login</a>
</div>
</header>

<!-- HERO -->
<section class="hero">
<div class="hero-text">
<h1>Secure & Smart Online Voting</h1>
<p>
A modern web-based voting platform designed to conduct elections digitally
using Aadhar or Voter ID with complete transparency, accuracy, and security.
</p>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/942/942748.png">
</section>

<!-- BRIEF OVERVIEW -->
<section class="section">
<h2>Brief Overview</h2>
<p class="center">
The Online Voting System allows voters to cast votes securely through the internet
within a defined time window. The administrator controls voter registration,
candidate approval, election scheduling, and result publication.
</p>
</section>

<!-- CORE FEATURES -->
<section class="section">
<h2>Core Features</h2>
<div class="cards">

<div class="card">
<div class="card-inner">
<div class="card-front">
<i class="fa-solid fa-user-shield"></i>
<h3>Secure Authentication</h3>
</div>
<div class="card-back">
<p>Login using verified voter data uploaded by the administrator.</p>
</div>
</div>
</div>

<div class="card">
<div class="card-inner">
<div class="card-front">
<i class="fa-solid fa-person-booth"></i>
<h3>One Vote Policy</h3>
</div>
<div class="card-back">
<p>Each voter can vote only once per election.</p>
</div>
</div>
</div>

<div class="card">
<div class="card-inner">
<div class="card-front">
<i class="fa-solid fa-calendar-check"></i>
<h3>Time Controlled</h3>
</div>
<div class="card-back">
<p>Voting opens and closes automatically based on admin timing.</p>
</div>
</div>
</div>

<div class="card">
<div class="card-inner">
<div class="card-front">
<i class="fa-solid fa-users-gear"></i>
<h3>Admin Control</h3>
</div>
<div class="card-back">
<p>Admin manages voters, candidates, elections, and results.</p>
</div>
</div>
</div>

<div class="card">
<div class="card-inner">
<div class="card-front">
<i class="fa-solid fa-chart-pie"></i>
<h3>Auto Results</h3>
</div>
<div class="card-back">
<p>Votes are counted automatically with percentages.</p>
</div>
</div>
</div>

<div class="card">
<div class="card-inner">
<div class="card-front">
<i class="fa-solid fa-clock-rotate-left"></i>
<h3>History</h3>
</div>
<div class="card-back">
<p>Previous election results can be viewed after publication.</p>
</div>
</div>
</div>

</div>
</section>

<!-- HOW IT WORKS -->
<section class="section">
<h2>How It Works</h2>
<div class="steps">

<div class="step">
<span>1</span>
<p>Admin uploads verified voter data and candidates.</p>
</div>

<div class="step">
<span>2</span>
<p>Election timing is scheduled by the administrator.</p>
</div>

<div class="step">
<span>3</span>
<p>Voters login securely and cast their vote.</p>
</div>

<div class="step">
<span>4</span>
<p>Votes are counted automatically and results published.</p>
</div>

</div>
</section>

<!-- SECURITY -->
<section class="section">
<h2>Security Measures</h2>
<p class="center">
The system enforces strict session validation, one-vote-per-user logic,
server-side verification, and secure database storage to prevent tampering,
duplicate voting, and unauthorized access.
</p>
</section>

<!-- FUTURE SCOPE -->
<section class="section">
<h2>Future Enhancements</h2>
<p class="center">
Biometric authentication, OTP verification, blockchain-backed vote storage,
real-time analytics, and mobile app integration can be added in future versions.
</p>
</section>

<footer>
© 2025 Online Voting System | Secure • Transparent • Reliable
</footer>

</body>
</html>
