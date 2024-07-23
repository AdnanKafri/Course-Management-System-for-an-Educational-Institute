<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: new.php");
    exit();

}
if($_SESSION['type']=="teacher"){
    $num=$_GET['x'];


if (isset($_POST["yes"])) {
    require_once "database.php";
    $sql = "DELETE FROM courses WHERE `course_id` ='$num'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    header("Location: edit.php");
    exit();
} elseif (isset($_POST["no"])) {
    header("Location: edit.php");
    exit();
}
?>
<!-- Replace the content of the head and body with the following styles for Style 2 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Course</title>
    <link rel="stylesheet" href="style4.css">
</head>
<body>
<form id="deleteForm" action="delete.php?x=<?php echo $num; ?>" method="post">
    <h1>Confirm Deletion</h1>
    <p>Are you sure you want to delete this course?</p>
    <input type="submit" name="yes" value="Yes" onclick="showConfirmation()">
    <button type="button" onclick="cancelDelete()">No</button>
</form>

<script>
    function showConfirmation() {
        var form = document.getElementById('deleteForm');
        form.classList.add('shake');
        setTimeout(function () {
            form.submit();
        }, 300);
    }

    function cancelDelete() {
        window.location.href = 'edit.php';
    }
</script>
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