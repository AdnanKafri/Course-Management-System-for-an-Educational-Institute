<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: new.php");
    exit();
}
    require_once "database.php";


$cid=$_GET['x'];
//print_r($url_components);
//echo $num;
    $ue=$_SESSION["user"];
    $sql1="select * from students where email='$ue'";
    $stmt1=$conn->query($sql1);
    $res1=$stmt1->fetchAll();
    $sid = $res1[0]["student_id"]; //students

$sql = "SELECT * FROM bill WHERE s_id='$sid' AND c_id='$cid'";
$result = $conn->query($sql);
$rowCount = $result->fetchColumn();
if ($rowCount>0) {

           header("Location:s_bill.php?x=$sid&y=$cid");
}else {

    if (isset($_POST["sign"])) {
//    $sql="select * from courses where course_id='$num'";
//    $stmt=$conn->query($sql);
//    $res=$stmt->fetchAll();
//    print_r($res);
        //==================
//    print_r($res1);
        //=================
//    $sname = $res1[0]["student_name"]; //students
//    $semail = $res1[0]["email"];//students
//    $co_name = $res[0]["name"];//course
//    $co_teacher = $res[0]["course_teacher"];//course
//    $coast = $res[0]["price"];//course
        $s_phone = $_POST["phone"];//post
        $paytype = $_POST["payment"];//post
        $address = $_POST["address"];//post
        $timestamp=time()+7200;
        $b_date = date('d M Y H:i:s ',$timestamp);//function

        $errors = array();

        if (empty($s_phone) or empty($paytype) or empty($address)) {
            array_push($errors, "All fields are required");
        }
        if($paytype==="none") {
            array_push($errors, "Please Select The Payment Type You Want To Choose");
        }
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            $stmt = $conn->prepare
            ("INSERT INTO bill ( c_id, s_id, s_phone, paytype, address, b_date)
                    VALUES ( :c_id, :s_id, :s_phone, :paytype, :address, :b_date)");

            if ($stmt) {
                $stmt->bindParam(':c_id', $cid);
                $stmt->bindParam(':s_id', $sid);
                $stmt->bindParam(':s_phone', $s_phone);
                $stmt->bindParam(':paytype', $paytype);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':b_date', $b_date);
                $stmt->execute();
                echo "<script type='text/javascript'>
                alert('You Have Signed In The Course Successfully');
                window.location= \"sign.php\";
              </script>";
            header("Location=sign.php");
            } else {
                die("Something went wrong");
            }
        }


    }

}
?>
<html>
<head>
    <title>Sign In Course</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">

</head>
<body>
<div class="container">


    <form action="sign2.php?x=<?php echo $cid; ?>" method="post">
        <h1 align="center" style="background-color: #f3edfc">Sign In Course</h1>
        <br><br>
        <h3 align="center">Please Complete you information to sign in the course</h3><br>
        <!-- حقل العنوان -->
        <label for="address">Address</label>
        <input type="text" id="address" name="address" placeholder="Enter Your Address:" required>
        <!-- حقل الهاتف -->
        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone" maxlength="15" placeholder="Enter Your Phone Number: 0912345678" required>
        <!-- حقل طريقة الدفع -->
        <label for="payment">Payment Type</label>
        <select id="payment" name="payment" required>
            <option value="none">--Choose--</option>
            <option value="credit">Credit Card</option>
            <option value="paypal">Paypal</option>
            <option value="cash">Cash</option>
        </select>
        <!-- زر التسجيل -->
        <button type="submit" name="sign">Complete And Make Bill</button>
        <button style="background-color: #6c757d" onclick='location.href="sign.php";'>Return To The Previous Page</button>
    </form>
</div>
</body>
</html>
<?php
$conn=null;
