<?php
session_start();
include '../db.php';

// सुरक्षा
if(!isset($_SESSION['admin'])){
    header("Location: ../index.php");
}

$msg = "";

// Add Job
if(isset($_POST['add'])){

    $company_id = $_POST['company_id'];
    $title = $_POST['title'];
    $type = $_POST['type'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $duration = $_POST['duration'];
    $last_date = $_POST['last_date'];
    $description = $_POST['description'];

    mysqli_query($conn,"
    INSERT INTO jobs(company_id,title,type,salary,location,duration,last_date,description)
    VALUES('$company_id','$title','$type','$salary','$location','$duration','$last_date','$description')
    ");

    $msg = "Job Added Successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Job</title>

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

.sidebar a{
color:white;
text-decoration:none;
display:block;
}

.navbar-custom{
margin-left:250px;
background:white;
padding:15px 20px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.main{
margin-left:250px;
padding:20px;
}

.form-box{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.btn-custom{
background:#6366f1;
color:white;
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
<h5>Add Job</h5>
</div>

<div class="main">

<div class="form-box">

<h4>Add Internship / Placement</h4>

<?php if($msg){ ?>
<div class="alert alert-success"><?php echo $msg; ?></div>
<?php } ?>

<form method="POST">

<!-- Job Title -->
<div class="mb-3">
<label>Job Title</label>
<input type="text" name="title" class="form-control" required>
</div>

<!-- Type -->
<div class="mb-3">
<label>Type</label>
<select name="type" class="form-control">
<option value="internship">Internship</option>
<option value="placement">Placement</option>
</select>
</div>

<!-- Company -->
<div class="mb-3">
<label>Select Company</label>
<select name="company_id" class="form-control" required>

<option value="">-- Select Company --</option>

<?php
$res = mysqli_query($conn,"SELECT * FROM companies");
while($row = mysqli_fetch_assoc($res)){
?>
<option value="<?php echo $row['id']; ?>">
<?php echo $row['name']; ?>
</option>
<?php } ?>

</select>
</div>

<!-- Salary -->
<div class="mb-3">
<label>Salary / Stipend</label>
<input type="text" name="salary" class="form-control" placeholder="₹5000 or 5 LPA">
</div>

<!-- Location -->
<div class="mb-3">
<label>Location</label>
<input type="text" name="location" class="form-control">
</div>

<!-- Duration -->
<div class="mb-3">
<label>Duration</label>
<input type="text" name="duration" class="form-control" placeholder="3 Months / Full Time">
</div>

<!-- Last Date -->
<div class="mb-3">
<label>Last Date to Apply</label>
<input type="date" name="last_date" class="form-control">
</div>

<!-- Description -->
<div class="mb-3">
<label>Job Description</label>
<textarea name="description" class="form-control" rows="4"></textarea>
</div>

<button name="add" class="btn btn-custom">Add Job</button>

</form>

</div>

</div>

</body>
</html>