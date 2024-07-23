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
    <title>Sign</title>
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


<div class="container">

    <div class='table-container'>
        <div class='table-wrapper'>
            <table>
                <tr>
                    <th>Course ID</th>
                    <th>Course Teacher</th>
                    <th>Course Name</th>
                    <th>Price Per Student</th>
                    <th class='date-cell'>Start Date</th>
                    <th class='date-cell'>End Date</th>
                    <th>Max Students</th>
                    <th>Course Information</th>
                    <th>Sign Now!</th>
                </tr>

                <?php
                require_once "database.php";
                $bool=0;
                $ue=$_SESSION["user"];
                $sql1="select * from students where email='$ue'";
                $stmt1=$conn->query($sql1);
                $res1=$stmt1->fetchAll();
                $sid = $res1[0]["student_id"];

                $sql = "SELECT * FROM courses";
                $res = $conn->query($sql, PDO::FETCH_OBJ);
                foreach ($res as $row) {
                    echo "<tr>";
                    foreach ($row as $key => $item) {
                        if($key === 'course_id')
                        {
                            $id=$item;
                        }
                        if ($key === 'start_date' || $key === 'end_date') {
                            echo "<td class='date-cell'>$item</td>";
                        } elseif ($key === 'price') {
                            echo "<td>$item SYP</td>";
                        }elseif ($key === 't_id') {
                            continue;
                        } else {
                            echo "<td>$item</td>";
                        }
                        $q="select * from bill where c_id=$id and s_id=$sid";
                        $re=$conn->query($q);
                        $fe=$re->rowCount();
                        if($fe>0)
                        {
                            $bool=1;
                        }
                        else
                        {
                            $bool=0;
                        }
                    }
                    echo "<td>";
                    if($bool)
                    {
                        //$_SESSION["course_id"]=$id;
                        echo "<div >
                            <button class='back-btn' style='background-color: lightsalmon' onclick= 'location.href=\"s_bill.php?x="."$sid&y=$id"."\";'; '>Show Bill</button>
                           </div>";

                    }
                else
                    {
                        echo "<div >
                            <button class='back-btn' style='background-color: cadetblue' onclick= 'location.href=\"sign2.php?x="."$id"."\";'; '>Sign</button>
                           </div>";
                    }
                    echo "</td>";

                    echo "</tr>";

                }
                ?>




            </table>
        </div>
    </div>

    <?php
    if($_SESSION["type"]=="teacher")
    {
        ?>
        <div class="button-wrapper">
            <button class='back-btn' onclick='location.href="home.php";'>Return To Home</button>
            <button class='add-course-btn' onclick='location.href="add.php";'>Add New Course</button>
        </div>
    <?php }
    else{
        ?>
        <div class="button-wrapper">
            <button class='back-btn' onclick='location.href="home.php";'>Return To Home</button>
            <!--            <button class='add-course-btn' onclick='location.href="add.php";'>Add New Course</button>-->
        </div>
    <?php } $conn=null;?>



</div>

</body>

</html>