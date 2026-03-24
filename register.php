<?php
include 'db.php';

$msg = "";

if(isset($_POST['register'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check duplicate email
    $check = mysqli_query($conn,"SELECT * FROM students WHERE email='$email'");

    if(mysqli_num_rows($check)){
        $msg = "Email already exists!";
    } else {

        mysqli_query($conn,"
        INSERT INTO students(name,email,password)
        VALUES('$name','$email','$password')
        ");

        $msg = "Registration successful! <a href='login.php'>Login now</a>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

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

/* Glass Box */
.register-box{
background:rgba(255,255,255,0.05);
padding:35px;
border-radius:20px;
backdrop-filter:blur(15px);
width:380px;
box-shadow:0 0 25px rgba(0,0,0,0.5);
transition:0.3s;
}

.register-box:hover{
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

input::placeholder{
color:#ccc;
}

/* Button */
button{
width:100%;
padding:10px;
border:none;
border-radius:12px;
background:linear-gradient(45deg,#22c55e,#16a34a);
color:white;
font-weight:bold;
transition:0.3s;
}

button:hover{
box-shadow:0 0 15px #22c55e;
}

/* Messages */
.msg{
padding:10px;
border-radius:10px;
margin-bottom:10px;
text-align:center;
}

.error{background:#ef4444;}
.success{background:#22c55e;}

a{
color:#6366f1;
text-decoration:none;
}
</style>

</head>

<body>

<div class="register-box">

<h2 style="text-align:center;">📝 Register</h2>

<?php if($msg){ ?>
<div class="msg <?php echo (strpos($msg,'successful')!==false) ? 'success' : 'error'; ?>">
<?php echo $msg; ?>
</div>
<?php } ?>

<form method="POST">

<input type="text" name="name" placeholder="Full Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button name="register">Create Account</button>

</form>

<p style="text-align:center; margin-top:15px;">
Already have account? <a href="login.php">Login</a>
</p>

</div>

</body>
</html>