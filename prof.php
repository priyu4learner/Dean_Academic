<?php
session_start();
require_once 'connection.php';
$error=$error1="";
$flag2=$flag3=$sem=0;
$sql="SELECT * from admin";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$flag2=$row["distribution"];
$flag3=$row["enter"];
$year=$row["year"];
$courseid=$ms=$ta=$es="";
$id=$_SESSION["id"];
//for marks distribution for theory
if(isset($_POST["submit"])){
    $courseid=$_POST["courseid"];
    $ms=$_POST["midsem"];
    $ta=$_POST["ta"];
    $es=$_POST["endsem"];
    if($ms+$ta+$es==100){
        $sql="SELECT * from course_prof natural join course where courseid='$courseid' and emplid=$id and `year`=$year and type='Theory'";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            $sql="SELECT * from marksdistritheory where courseid='$courseid'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0){
                $sql="UPDATE marksdistritheory set midsem=$ms,ta=$ta,endsem=$es where courseid='$courseid'";
                if(mysqli_query($conn,$sql)){
                    $error="Record is updated";
                }else{
                    $error="unable to update record";
                }
            }else{
                $sql="INSERT into marksdistritheory values('$courseid',$ms,$ta,$es)";
                if(mysqli_query($conn,$sql)){
                    $error="Record is inserted";
                }else{
                    $error="unable to enter record";
                }
            }
        }else $error="Enter correct course id.";
    }else $error="Total marks must be equal to 100.";
}
//for marks distribution of practical
$courseid=$ta=$es="";
if(isset($_POST["submit1"])){
    $courseid=$_POST["courseid"];
    $ta=$_POST["ta"];
    $es=$_POST["endsem"];
    if($ta+$es==100){
        $sql="SELECT * from course_prof natural join course where courseid='$courseid' and emplid=$id and `year`=$year and type='Practical'";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            $sql="SELECT * from marksdistripractical where courseid='$courseid'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0){
                $sql="UPDATE marksdistripractical set ta=$ta,endsem=$es where courseid='$courseid'";
                if(mysqli_query($conn,$sql)){
                    $error="Record is updated";
                }else{
                    $error="unable to update record";
                }
            }
            else{
                $sql="INSERT into marksdistripractical values('$courseid',$ta,$es)";
                if(mysqli_query($conn,$sql)){
                    $error="Record is inserted";
                }else{
                    $error="unable to enter record";
                }
            }
        }else{
            $error="Enter correct course id";
        }
    }else{
        $error="Total marks must be equal to 100.";
    }
}
//for marks submission of theory

$courseid=$ms=$ta=$es=$studentid=$grade=$branch=$program="";
if(isset($_POST["submit2"])){
    $courseid=$_POST["courseid"];
    $studentid=$_POST["studentid"];
    $ms=$_POST["midsem"];
    $ta=$_POST["ta"];
    $es=$_POST["endsem"];
    $sql="SELECT * from student where regno=$studentid";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)<=0){
        $error1="Enter correct student id";
    }else{
        $row=mysqli_fetch_assoc($result);
        $branch=$row["branch"];
        $program=$row["program"];
        $sql="SELECT * from currsem where regno=$studentid";
        $result=mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);
        $sem=$row["semester"];
        $sql="SELECT * from course where semester=$sem && branch='$branch' && program='$program' 
            && type='Theory' && courseid in(select courseid from course_prof where emplid=$id and `year`=$year)";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            $sql="SELECT * from marksdistritheory where courseid='$courseid'";
            $result=mysqli_query($conn,$sql);
            if($result and mysqli_num_rows($result)>0){
                $row=mysqli_fetch_assoc($result);
                if($ms<=$row["midsem"] and $ta<=$row["ta"] and $es<=$row["endsem"]){
                    $total=$ms+$ta+$es;
                    if($total>85)$grade="A+";
                    else if($total>=75 and $total<=84)$grade="A";
                    else if($total>=65 and $total<=74)$grade="B+";
                    else if($total>=55 and $total<=64)$grade="B";
                    else if($total>=45 and $total<=54)$grade="C";
                    else if($total>=40 and $total<=44)$grade="D";
                    else $grade="E";
                    $sql="SELECT * from markstheory where courseid='$courseid' and studentid=$studentid";
                    $result=mysqli_query($conn,$sql);
                    if($result and mysqli_num_rows($result)>0){
                        $sql="UPDATE markstheory set midsem=$ms,ta=$ta,endsem=$es,grade='$grade',semester=$sem where courseid='$courseid' and studentid=$studentid";
                        if(mysqli_query($conn,$sql)){
                            $error1="Record is inserted";
                        }else{
                            $error1="unable to enter record1";
                        }
                    }else{
                        $sql="INSERT into markstheory values('$courseid',$studentid,$ms,$ta,$es,'$grade',$sem,$year)";
                        if(mysqli_query($conn,$sql)){
                            $error1="Record is inserted";
                        }else{
                            $error1="unable to enter record";
                        }
                    }
                }else{
                    $error1="Enter marks according to distribution";
                }
            }
            else{
                $error1="Enter correct course id";
            }
        }else{
            $error1="Enter correct details";
        }
    }
}
//for marks submission of practical
$courseid=$ta=$es=$studentid=$grade=$program=$branch="";
if(isset($_POST["submit3"])){
    $courseid=$_POST["courseid"];
    $studentid=$_POST["studentid"];
    $ta=$_POST["ta"];
    $es=$_POST["endsem"];
    $sql="SELECT * from student where regno=$studentid";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)<=0){
        $error1="Enter correct student id";
    }else{
        $row=mysqli_fetch_assoc($result);
        $branch=$row["branch"];
        $program=$row["program"];
        $sql="SELECT * from currsem where regno=$studentid";
        $result=mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);
        $sem=$row["semester"];
        $sql="SELECT * from course where semester=$sem && branch='$branch' && program='$program' && type='Practical' && courseid in (select courseid from course_prof where emplid=$id and `year`=$year)";
        $result=mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);
        echo $courseid;
        if($result and mysqli_num_rows($result)>0){
            $sql="SELECT * from marksdistripractical where courseid='$courseid'";
            $result=mysqli_query($conn,$sql);
            if($result and mysqli_num_rows($result)>0){
                $row=mysqli_fetch_assoc($result);
                if($ta<=$row["ta"] and $es<=$row["endsem"]){
                    $total=$ta+$es;
                    if($total>85)$grade="A+";
                    else if($total>=75 and $total<=84)$grade="A";
                    else if($total>=65 and $total<=74)$grade="B+";
                    else if($total>=55 and $total<=64)$grade="B";
                    else if($total>=45 and $total<=54)$grade="C";
                    else if($total>=40 and $total<=44)$grade="D";
                    else if($total<40)$grade="E";
                    $sql="SELECT * from markspractical where courseid='$courseid' and studentid=$studentid";
                    $result=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)>0){
                        $sql="UPDATE markspractical set ta=$ta,endsem=$es,grade='$grade',semester=$sem where courseid='$courseid' and studentid=$studentid";
                        if(mysqli_query($conn,$sql)){
                            $error1="Record is inserted";
                        }else{
                            $error1="unable to enter record1";
                        }
                    }else{
                        $sql="INSERT into markspractical values('$courseid',$studentid,$ta,$es,'$grade',$sem,$year)";
                        if(mysqli_query($conn,$sql)){
                            $error1="Record is inserted";
                        }else{
                            $error1="unable to enter record";
                        }
                    }
                }else{
                    $error1="Enter marks according to distribution";
                }
            }else{
                $error1="Enter correct course id";
            }
        }else{
            $error1="Enter correct details";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dean Academics MNNIT</title>
    <link rel="shortcut icon" href="image/MNNIT.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <Style>
        table {
            border: 1px solid black;
            margin-top: 2rem;
        }

        td {
            border: 1px solid black;
            padding: 1rem;
        }
    </Style>
</head>

<body>
    <!-----------------header section---------------->
    <div class="header row">
        <div class="logo-mnnit col col-12 ">
            <img id="logo" class="img-fluid" src="image/MNNIT-logo.png" alt="">
        </div>
        <div class="header_column col row">
            <div class="col-12" style="color: #3db7ef; padding-bottom: 1rem;">
                MOTILAL NEHRU NATIONAL INSTITUTE OF TECHNOLOGY ALLAHABAD <br>
                <span class="small">Office of The Dean (Academic) |<font size="2px" color="#471923"> Email:
                        academics@mnnit.ac.in</font></span>
            </div>
            <div class="col-12 navbar">
                <div class="col-4 item"><button type="button" class="btn" data-bs-toggle="modal"
                        data-bs-target="#profLogin"></button></div>
                <div class="col-4 item" style="border-left: white solid;"><button type="button" class="btn "
                        data-bs-toggle="modal" data-bs-target="#studLogin"></button></div>
                <div class="col-4 item" style="border-left: white solid;"><a href="logout.php">Log out</a></div>
            </div>
        </div>
    </div>
    <!-------------------Content-------------->
    <div class="container content m-5">
        <h2>Profile</h2>
        <hr style="width: 6vw;margin-left: 0vw;border: 2px solid;;margin-top: 1vw;">
        <p>
            <?php echo "Name: ".$_SESSION["name"];?>
        </p>
        <p>
            <?php echo "Employee ID: ".$_SESSION["id"];?>
        </p>
    </div>
    <hr class="container">
    <!------------------Marks distribution---------->
    <div class="container">
        <h4>Marks Distribution:<font size="1rem" color="red">
                <?php if($flag2==0)echo "(Marks Distribution is Disabled)" ?>
            </font>
        </h4>
        <div class="mt-4 mb-2" id="dis">
            <input type="radio" name="coursetype" id="" value="theory" onclick="show1();">Theory
            <input type="radio" name="coursetype" id="" value="practical" onclick="show2();">Practical <br>
            Marks Contribution: <span>
                <font size="0.6rem" weight="bold">(Enter contribution between 1-100)</font>
            </span>
        </div>
        <div id="theo" style="display: none;">
            <form method="post" action="">
                <div class="m-1">
                    <label for="courseid" style="width:10rem">Course Id</label>
                    <input type="text" name="courseid" id="">
                </div>
                <div class="m-1">
                    <label for="" style="width:10rem">Mid Semester</label>
                    <input type="text" name="midsem">
                </div>
                <div class="m-1">
                    <label for="" style="width:10rem">Teacher assessment</label>
                    <input type="text" name="ta">
                </div>
                <div class="m-1">
                    <label for="" style="width:10rem">End Semester</label>
                    <input type="text" name="endsem">
                </div>
                <div>
                    <input type="submit" name="submit" id="btn1">
                </div>
            </form>
        </div>
        <div id="prac" style="display: none;">
            <form method="post" action="">
                <div class="m-1">
                    <label for="courseid" style="width:10rem">Course Id</label>
                    <input type="text" name="courseid" id="">
                </div>
                <div class="m-1">
                    <label for="" style="width:10rem">Teacher assessment</label>
                    <input type="text" name="ta">
                </div>
                <div class="m-1">
                    <label for="" style="width:10rem">End Semester</label>
                    <input type="text" name="endsem">
                </div>
                <div>
                    <input type="submit" name="submit1" id="btn2">
                </div>
            </form>
        </div>
    </div>
    <font color="red" size="3rem">
        <p class="container">
            <?php echo $error ?>
        </p>
    </font>
    <hr class="container">
    <!--------------marks entering------------->
    <div class="container ">
        <h4>Marks Submission:<font size="1rem" color="red">
                <?php if($flag3==0)echo "(Marks Entering is Disabled)" ?>
            </font>
        </h4>
        <div class="mt-4 mb-2" id="sub">
            <input type="radio" name="coursetype" id="" value="theory" onclick="show3();">Theory
            <input type="radio" name="coursetype" id="" value="practical" onclick="show4();">Practical <br>
            Marks: <span>
                <font size="0.6rem">(Enter marks according to distribution entered)</font>
            </span>
        </div>
        <div id="theo1" style="display: none;">
            <form method="post" action="">
                <div class="m-1">
                    <label for="courseid" style="width:10rem">Course Id</label>
                    <input type="text" name="courseid" id="">
                </div>
                <div class="m-1">
                    <label for="studentid" style="width:10rem">Student Reg. No.</label>
                    <input type="text" name="studentid" id="">
                </div>
                <div class="m-1">
                    <label for="" style="width:10rem">Mid Semester</label>
                    <input type="text" name="midsem">
                </div>
                <div class="m-1">
                    <label for="" style="width:10rem">Teacher assessment</label>
                    <input type="text" name="ta">
                </div>
                <div class="m-1">
                    <label for="" style="width:10rem">End Semester</label>
                    <input type="text" name="endsem">
                </div>
                <div>
                    <input type="submit" name="submit2" id="btn3">
                </div>
            </form>
        </div>
        <div id="prac1" style="display: none;">
            <form method="post" action="">
                <div class="m-1">
                    <label for="courseid" style="width:10rem">Course Id</label>
                    <input type="text" name="courseid" id="">
                </div>
                <div class="m-1">
                    <label for="studentid" style="width:10rem">Student Reg. No.</label>
                    <input type="text" name="studentid" id="">
                </div>
                <div class="m-1">
                    <label for="" style="width:10rem">Teacher assessment</label>
                    <input type="text" name="ta">
                </div>
                <div class="m-1">
                    <label for="" style="width:10rem">End Semester</label>
                    <input type="text" name="endsem">
                </div>
                <div>
                    <input type="submit" name="submit3" id="btn4">
                </div>
            </form>
        </div>
    </div>
    <font color="red" size="3rem">
        <p class="container">
            <?php echo $error1 ?>
        </p>
    </font>
    <hr class="container">
    <!--------------to show courses----------->
    <div class="container">
        <h3>Click to get your courses:</h3>
        <form method="post" action="">
            <input type="submit" name="submit5" value="Click here">
        </form>
        <?php
    $id="";
    if(isset($_POST["submit5"])){
        $id=$_SESSION["id"];
        $sql="SELECT * from course where courseid in(SELECT courseid from course_prof where emplid=$id and `year`=$year)";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)){
            echo "<table>";
            echo "<tr><td>CourseID</td><td>Name</td><td>Credit</td><td>Type</td></tr>";
            while($row=mysqli_fetch_assoc($result)){
                echo"<tr><td>".$row["courseid"]."</td><td>".$row["name"]."</td><td>".$row["credit"]."</td><td>".$row["type"]."</td></tr>";
            }
            echo "</table>";
        }else{
            echo "<p>No record found.</p>";
        }
    }
    ?>
    </div>
    <!----------footer------------>
    <div class="footer container-fluid">
        Priya Kumari <br>
        Registration Number-20204148 <br>
        Third Year, MNNIT Allahabad <br>
        Web Team, Dean Academics <br>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD"
        crossorigin="anonymous"></script>
    <script>
        var x =<?php echo $flag2; ?>;
        var y =<?php echo $flag3; ?>;
        function show1() {
            if (x == 1) {
                document.getElementById('theo').style.display = 'block';
                document.getElementById('prac').style.display = 'none';
                document.getElementById('prac1').style.display = 'none';
                document.getElementById('theo1').style.display = 'none';
            } else {
                document.getElementById('dis').style.display = 'none';
            }
        }
        function show2() {
            if (x == 1) {
                document.getElementById('prac').style.display = 'block';
                document.getElementById('theo').style.display = 'none';
                document.getElementById('prac1').style.display = 'none';
                document.getElementById('theo1').style.display = 'none';
            } else {
                document.getElementById('dis').style.display = 'none';
            }
        }
        function show3() {
            if (y == 1) {
                document.getElementById('theo1').style.display = 'block';
                document.getElementById('prac1').style.display = 'none';
                document.getElementById('prac').style.display = 'none';
                document.getElementById('theo').style.display = 'none';
            } else {
                document.getElementById('sub').style.display = 'none';
            }
        }
        function show4() {
            if (y == 1) {
                document.getElementById('prac1').style.display = 'block';
                document.getElementById('theo1').style.display = 'none';
                document.getElementById('prac').style.display = 'none';
                document.getElementById('theo').style.display = 'none';
            } else {
                document.getElementById('sub').style.display = 'none';
            }
        }
    </script>
</body>

</html>