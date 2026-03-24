<?php
session_start();

$msg = "";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Admin credentials
    if($email == "admin@gmail.com" && $password == "123"){
        $_SESSION['admin'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $msg = "Invalid Admin Login!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>

<style>
body{
margin:0;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#020617,#0f172a);
font-family:Segoe UI;
color:white;
}

/* Card */
.login-box{
background:rgba(255,255,255,0.05);
padding:35px;
border-radius:20px;
backdrop-filter:blur(15px);
width:350px;
box-shadow:0 0 25px rgba(0,0,0,0.5);
transition:0.3s;
}

.login-box:hover{
transform:scale(1.02);
}

/* Inputs */
input{
width:100%;
padding:10px;
margin-bottom:15px;
border:none;
border-radius:10px;
background:rgba(255,255,255,0.1);
color:white;
}

/* Button */
button{
width:100%;
padding:10px;
border:none;
border-radius:12px;
background:linear-gradient(45deg,#f97316,#fb923c);
color:white;
font-weight:bold;
transition:0.3s;
}

button:hover{
box-shadow:0 0 15px #f97316;
}

/* Error */
.error{
background:#ef4444;
padding:8px;
border-radius:8px;
margin-bottom:10px;
text-align:center;
}

a{
color:#22c55e;
text-decoration:none;
}
</style>

</head>

<body>

<div class="login-box">

<h2 style="text-align:center;">👨‍💼 Admin Login</h2>

<?php if($msg){ ?>
<div class="error"><?php echo $msg; ?></div>
<?php } ?>

<form method="POST">

<input type="email" name="email" placeholder="Admin Email" required>

<input type="password" name="password" placeholder="Password" required>

<button name="login">Login</button>

</form>

<p style="text-align:center; margin-top:15px;">
<a href="../index.php">← Back to Home</a>
</p>

</div>

</body>
</html>