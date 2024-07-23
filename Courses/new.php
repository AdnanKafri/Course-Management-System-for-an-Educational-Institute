<?php
@session_start();
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">-->
    <link rel="stylesheet" href="style2.css">
<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">-->
<!--    <link rel="stylesheet" href="style.css">-->
    <title>Welcome</title>
</head>

<body>

<div class="container" id="container">
    <div class="form-container sign-up">
        <form method="post" action="registration.php">
            <h1>Create Account</h1>
            <input type="text" name="fullname" placeholder="Username:">
            <input type="email"  name="email" placeholder="Email:">
            <select name="level" >
                <option value="none">--Education Level--</option>
                <option value="sec" >Secondary School</option>
                <option value="high">High School</option>
                <option value="uni">University Student</option>
                <option value="Bach">Bachelor's Degree</option>
                <option value="phd">PHD Degree</option>
            </select><br>
            <h4 align="center">Gender:<br>
                Male<input style="all: revert" type="radio" value="male" name="gender" checked>
                Female<input style="all: revert" type="radio" value="female" name="gender">
            </h4><br>
            <h4  align="center">Birth Date:<br>
            <input  style="width: 230%;transform: translateX(-100px); " type="date" name="bdate" >
            </h4>

            <input type="password"  name="password" placeholder="Password:">
            <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            <button type="submit" name="submit" >Register</button>


        </form>
    </div>
    <div class="form-container sign-in">
        <form action="login.php" method="post">
            <h1>Sign In</h1>
            <input type="email" placeholder="Enter Email:" name="email" >
            <input type="password" placeholder="Enter Password:" name="password" >
            <button type="submit" name="submit">Login</button>
        </form>
    </div>
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-left">
                <h1>Welcome Back!</h1>
                <p>Enter your personal details to use all of site features</p>
                <button class="hidden" id="login">Sign In</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Hello, Friend!</h1>
                <p>Register with your personal details to use all of site features</p>
                <button class="hidden" id="register">Sign Up</button>
            </div>
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>

</html>