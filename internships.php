<?php
session_start();
include '../db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Internships</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

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

.job-card{
background:white;
padding:20px;
border-radius:15px;
margin-bottom:15px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
transition:0.3s;
}

.job-card:hover{transform:translateY(-5px);}

.apply-btn{
background:#6366f1;
color:white;
border:none;
padding:8px 20px;
border-radius:8px;
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
<h5>Internships</h5>

<div>
<input placeholder="Search..." class="form-control d-inline" style="width:250px">
<i class="fa fa-bell ms-3"></i>
</div>
</div>

<div class="main">

<h4>Available Internships</h4>

<?php
$query = "
SELECT jobs.*, companies.name as company
FROM jobs
JOIN companies ON jobs.company_id = companies.id
WHERE jobs.type='internship'
ORDER BY jobs.id DESC
";

$res = mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($res)){
?>

<div class="job-card">

<div class="d-flex justify-content-between">

<div>
<h5><?php echo $row['title']; ?></h5>
<p><?php echo $row['company']; ?></p>
<p>
📍 <?php echo $row['location']; ?> |
💰 ₹<?php echo $row['salary']; ?> |
⏳ <?php echo $row['duration']; ?>
</p>
</div>

<div>
<a href="apply.php?id=<?php echo $row['id']; ?>">
<button class="apply-btn">Apply</button>
</a>
</div>

</div>

</div>

<?php } ?>

</div>

</body>
</html>