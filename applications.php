<?php
session_start();
include '../db.php';

if(!isset($_SESSION['admin'])){
    header("Location: ../index.php");
}

// Filters
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

// Base query
$query = "
SELECT applications.*, students.name, students.email, jobs.title, companies.name AS company
FROM applications
JOIN students ON applications.student_id = students.id
JOIN jobs ON applications.job_id = jobs.id
JOIN companies ON jobs.company_id = companies.id
WHERE 1
";

// Search
if($search != ""){
    $query .= " AND students.name LIKE '%$search%'";
}

// Status filter
if($status != ""){
    $query .= " AND applications.status='$status'";
}

$query .= " ORDER BY applications.applied_at DESC";

$res = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Applications</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#f5f7fb;font-family:Segoe UI;}

.sidebar{
width:250px;height:100vh;background:linear-gradient(#1e293b,#020617);
color:white;position:fixed;padding:20px;
}

.sidebar ul{list-style:none;padding:0;}
.sidebar ul li{padding:12px;border-radius:10px;}
.sidebar ul li:hover{background:#6366f1;}

.sidebar a{color:white;text-decoration:none;}

.navbar-custom{
margin-left:250px;background:white;padding:15px 20px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.main{margin-left:250px;padding:20px;}

.table-box{
background:white;padding:20px;border-radius:15px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.status{
padding:5px 10px;border-radius:8px;font-size:12px;
}

.pending{background:#fef3c7;color:#92400e;}
.selected{background:#dcfce7;color:#166534;}
.rejected{background:#fee2e2;color:#991b1b;}
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
<h5>Applications Management</h5>
</div>

<div class="main">

<div class="table-box">

<!-- 🔎 FILTER -->
<form method="GET" class="row mb-3">

<div class="col-md-4">
<input type="text" name="search" value="<?php echo $search; ?>" 
class="form-control" placeholder="Search Student">
</div>

<div class="col-md-3">
<select name="status" class="form-control">
<option value="">All Status</option>
<option <?php if($status=="Pending") echo "selected"; ?>>Pending</option>
<option <?php if($status=="Selected") echo "selected"; ?>>Selected</option>
<option <?php if($status=="Rejected") echo "selected"; ?>>Rejected</option>
</select>
</div>

<div class="col-md-2">
<button class="btn btn-primary">Filter</button>
</div>

</form>

<!-- TABLE -->
<table class="table table-bordered">

<tr>
<th>Student</th>
<th>Email</th>
<th>Job</th>
<th>Company</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($res)){ 
$statusClass = strtolower($row['status']);
?>

<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['company']; ?></td>

<td>
<span class="status <?php echo $statusClass; ?>">
<?php echo $row['status']; ?>
</span>
</td>

<td>
<a href="update_status.php?id=<?php echo $row['id']; ?>&status=Selected" 
class="btn btn-success btn-sm">Select</a>

<a href="update_status.php?id=<?php echo $row['id']; ?>&status=Rejected" 
class="btn btn-danger btn-sm">Reject</a>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>