<?php
session_start();
include '../db.php';

// सुरक्षा
if(!isset($_SESSION['admin'])){
    header("Location: ../index.php");
}

// Counts
$total_companies = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM companies"));
$total_jobs = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM jobs"));
$total_apps = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM applications"));

// Chart Data
$pending = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM applications WHERE status='Pending'"));
$selected = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM applications WHERE status='Selected'"));
$rejected = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM applications WHERE status='Rejected'"));

$internships = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM jobs WHERE type='internship'"));
$placements = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM jobs WHERE type='placement'"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
.sidebar ul li{
padding:12px;
border-radius:10px;
}
.sidebar ul li:hover{
background:#6366f1;
}

.sidebar a{
color:white;
text-decoration:none;
display:block;
}

/* Navbar */
.navbar-custom{
margin-left:250px;
background:white;
padding:15px 20px;
display:flex;
justify-content:space-between;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* Main */
.main{
margin-left:250px;
padding:20px;
}

/* Cards */
.card-box{
padding:20px;
border-radius:15px;
color:white;
}

.card1{background:linear-gradient(45deg,#6366f1,#8b5cf6);}
.card2{background:linear-gradient(45deg,#22c55e,#16a34a);}
.card3{background:linear-gradient(45deg,#f59e0b,#f97316);}

/* Table */
.table-box{
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}
</style>

</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
<h3>👨‍💼 Admin</h3>

<ul>
<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="add_company.php">Add Company</a></li>
<li><a href="add_job.php">Add Job</a></li>
<li><a href="applications.php">Applications</a></li>
<li><a href="../logout.php">Logout</a></li>
</ul>
</div>

<!-- Navbar -->
<div class="navbar-custom">
<h5>Admin Dashboard</h5>
</div>

<div class="main">

<!-- Cards -->
<div class="row mb-4">

<div class="col-md-4">
<div class="card-box card1">
<h6>Total Companies</h6>
<h3><?php echo $total_companies; ?></h3>
</div>
</div>

<div class="col-md-4">
<div class="card-box card2">
<h6>Total Jobs</h6>
<h3><?php echo $total_jobs; ?></h3>
</div>
</div>

<div class="col-md-4">
<div class="card-box card3">
<h6>Total Applications</h6>
<h3><?php echo $total_apps; ?></h3>
</div>
</div>

</div>

<!-- 📊 Charts -->
<div class="row mb-4">

<div class="col-md-6">
<div class="table-box">
<h5>Application Status</h5>
<canvas id="statusChart"></canvas>
</div>
</div>

<div class="col-md-6">
<div class="table-box">
<h5>Jobs Distribution</h5>
<canvas id="jobChart"></canvas>
</div>
</div>

</div>

<!-- Recent Applications -->
<div class="table-box">

<h5>Recent Applications</h5>

<table class="table">
<tr>
<th>Student</th>
<th>Job</th>
<th>Status</th>
<th>Date</th>
</tr>

<?php
$res = mysqli_query($conn,"
SELECT applications.*, students.name, jobs.title
FROM applications
JOIN students ON applications.student_id = students.id
JOIN jobs ON applications.job_id = jobs.id
ORDER BY applications.applied_at DESC LIMIT 5
");

while($row = mysqli_fetch_assoc($res)){
?>

<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['status']; ?></td>
<td><?php echo date("d M Y", strtotime($row['applied_at'])); ?></td>
</tr>

<?php } ?>

</table>

</div>

</div>

<!-- 📊 Chart Script -->
<script>

// Status Chart
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Selected', 'Rejected'],
        datasets: [{
            data: [<?php echo $pending; ?>, <?php echo $selected; ?>, <?php echo $rejected; ?>],
            backgroundColor: ['#f59e0b','#22c55e','#ef4444']
        }]
    }
});

// Job Chart
new Chart(document.getElementById('jobChart'), {
    type: 'bar',
    data: {
        labels: ['Internships', 'Placements'],
        datasets: [{
            label: 'Jobs',
            data: [<?php echo $internships; ?>, <?php echo $placements; ?>],
            backgroundColor: ['#6366f1','#06b6d4']
        }]
    }
});

</script>

</body>
</html>