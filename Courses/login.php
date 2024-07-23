<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}
?>
<?php
$ps="Password does not match,please check your password ";
$em="Email does not match,please check your email ";
    require_once "new.php";

    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        require_once "database.php";
        $sql = "SELECT * FROM students WHERE email = '$email'";

        $result = $conn->query($sql);
        $user = $result->fetchAll();
        if ($user) {

            if ($password===$user[0]['password']) {
                session_start();
                $_SESSION["user"] = $email;
                $_SESSION["type"]="student";
                header("Location: home.php");
                die();
            }else{

//                echo "<div class='alert alert-danger'>Password does not match</div>";
                echo "<script>
                      alert('".$ps."');  
                      </script>";
            }
        }else
        {   $sql = "SELECT * FROM teachers WHERE t_email = '$email'";
            $result = $conn->query($sql) ;
            $user = $result->fetchAll();
            if ($user) {

                if ( $password===$user[0]['t_password']) {
                    session_start();
                    $_SESSION["user"] = $email;
                    $_SESSION["type"]="teacher";

                    header("Location: home.php");
                    die();
                }else{

//                echo "<div class='alert alert-danger'>Password does not match</div>";
                    echo "<script>
                      alert('".$ps."');  
                      </script>";
                }
            }

        else{
//            echo "<div class='alert alert-danger'>Email does not match</div>";
            echo "<script>
                      alert('".$em."');  
                      </script>";
        }
        }

    }
    $conn=null;
    ?>
