<?php
session_start();
include 'db.php';

$msg = "";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    // 🔐 ADMIN LOGIN (HIDDEN)
    if($email == "admin@gmail.com" && $password == "123"){
        $_SESSION['admin'] = true;
        header("Location: admin/dashboard.php");
        exit();
    }

    // 👨‍🎓 STUDENT LOGIN
    $res = mysqli_query($conn,"SELECT * FROM students WHERE email='$email'");

    if($res && mysqli_num_rows($res) > 0){
        $data = mysqli_fetch_assoc($res);

        if($password == $data['password']){
            $_SESSION['student_id'] = $data['id'];
            header("Location: student/student-dashboard.php");
            exit();
        } else {
            $msg = "Wrong Password!";
        }
    } else {
        $msg = "User Not Found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

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
background:linear-gradient(45deg,#6366f1,#3b82f6);
color:white;
font-weight:bold;
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
}
</style>

</head>

<body>

<div class="login-box">

<h2 style="text-align:center;">🎓 Student Login</h2>

<?php if($msg){ ?>
<div class="error"><?php echo $msg; ?></div>
<?php } ?>

<form method="POST">

<input type="email" name="email" placeholder="Enter Email" required>

<input type="password" name="password" placeholder="Enter Password" required>

<button name="login">Login</button>

</form>

<p style="text-align:center; margin-top:15px;">
New student? <a href="register.php">Register</a>
</p>

</div>

</body>
</html>