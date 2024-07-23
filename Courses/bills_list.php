<?php

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: new.php");
    exit();

}
if($_SESSION['type']=='teacher')
{
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
<div class='table-container'>
        <div class='table-wrapper'>
            <table>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Show Bill</th>
                </tr>

                <?php

                require_once "database.php";
                $cid=$_GET['x'];
                $sql = "SELECT * FROM bill where c_id='$cid'";
                $res = $conn->query($sql, PDO::FETCH_ASSOC);
                foreach ($res as $row) {
                    $sid=$row['s_id'];
                    $sq="select * from students where student_id='$sid'";
                    $res1=$conn->query($sq);
                    $res1=$res1->fetch();
                    $stname=$res1['student_name'];
                    echo "<tr>";
                    echo "<td> $sid </td>";
                    echo "<td> $stname </td>";
                    echo "<td> <div >
                            <button class='back-btn' style='background-color: #77BBBBFF' onclick= 'location.href=\"s_bill.php?x=$sid&y=$cid\";'; '>Show Bill</button>
                           </div> </td>";
                    echo "</tr>";
                }
                ?>

            </table>
        </div>
    </div>


        <div class="button-wrapper">
            <button class='back-btn' onclick='location.href="bills.php?x=<?php echo $cid; ?>";'>Return To Previous Page</button>
        </div>


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


