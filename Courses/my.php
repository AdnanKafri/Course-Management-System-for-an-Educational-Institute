<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: new.php");
    exit();
}
?>
    <!DOCTYPE html>
    <html lang="en" xmlns="http://www.w3.org/1999/html">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Course Management</title>
        <link rel="stylesheet" href="style3.css">
        <link rel="stylesheet" href="newhome.css">
    </head>

    <body>
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
    <div class="container" align="center">

<?php
require_once "database.php";

$email=$_SESSION['user'];
$sql="SELECT student_id FROM students WHERE email='$email'";
$res=$conn->query($sql);
$res1=$res->fetch();
$sid=$res1['student_id'];

$sql2="SELECT c_id FROM bill WHERE s_id='$sid'";
$ress=$conn->query($sql2);
$rowCount = $ress->rowCount();
    if($rowCount==0)
        {
            $init="You Haven't Sign In Any Course Yet, Sign Now!";
        }
    else
        {
            $cnt=1;


            echo "<table border='1'>";
            echo "<th></th>";
            echo "<th>Course Name</th>";
            echo "<th>Course Teacher</th>";
            echo "<th>Course Price</th>";
            echo "<th>Course Bill</th>";
            while($row=$ress->fetch())
            {
                $cid=$row['c_id'];
                $sql3="SELECT * FROM courses where course_id='$cid'";
                $res2=$conn->query($sql3);
                $row1=$res2->fetch();
                $init="You Are Signed In $cnt Courses";
                $cname=$row1['name'];
                $cteach=$row1['course_teacher'];
                $cprice=$row1['price'];

                echo "<tr>";
                echo "<td>$cnt</td>";
                echo "<td>$cname</td>";
                echo "<td>$cteach</td>";
                echo "<td>$cprice</td>";
                echo "<td><button class='back-btn' style='background-color: lightsalmon' onclick= 'location.href=\"s_bill.php?x="."$sid&y=$cid"."\";'; '>Show Bill</button>
                    </td>";

                echo "</tr>";
                $cnt++;
            }
                echo "</table>";
        }
?>



    <h1><?php echo $init."<br>"; ?> </h1>
        <button  class="back-btn" onclick='location.href="sign.php";'>Return To The Sign Course Page</button>
    </div>
    </body>
    </html>
<?php
$conn=null;

