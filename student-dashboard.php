<?php
session_start();
include '../db.php';

$student_id = $_SESSION['student_id'] ?? 1;

// Stats
$total_internships = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM jobs WHERE type='internship'"));
$total_applied = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM applications WHERE student_id=$student_id"));
$total_placements = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM jobs WHERE type='placement'"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Dashboard</title>

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
padding:20px;
border-radius:15px;
color:white;
}

.card1{background:linear-gradient(45deg,#6366f1,#8b5cf6);}
.card2{background:linear-gradient(45deg,#22c55e,#16a34a);}
.card3{background:linear-gradient(45deg,#f59e0b,#f97316);}

.job-card{
background:white;
padding:20px;
border-radius:15px;
margin-bottom:15px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.apply-btn{
background:#6366f1;
color:white;
border:none;
padding:8px 20px;
border-radius:8px;
}

.hero{
background:linear-gradient(45deg,#6366f1,#3b82f6);
color:white;
padding:30px;
border-radius:15px;
margin-bottom:20px;
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
<h5>Student Dashboard</h5>
</div>

<div class="main">

<!-- Hero -->
<div class="hero">
<h3>Find Your Dream Internship</h3>
<p>Apply to top companies and kickstart your career</p>
<a href="internships.php"><button class="btn btn-light">Browse Internships</button></a>
</div>

<!-- Stats -->
<div class="row mb-4">

<div class="col-md-4">
<div class="card-box card1">
<h6>Available Internships</h6>
<h3><?php echo $total_internships; ?></h3>
</div>
</div>

<div class="col-md-4">
<div class="card-box card2">
<h6>Applied</h6>
<h3><?php echo $total_applied; ?></h3>
</div>
</div>

<div class="col-md-4">
<div class="card-box card3">
<h6>Placements</h6>
<h3><?php echo $total_placements; ?></h3>
</div>
</div>

</div>

<!-- Latest Internships -->
<h4>Latest Internships</h4>

<?php
$res = mysqli_query($conn,"
SELECT jobs.*, companies.name as company
FROM jobs
JOIN companies ON jobs.company_id=companies.id
WHERE jobs.type='internship'
ORDER BY jobs.id DESC LIMIT 5
");

while($row=mysqli_fetch_assoc($res)){
?>

<div class="job-card">
<h5><?php echo $row['title']; ?></h5>
<p><?php echo $row['company']; ?> • ₹<?php echo $row['salary']; ?></p>

<a href="internship-details.php?id=<?php echo $row['id']; ?>">
<button class="apply-btn">View</button>
</a>
</div>

<?php } ?>

</div>

</body>
</html>