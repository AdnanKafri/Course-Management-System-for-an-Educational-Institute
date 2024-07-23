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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>User Dashboard</title>
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
    <h1>Welcome to Dashboard <?php echo $str; ?></h1>
    <?php
    if($_SESSION["type"]=="teacher")
    {
    ?>
    <a href="logout.php" class="btn btn-warning">Logout</a>
    <a href="add.php" class="btn btn-warning">Add Course</a>
    <a href="edit.php" class="btn btn-warning">Edit Course</a>
    <a href="show.php" class="btn btn-warning">Show Courses</a>
    <?php }
    else{
    ?>
    <a href="logout.php" class="btn btn-warning">Logout</a>
    <a href="sign.php" class="btn btn-warning">Register in a course</a>
    <a href="show.php" class="btn btn-warning">Show Courses</a>
    <a href="my.php" class="btn btn-warning">My Courses</a>
    <?php }
    $conn=null;?>
</div>
</body>
</html>