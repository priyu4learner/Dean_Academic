<?php
session_start();
require 'connection.php';
$flag2=$flag3=$sem=0;
$id=$_SESSION["id"];
$sql="SELECT * from admin";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$flag2=$row["distribution"];
$flag3=$row["enter"];
$id=$_SESSION["id"];
$sql="SELECT * from student where regno=$id";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$branch=$row["branch"];
$program=$row["program"];
$sql="SELECT * from currsem where regno=$id";
$result=mysqli_query($conn,$sql);
if($result){
    $row=mysqli_fetch_assoc($result);
    $sem=$row["semester"];
}else{
    $sem=9;
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
    <style>
        table{
            border:1px solid black;
            margin-top:2rem;
        }
        td{
            border:1px solid black;
            padding:1rem;
        }
    </style>
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
    </div>
    <!-------------------Content-------------->
    <div class="container content mt-5">
        <h2>Profile</h2>
        <hr style="width: 6vw;margin-left: 0vw;border: 2px solid;;margin-top: 1vw;">
        <p><?php echo "Name: ".$_SESSION["name"];?></p>
        <p><?php echo "Registration Number: ".$_SESSION["id"];?></p>
        <p><?php echo "Branch: ".$branch;?></p>
        <p><?php echo "Semester: ".$sem;?></p>
        <p><?php echo "Program: ".$program;?></p>
    </div>
    <hr class="container">
    <!--------To get courses---------->
    <div class="container">
        <h3>Click to get your courses:</h3>
        <form method="post" action="">
            <input type="submit" name="submit5" value="Click here" onclick="show();" id="course">
            <font size="3rem" color="red"><?php if($flag2==1)echo "(Course Entry is not completed)" ?></font>
        </form>
        <table id='courses' display="none">
        <?php
        $id="";
        if(isset($_POST["submit5"])){
            $id=$_SESSION["id"];
            $sql="";
            $sql="SELECT * from course where semester=$sem && branch='$branch' && program='$program'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)){
                //echo "<table id='courses'>";
                echo "<tr><td>CourseID</td><td>Name</td><td>Credit</td><td>Type</td></tr>";
                while($row=mysqli_fetch_assoc($result)){
                    echo"<tr><td>".$row["courseid"]."</td><td>".$row["name"]."</td><td>".$row["credit"]."</td><td>".$row["type"]."</td></tr>";
                }
                //echo "</table>";
            }else{
                echo "<p>No record found.</p>";
            }
        }
        ?>
        </table>
    </div>
    <hr class="container">
    <!--------To get transcript---------->
    <div class="container">
        <h3>Click to get your transcript:</h3>
        <form method="post" action="">
            <input type="submit" name="submit6" value="Click here">
        </form>
        <?php
        $id="";
        $sum=$sumCredit=$flag=0;
        if(isset($_POST["submit6"])){
            $id=$_SESSION["id"];
            if($sem==1){
                echo "<p>No record found</p>";
            }else{
                $sql="SELECT * from course natural join markstheory where studentid=$id and semester<$sem order by semester desc";
                $result=mysqli_query($conn,$sql);
                if($result){
                    $count=$sem-1;
                    echo "<p>Semester: ".$count."</p>";
                    echo "<table>";
                    echo "<tr><td>Code</td><td>Course Name</td><td>Credit</td><td>Grade</td></tr>";
                    while($row=mysqli_fetch_assoc($result)){
                        if($row["semester"]!=$count){
                            $count=$row["semester"];
                            echo "</table>";
                            echo "<p>Semester: ".$count."</p>";
                            echo "<table>";
                            echo "<tr><td>Code</td><td>Course Name</td><td>Credit</td><td>Grade</td></tr>";
                        }
                        echo"<tr><td>".$row["courseid"]."</td><td>".$row["name"]."</td><td>".$row["credit"]."</td><td>".$row["grade"]."</td></tr>";
                    }
                    echo "</table>";
                }else{
                    echo "<p>No record found</p>";
                }
                $sql="SELECT * from spicpistudent where regno=$id and semester<$sem";
                $result=mysqli_query($conn,$sql);
                if($result){
                    echo "<table>";
                    echo "<tr><td>Semester</td><td>SPI</td><td>CPI</td><td>STATUS</td></tr>";
                    while($row=mysqli_fetch_assoc($result)){
                        echo "<tr><td>".$row["semester"]."</td><td>".$row["spi"]."</td><td>".$row["cpi"]."</td><td>".$row["status"]."</td></tr>";
                    }
                    echo "</table>";
                }
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
        var x=<?php echo $flag2 ?>;
        function show(){
            if(x==1){
                document.getElementById("course").disabled=true;
                document.getElementById("courses").style.display="none";
            }else{
                document.getElementById("course").disabled=false;
                document.getElementById("courses").style.display="block";
            }
        }
    </script>
</body>

</html>