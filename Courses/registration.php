<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}
?>

    <?php
$st=" ";
$scss="Welcome,You are registered successfully.";
//    require_once "new.php";
    if (isset($_POST["submit"])) {

        $fullName = $_POST["fullname"];
        $email = $_POST["email"];
        $gender=$_POST["gender"];
        $level=$_POST["level"];
        $bdate=$_POST["bdate"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["repeat_password"];


        $errors = array();

        if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat)OR empty($bdate)) {
            array_push($errors,"All fields are required ");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
        }
        if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
        }
        if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
        }
        if($level==="none"){
            array_push($errors,"Please Choose Your Education Level");
        }if($bdate===null){
            array_push($errors,"Please Put Your BirthDate");
        }
        require_once "database.php";
        $sql = "SELECT * FROM students WHERE email = '$email'";
        $result = $conn->query($sql);
        $rowCount1 = $result->fetchColumn();
        if ($rowCount1>0) {
            array_push($errors,"Email already exists!");
        }

            $sql = "SELECT * FROM teachers WHERE t_email = '$email'";
            $result = $conn->query($sql);
            $rowCount = $result->fetchColumn();
            if ($rowCount > 0) {
                array_push($errors, "Email already exists!");
            }

        if (count($errors)>0) {
            foreach ($errors as  $error) {
            $st=$st.'\n'.(string)$error;
            }
            echo "<script>
                      alert('".$st."');  
                      </script>";
        }else{

                $sql2="INSERT INTO students (student_name, Education_level, gender, birth_date, email, password) 
                    VALUES (:student_name, :Education_level, :gender, :birth_date, :email, :password)";
                $stmt = $conn->prepare($sql2);

                if ($stmt) {
                    $stmt->bindParam(':student_name', $fullName);
                    $stmt->bindParam(':Education_level', $level);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':birth_date', $bdate);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $password);
                    $stmt->execute();
//                echo "<div class='alert alert-success'>
//                You are registered successfully.</div>";
//                    @session_start();
                    $_SESSION["user"] = $email;
                    $_SESSION["type"]="student";

                    echo "<script type=\"text/javascript\">";
                    echo "alert('".$scss."');";
                    echo "window.location.href = \"home.php\"; ";
                    echo "</script>";

                    //header("Location: new.php");

                }else{
                    die("Something went wrong");
                }


        }


    }
$conn=null;
    ?>
