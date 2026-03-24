<?php
session_start();
include '../db.php';

if(!isset($_SESSION['student_id'])){
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION['student_id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM students WHERE id=$id"));

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $college = $_POST['college'];
    $course = $_POST['course'];
    $skills = $_POST['skills'];

    // Image
    $img = $data['image'];
    if(!empty($_FILES['image']['name'])){
        $img = time()."_".$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],"uploads/".$img);
    }

    // Resume
    $resume = $data['resume'];
    if(!empty($_FILES['resume']['name'])){
        $resume = time()."_".$_FILES['resume']['name'];
        move_uploaded_file($_FILES['resume']['tmp_name'],"resumes/".$resume);
    }

    mysqli_query($conn,"
    UPDATE students SET
    name='$name',
    email='$email',
    phone='$phone',
    college='$college',
    course='$course',
    skills='$skills',
    image='$img',
    resume='$resume'
    WHERE id=$id
    ");

    echo "<script>alert('Profile Updated');window.location='profile.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
background:linear-gradient(135deg,#020617,#0f172a);
color:white;
font-family:Segoe UI;
}

.sidebar{
width:250px;height:100vh;position:fixed;padding:20px;
background:rgba(0,0,0,0.6);backdrop-filter:blur(10px);
}

.sidebar a{display:block;color:white;padding:10px;border-radius:10px;}
.sidebar a:hover{background:#6366f1;}

.main{margin-left:250px;padding:20px;}

.card-box{
background:rgba(255,255,255,0.05);
padding:20px;border-radius:15px;margin-bottom:20px;
}

.profile-img{
width:100px;height:100px;border-radius:50%;object-fit:cover;
border:3px solid #6366f1;
}

input, textarea{
background:rgba(255,255,255,0.1)!important;
border:none!important;color:white!important;
}
</style>
</head>

<body>

<div class="sidebar">
<h3>🎓 Student</h3>
<a href="student-dashboard.php">Dashboard</a>
<a href="internships.php">Internships</a>
<a href="applications.php">Applications</a>
<a href="profile.php">Profile</a>

<hr>
<a href="../logout.php" style="color:red;">Logout</a>
</div>

<div class="main">

<!-- PROFILE VIEW -->
<div class="card-box text-center">

<?php if($data['image']){ ?>
<img src="uploads/<?php echo $data['image']; ?>" class="profile-img">
<?php } else { ?>
<img src="https://via.placeholder.com/100" class="profile-img">
<?php } ?>

<h4 class="mt-3"><?php echo $data['name']; ?></h4>
<p><?php echo $data['email']; ?></p>
<p><?php echo $data['phone']; ?></p>

</div>

<!-- EDIT FORM -->
<div class="card-box">

<h5>Edit Profile</h5>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="name" value="<?php echo $data['name']; ?>" class="form-control mb-2">

<input type="email" name="email" value="<?php echo $data['email']; ?>" class="form-control mb-2">

<input type="text" name="phone" value="<?php echo $data['phone']; ?>" placeholder="Phone" class="form-control mb-2">

<input type="text" name="college" value="<?php echo $data['college']; ?>" placeholder="College" class="form-control mb-2">

<input type="text" name="course" value="<?php echo $data['course']; ?>" placeholder="Course" class="form-control mb-2">

<textarea name="skills" class="form-control mb-2" placeholder="Skills"><?php echo $data['skills']; ?></textarea>

<label>Profile Image</label>
<input type="file" name="image" class="form-control mb-2">

<label>Resume (PDF)</label>
<input type="file" name="resume" class="form-control mb-3">

<button name="update" class="btn btn-primary">Update Profile</button>

</form>

<?php if($data['resume']){ ?>
<a href="resumes/<?php echo $data['resume']; ?>" target="_blank" class="btn btn-success mt-3">View Resume</a>
<?php } ?>

</div>

</div>

</body>
</html>