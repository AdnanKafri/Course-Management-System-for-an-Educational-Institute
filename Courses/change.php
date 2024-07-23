<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: new.php");
    exit();

}
$num=$_GET['x'];
require_once "database.php";

$sq="select * from courses where course_id='$num'";
$res=$conn->query($sq);
$res1=$res->fetch();
$name1 = $res1["name"];
$date1 = $res1["start_date"];
$date2 = $res1["end_date"];
$price = (int)$res1["price"]/1000;
$max = $res1["max_num"];
$info =$res1["info"];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Edit Course</title>
</head>
<body style="    background-color: #c9d6ff;">
<div class="container" style="background-color: white">
    <?php
if($_SESSION['type']=="teacher"){

if (isset($_POST["save"])) {
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
    if($name1!==$name){
        $sql = "SELECT * FROM courses WHERE name = '$name'";
        $result = $conn->query($sql);
        $rowCount = $result->fetchColumn();
        if ($rowCount>0) {
            array_push($errors,"Course already exists!");
        }
    }

    if (count($errors)>0) {
        foreach ($errors as  $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }else{
        $sql="UPDATE `courses` 
                SET name=?, price=?, start_date=?, end_date=?, max_num=?, info=?
                WHERE course_id = $num";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $price);
            $stmt->bindParam(3, $date1);
            $stmt->bindParam(4, $date2);
            $stmt->bindParam(5, $max);
            $stmt->bindParam(6, $info);
            $stmt->execute();
            echo "<div class='alert alert-success'>
                Course Edited Successfully</div>";
        }else{
            die("Something went wrong");
        }
    }


}


?>

    <div class="form-group">
        <h1 align="center" style="background-color: #f3edfc">Edit Course</h1>
        <br><br>
        <h3>Enter The New Course Information</h3><br>
        <form action="change.php?x=<?php echo $num; ?>" method="post">
        Course Name: (Name Of The Course's Subject)<br>
        <input type="text"  placeholder="Enter Course Name" name="name" class="form-control" value="<?php echo $name1; ?>" required>
    </div>
    <div class="form-group">
        Start Date:<br>
        <input required type="date" value="<?php echo $date1; ?>" name="date1" class="form-control" >
    </div>
    <div class="form-group">
        End Date:<br>
        <input type="date" name="date2" value="<?php echo $date2; ?>" class="form-control" required>
    </div>
    <div class="form-group">
        Price Per Student (In Syrian Pounds):<br>
        <input required type="number" placeholder="Price" value="<?php echo $price; ?>" name="price" step="5" min="5" max="200">
        ,000 SYP
    </div>
    <div class="form-group">
        Maximum Student Number:<br>
        <input required type="number" placeholder="Maximum Student Number" value="<?php echo $max; ?>" name="max" max="40" min="5" class="form-control">
    </div>
    <div class="form-group">
        Information About The Course:<br>
        <textarea required name="info" cols="65" maxlength="255" rows="5"  class="form-control" placeholder="About The Course in 255 Letters"><?php echo $info; ?></textarea>
    </div>
    <div class="form-btn">
        <input type="submit" value="Save" name="save" class="btn btn-primary">
        <button class='btn btn-primary' style="background-color: #5a6268"><a style="color: white" href="Edit.php">Return</a></button>
    </div>
</div>
</form>
</body>
</html>
<?php
    }
else
{
    echo "you don't have Permission To Enter This Page<br>";
    echo "<button class='back-btn' onclick='location.href=\"home.php\";'>Return To Home</button>";


}
$conn=null;
?>