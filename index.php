<?php
session_start();
include 'db.php';

$search = $_GET['search'] ?? '';
$type   = $_GET['type'] ?? '';

$query = "
SELECT jobs.*, companies.name as company 
FROM jobs 
JOIN companies ON jobs.company_id = companies.id
WHERE 1
";

if($search != ""){
    $query .= " AND jobs.title LIKE '%$search%'";
}

if($type != ""){
    $query .= " AND jobs.type='$type'";
}

$query .= " ORDER BY jobs.id DESC";

$res = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Placement System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:linear-gradient(135deg,#020617,#0f172a);
color:white;
font-family:Segoe UI;
}

/* NAVBAR */
.navbar{
position:sticky;
top:0;
background:rgba(0,0,0,0.6);
backdrop-filter:blur(10px);
padding:15px 30px;
z-index:100;
}

.btn-glow{
background:linear-gradient(45deg,#f97316,#fb923c);
border:none;
color:white;
border-radius:25px;
padding:8px 20px;
transition:0.3s;
}
.btn-glow:hover{
box-shadow:0 0 15px #f97316;
transform:scale(1.05);
}

/* HERO */
.hero{
text-align:center;
padding:80px 20px;
}

.hero h1{
font-size:50px;
font-weight:bold;
background:linear-gradient(45deg,#6366f1,#22c55e);
-webkit-background-clip:text;
-webkit-text-fill-color:transparent;
}

/* SEARCH BOX */
.search-box{
background:rgba(255,255,255,0.05);
padding:20px;
border-radius:20px;
backdrop-filter:blur(12px);
box-shadow:0 0 15px rgba(255,255,255,0.05);
}

/* CARD */
.job-card{
background:rgba(255,255,255,0.05);
backdrop-filter:blur(10px);
border-radius:20px;
padding:20px;
margin-bottom:20px;
transition:0.3s;
border:1px solid rgba(255,255,255,0.1);
}

.job-card:hover{
transform:translateY(-8px) scale(1.02);
box-shadow:0 0 25px rgba(99,102,241,0.5);
}

/* APPLY BUTTON */
.apply-btn{
background:linear-gradient(45deg,#6366f1,#3b82f6);
border:none;
color:white;
padding:8px 20px;
border-radius:12px;
transition:0.3s;
}
.apply-btn:hover{
box-shadow:0 0 10px #6366f1;
}

/* INPUTS */
input, select{
background:rgba(255,255,255,0.1) !important;
border:none !important;
color:white !important;
}

input::placeholder{
color:#ccc;
}

</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar d-flex">
<h4>🚀 PlaceTrack</h4>

<div class="ms-auto">
<a href="login.php" class="btn btn-glow">Login</a>
<a href="register.php" class="btn btn-glow ms-2">Register</a>
</div>
</nav>

<!-- HERO -->
<div class="hero">
<h1>Find Your Dream Internship</h1>
<p>Explore opportunities and apply easily</p>
</div>

<!-- SEARCH -->
<div class="container">
<div class="search-box">

<form method="GET" class="row g-2">

<div class="col-md-5">
<input type="text" name="search" value="<?php echo $search; ?>"
class="form-control" placeholder="🔍 Search Internship...">
</div>

<div class="col-md-4">
<select name="type" class="form-control">
<option value="">All Categories</option>
<option value="internship" <?php if($type=="internship") echo "selected"; ?>>Internship</option>
<option value="placement" <?php if($type=="placement") echo "selected"; ?>>Placement</option>
</select>
</div>

<div class="col-md-3">
<button class="btn btn-glow w-100">Search</button>
</div>

</form>

</div>
</div>

<!-- JOB LIST -->
<div class="container mt-4">

<h4 class="mb-3">✨ Opportunities</h4>

<?php if(mysqli_num_rows($res) > 0){ ?>

<?php while($row = mysqli_fetch_assoc($res)){ ?>

<div class="job-card">

<h5><?php echo $row['title']; ?></h5>
<p><b><?php echo $row['company']; ?></b></p>

<p>
📍 <?php echo $row['location']; ?> |
💰 ₹<?php echo $row['salary']; ?> |
⏳ <?php echo $row['duration']; ?>
</p>

<button class="apply-btn" onclick="goLogin()">Apply</button>

</div>

<?php } ?>

<?php } else { ?>

<div class="alert alert-warning">No data found</div>

<?php } ?>

</div>

<script>
function goLogin(){
window.location.href="login.php";
}
</script>

</body>
</html>