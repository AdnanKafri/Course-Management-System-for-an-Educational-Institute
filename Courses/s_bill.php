<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: new.php");
    exit();

}
require_once "database.php";


$sid=$_GET['x'];
$cid=$_GET['y'];

//echo $cid,$sid;

$sql="select * from students,bill,courses 
      WHERE students.student_id=bill.s_id AND courses.course_id=bill.c_id AND bill.c_id='$cid' AND bill.s_id='$sid'";
$stmt=$conn->query($sql,PDO::FETCH_ASSOC);
$res=$stmt->fetchAll();
//echo "<pre>";
//print_r($res);
//echo "</pre>";
$name=$res[0]["student_name"];
$gender=$res[0]["gender"];
$email=$res[0]["email"];
$address=$res[0]["address"];
$phone=$res[0]["s_phone"];
$CourseName=$res[0]["name"];
$CourseTeacher=$res[0]["course_teacher"];
$payment=$res[0]["paytype"];
$coast=$res[0]["price"];
$date=$res[0]["b_date"];


echo "<br>";
?>

<html>
<head>
    <title>Student Bill</title>
    <link rel="stylesheet" href="style2.css">

</head>
<body>
<?php
if($_SESSION['type']=='student')
{
    ?>
<div class="container1" >


    <form align="center">

        <h1 align="center">You Have Signed In This Course</h1><br><br>
        <h2 style="background-color: lightslategrey">Your Information:</h2><br>
        <h3>Student Name: <?php echo $name;?> | <?php echo $gender;?></h3><br>
        <h3>Student Email: <?php echo $email;?> </h3><br>
        <h3>Student Address: <?php echo $address;?> </h3><br>
        <h3>Student Phone Number: <?php echo $phone;?> </h3><br>
        <h3>Your Payment Type For This Course: <?php echo $payment;?> </h3><br>
        <h2 style="background-color: lightslategrey">Course Information:</h2><br>
        <h3>Course's Subject Name: <?php echo $CourseName;?> </h3><br>
        <h3>Teacher Name: <?php echo $CourseTeacher;?> </h3><br>
        <h3>Course Price: <?php echo $coast;?> </h3><br>
        <h3>You Signed in This Course in: <?php echo $date;?> </h3><br>

       </form>
</div>
        <button class="show-course-btn" onclick='location.href="my.php";'>Return To My Courses Page</button>
        <?php
    }
    else{?>
        <div class="container1" >


            <form align="center">

                <h1 align="center">Student Bill</h1><br><br>
                <h2 >Student Information:</h2><br>
                <h3>Student Name: <?php echo $name;?> | <?php echo $gender;?></h3><br>
                <h3>Student Email: <?php echo $email;?> </h3><br>
                <h3>Student Address: <?php echo $address;?> </h3><br>
                <h3>Student Phone Number: <?php echo $phone;?> </h3><br>
                <h3>Student Payment Type For This Course: <?php echo $payment;?> </h3><br>
                <h2>Course Information:</h2><br>
                <h3>Course's Subject Name: <?php echo $CourseName;?> </h3><br>
                <h3>Teacher Name: <?php echo $CourseTeacher;?> </h3><br>
                <h3>Course Price: <?php echo $coast;?> </h3><br>
                <h3>Student Signed in This Course in: <?php echo $date;?> </h3><br>

            </form>
        </div>
        <button class="show-course-btn" onclick='location.href="bills_list.php?x=<?php echo $cid; ?>";'>Return To The Previous Page</button>
    <?php
    }
        ?>
        </body>
</html>
<?php
$conn=null;

