<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: new.php");
    exit();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="newhome.css">

</head>
<body>

<div class="container">
 <?php
    require_once "database.php";
    $em=$_SESSION['user'];
    if($_SESSION["type"]=="student")
         {
        $sql1 = "SELECT student_name FROM students WHERE email = '$em'";
        $result1 = $conn->query($sql1);
        $user1 = $result1->fetchAll();

        $str=$user1[0]['student_name'];
    }
    else
    {
        $sql1 = "SELECT teacher_name FROM teachers WHERE t_email = '$em'";
        $result1 = $conn->query($sql1);
        $user1 = $result1->fetchAll();
//        print_r($user1);
        $str=$user1[0]['teacher_name'];
    }
    ?>
    <header>
        <a href="home.php" class="logo">Smart<span>Study</span></a>

        <div id="menu" class="fas fa-bars"></div>

        <h1>Welcome <?php echo $str; ?></h1>
        <nav class="navbar">
            <?php
            if($_SESSION["type"]=="teacher")
            {
            ?>
                <a href="home.php">home</a>
                <a href="add.php">Add New Course</a>
                <a href="Edit.php">Courses Managment</a>
                <a href="contact.php">contact</a>
                <a href="logout.php" >Logout</a>
            <?php }
            else{?>
                <a href="sign.php">Sign in a course</a>
                <a href="show.php">Show Courses</a>
                <a href="my.php">My Courses</a>
                <a href="contact.php">contact</a>
                <a href="logout.php">Logout</a>
            <?php }

            ?>
        </nav>

    </header>

    <!-- home section  -->

    <section class="home">

        <div class="content">
            <h3>The New Generation Of Learnig Has Now Began</h3>
            <p>We offer you the opportunity to keep up with the latest developments in science by offering a wide range of educational courses in various fields</p>
            <?php if($_SESSION['type']=="teacher")
                {
          echo"  <a href=\"edit.php\" class=\"btn\">You Are Signed As Teacher,Manage The Courses!</a>";
                }
                else
                    echo"  <a href=\"sign.php\" class=\"btn\">get started and sign in a course now!</a>";
                ?>

        </div>

        <div class="image">
            <img src="images/home-img.svg" alt="">
        </div>

    </section>


    <!-- footer section  -->


    <section class="footer">
        <div class="box-container">







        </div>

        <div class="credit"> created by The Creative WPU Team | all rights reserved &copy; </div>

    </section>

</div>















<!-- custom js file link -->
<script src="home.js"></script>

</body>
</html>