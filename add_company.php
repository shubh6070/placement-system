<?php
session_start();
include '../db.php';

// सुरक्षा
if(!isset($_SESSION['admin'])){
    header("Location: ../index.php");
}

$msg = "";

// Add company
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $location = $_POST['location'];
    $desc = $_POST['description'];

    mysqli_query($conn,"
    INSERT INTO companies(name,location,description)
    VALUES('$name','$location','$desc')
    ");

    $msg = "Company Added Successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Company</title>

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
<h5>Add Company</h5>
</div>

<div class="main">

<div class="form-box">

<h4>Add New Company</h4>

<?php if($msg){ ?>
<div class="alert alert-success"><?php echo $msg; ?></div>
<?php } ?>

<form method="POST">

<div class="mb-3">
<label>Company Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>Location</label>
<input type="text" name="location" class="form-control" required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control" rows="4"></textarea>
</div>

<button name="add" class="btn btn-custom">Add Company</button>

</form>

</div>

</div>

</body>
</html>