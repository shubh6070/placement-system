<?php
session_start();
include '../db.php';

// सुरक्षा
if(!isset($_SESSION['admin'])){
    header("Location: ../index.php");
    exit();
}

// Validate input
$id = $_GET['id'] ?? '';
$status = $_GET['status'] ?? '';

if(!$id || !in_array($status, ['Selected','Rejected'])){
    die("Invalid Request");
}

// Get student details
$res = mysqli_query($conn,"
SELECT students.email, students.name, jobs.title
FROM applications
JOIN students ON applications.student_id = students.id
JOIN jobs ON applications.job_id = jobs.id
WHERE applications.id = '$id'
");

$data = mysqli_fetch_assoc($res);

if(!$data){
    die("Data not found");
}

$email = $data['email'];
$name = $data['name'];
$job = $data['title'];

// Update status
mysqli_query($conn,"
UPDATE applications SET status='$status' WHERE id='$id'
");

// Email (basic)
$subject = "Application Status Update";

$message = "
Hello $name,

Your application for '$job' has been $status.

Thank you.
";

// (Optional - works only if mail server configured)
@mail($email, $subject, $message);

// Redirect
header("Location: applications.php");
exit();
?>