<?php

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: new.php");
    exit();

}
if($_SESSION['type']=='teacher')
{


require_once "database.php";
$cid=$_GET['x'];


$sql="SELECT s_id FROM bill WHERE c_id='$cid'";
$res=$conn->query($sql);
$row=$res->rowCount();
//echo $row;


$sql1="SELECT * FROM courses WHERE course_id='$cid'";
$res1=$conn->query($sql1);
$row2=$res1->fetch();
$sdate=$row2['start_date'];
$edate=$row2['end_date'];
$price=$row2['price'];
$max=$row2['max_num'];


    $diff = abs(strtotime($edate) - strtotime($sdate));
    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
$period="$months Months ,$days Days";
$total=$row*$price;
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bill Informations</title>
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



            <h1>Course Id: <h2><?php echo $cid; ?></h2></h1>
            <h1>Number Of Signed Students:
                <h2><?php echo $row."/$max"; ?></h2>
                <button  class='add-course-btn' style="background-color: #4fa399"><a style="color: white" href="bills_list.php?x=<?php echo $cid; ?>">See Each Student Bill</a></button>
            </h1>
            <h1>Price Per Student: <h2><?php echo $price; ?></h2></h1>
            <h1>Total Price For This Course: <h2><?php echo $total; ?></h2></h1>
            <h1>Coruse Start Date: <h2><?php echo $sdate; ?></h2></h1>
            <h1>Coruse End Date: <h2><?php echo $edate; ?></h2></h1>
            <h1>Course's Length: <h2><?php echo $period; ?></h2></h1>
            <button  class='back-btn' style="background-color: #5a6268"><a style="color: white" href="Edit.php">Return</a></button>

    </div>
    </body>
    </html>
<?php
$conn=null;
}
else
{   echo "<style>
.error{
max-width: 1200px;
    margin: auto;
    overflow-x: auto;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    position: relative;
    z-index: 1;
    margin-top: 50px;
    align: center;
    
}
</style>";
    echo "<div class='error'>";
    echo "<table>";
    echo "<h1>you don't have Permission To Enter This Page</h1><br>";
    echo "<button class='back-btn' onclick='location.href=\"home.php\";'>Return To Home</button>";
    echo "</table>";
    echo "</div>";

}


