<?php
session_start();
include '../db.php';

$student_id = $_SESSION['student_id'] ?? 1;
$job_id = $_GET['id'] ?? 0;

// Fetch job details
$job = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT jobs.*, companies.name as company
FROM jobs
JOIN companies ON jobs.company_id = companies.id
WHERE jobs.id = $job_id
"));

// Submit form
if(isset($_POST['apply'])){
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $college = $_POST['college'];
    $skills = $_POST['skills'];
    $cover = $_POST['cover'];

    // File upload
    $resume = $_FILES['resume']['name'];
    $tmp = $_FILES['resume']['tmp_name'];

    move_uploaded_file($tmp,"../uploads/".$resume);

    mysqli_query($conn,"
    INSERT INTO applications(student_id,job_id)
    VALUES('$student_id','$job_id')
    ");

    echo "<script>alert('Application Submitted');window.location='applications.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Apply Internship</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
background:#f5f7fb;
font-family:Segoe UI;
}

.container-box{
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 2px 15px rgba(0,0,0,0.05);
margin-top:30px;
}

.apply-btn{
background:#6366f1;
color:white;
padding:10px 25px;
border:none;
border-radius:8px;
}
</style>

</head>

<body>

<div class="container">

<h3 class="mt-4">Apply for <?php echo $job['title']; ?></h3>

<div class="container-box">

<h5><?php echo $job['title']; ?></h5>
<p><?php echo $job['company']; ?> • <?php echo $job['location']; ?> • ₹<?php echo $job['salary']; ?></p>

<hr>

<form method="POST" enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-3">
<label>Full Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">
<label>Phone Number</label>
<input type="text" name="phone" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>College</label>
<input type="text" name="college" class="form-control">
</div>

</div>

<div class="mb-3">
<label>Skills</label>
<input type="text" name="skills" class="form-control">
</div>

<div class="mb-3">
<label>Cover Letter</label>
<textarea name="cover" class="form-control" rows="4"></textarea>
</div>

<div class="mb-3">
<label>Upload Resume</label>
<input type="file" name="resume" class="form-control">
</div>

<button name="apply" class="apply-btn">Submit Application</button>

</form>

</div>

</div>

</body>
</html>