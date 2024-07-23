<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: new.php");
    exit();
}
?>
<!doctype html>
<html lang="en" xmlns:input="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body style="    background-color: #c9d6ff;">
    <div class="container" style="background-color: white">
        <?php
        require_once "database.php";
        if($_SESSION['type']=="teacher"){
        $em=$_SESSION['user'];

        $sql="select teacher_name,teacher_id from teachers where t_email='$em'";
        $result = $conn->query($sql) ;
        $user = $result->fetchAll();
        $tname=$user[0]['teacher_name'];
        $tid=$user[0]['teacher_id'];

        if (isset($_POST["add"])) {
            $name = $_POST["name"];
            $date1 = $_POST["date1"];
            $date2 = $_POST["date2"];
            $price = ($_POST["price"])*1000;
            $max = $_POST["max"];
            $info = $_POST["info"];



            $errors = array();

            if (empty($name) OR empty($date1) OR empty($date2) OR empty($price) OR empty($max) OR empty($info)) {
                array_push($errors,"All fields are required");
            }


            $sql = "SELECT * FROM courses WHERE name = '$name'";
            $result = $conn->query($sql);
            $rowCount = $result->fetchColumn();
            if ($rowCount>0) {
                array_push($errors,"Course already exists!");
            }
            if (count($errors)>0) {
                foreach ($errors as  $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }else{
                $stmt = $conn->prepare
                ("INSERT INTO courses (name ,t_id , course_teacher, price, start_date, end_date, max_num, info)
                    VALUES (:name ,:t_id , :course_teacher, :price, :start_date, :end_date, :max_num, :info)");

                if ($stmt) {
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':t_id', $tid);
                    $stmt->bindParam(':course_teacher', $tname);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':start_date', $date1);
                    $stmt->bindParam(':end_date', $date2);
                    $stmt->bindParam(':max_num', $max);
                    $stmt->bindParam(':info', $info);
                    $stmt->execute();
                    echo "<div class='alert alert-success'>
                Course Added Successfully</div>";
                }else{
                    die("Something went wrong");
                }
            }


        }
        ?>
            <form action="add.php" method="POST">
                <div class="form-group">
                    <h1 align="center" style="background-color: #f3edfc">Add New Course</h1>
                    <br><br>
                    Course Name: (Name Of The Course's Subject)<br>
                    <input type="text"  placeholder="Enter Course Name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    Start Date:<br>
                    <input required type="date" name="date1" class="form-control">
                </div>
                <div class="form-group">
                    End Date:<br>
                    <input type="date" name="date2" class="form-control">
                </div>
                <div class="form-group">
                    Price Per Student (In Syrian Pounds):<br>
                    <input required type="number" placeholder="Price" name="price" step="5" min="5" max="200">
                    ,000 SYP
                </div>
                <div class="form-group">
                    Maximum Student Number:<br>
                <input required type="number" placeholder="Maximum Student Number" name="max" max="40" min="5" class="form-control">
                </div>
                <div class="form-group">
                    Information About The Course:<br>
                    <textarea required name="info" cols="65" maxlength="255" rows="5" class="form-control" placeholder="About The Course in 255 Letters"></textarea>
                </div>
                <div class="form-btn">
                    <input type="submit" value="Add Course" name="add" class="btn btn-primary">
                </div>
                <div class="button-wrapper" align="center">
                    <button class='back-btn' onclick='location.href="home.php";'>Return To Home</button>
                    <button class='show-course-btn' onclick='location.href="show.php";'>Show Courses List</button>
                </div>

            </form>
    </div>

</body>
</html>
<?php
        }
        else {
            echo "<div style=\"all: revert\">";
            echo "you don't have Permission To Enter This Page<br>";
            echo "<button class='back-btn' onclick='location.href=\"home.php\";'>Return To Home</button>";
            echo "</div>";

        }
$conn=null;

