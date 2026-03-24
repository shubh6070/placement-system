<?php
session_start();
include '../db.php';

$job_id = $_GET['id'] ?? 0;

// Fetch job details
$job = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT jobs.*, companies.name as company, companies.description as company_desc
FROM jobs
JOIN companies ON jobs.company_id = companies.id
WHERE jobs.id = $job_id
"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Internship Details</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
background:#f5f7fb;
font-family:Segoe UI;
}

.sidebar{
width:250px;
height:100vh;
background:linear-gradient(#1e293b,#020617);
color:white;
position:fixed;
padding:20px;
}

.sidebar ul{list-style:none;padding:0;}
.sidebar ul li{padding:12px;border-radius:10px;}
.sidebar ul li:hover{background:#6366f1;}

.navbar-custom{
margin-left:250px;
background:white;
padding:15px 20px;
display:flex;
justify-content:space-between;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.main{
margin-left:250px;
padding:20px;
}

.card-box{
background:white;
padding:25px;
border-radius:15px;
margin-bottom:20px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.apply-btn{
background:#6366f1;
color:white;
border:none;
padding:10px 25px;
border-radius:10px;
}

.save-btn{
background:#e2e8f0;
border:none;
padding:10px 20px;
border-radius:10px;
}
</style>

</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
<h3>🎓 Student</h3>
<ul>
<li><a href="student-dashboard.php">Dashboard</a></li>
<li><a href="internships.php">Internships</a></li>
<li><a href="placements.php">Placements</a></li>
<li><a href="applications.php">Applications</a></li>
<li><a href="profile.php">Profile</a></li>
</ul>
</div>

<!-- Navbar -->
<div class="navbar-custom">
<h5>Internship Details</h5>
</div>

<div class="main">

<!-- Internship Info -->
<div class="card-box">

<h4><?php echo $job['title']; ?></h4>

<p><?php echo $job['company']; ?> • <?php echo $job['location']; ?></p>

<div class="row">

<div class="col-md-3">📍 <?php echo $job['location']; ?></div>
<div class="col-md-3">💰 ₹<?php echo $job['salary']; ?></div>
<div class="col-md-3">⏳ <?php echo $job['duration']; ?></div>
<div class="col-md-3">📅 Apply by <?php echo $job['last_date']; ?></div>

</div>

<hr>

<a href="apply.php?id=<?php echo $job['id']; ?>">
<button class="apply-btn">Apply Now</button>
</a>

<button class="save-btn">Save</button>

</div>

<!-- About -->
<div class="card-box">
<h5>About the Internship</h5>
<p><?php echo $job['description']; ?></p>
</div>

<!-- Company -->
<div class="card-box">
<h5>About Company</h5>
<p><?php echo $job['company_desc']; ?></p>
</div>

</div>

</body>
</html>