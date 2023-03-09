<?php
    session_start();
    require 'connection.php';
    $sql="SELECT * from admin";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    $year=$row["year"];
    $error="";
    $error3=$error4=$error5="";
    if (isset($_POST["submit"])){
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $courseid=test_input($_POST["courseid"]);
        $emplid=test_input($_POST["emplid"]);
        $sql="SELECT * from course where courseid='$courseid' and branch in (select department from professor where emplid=$emplid)";
        $result=mysqli_query($conn,$sql);
        if($result and mysqli_num_rows($result)>0){
            $sql="SELECT * from course_prof where courseid='$courseid' and `year`=$year";
            $result=mysqli_query($conn,$sql);
            $count=mysqli_num_rows($result);
            if($count>0){
                $sql1="UPDATE course_prof set emplid=$emplid where courseid='$courseid' and `year`=$year";
            }else{
                $sql1="INSERT INTO course_prof values('$courseid',$year,$emplid)";
            }
            if(mysqli_query($conn,$sql1)){
                $error="Course added.";
            }
            else{
                $error="Error: Record is not inserted.";
            }
        }else{
            $error="Enter correct courseid or emplid";
        }
    }
    $flag=0;
    $error1="";
    if(isset($_POST["submit1"])){
        $flag=$_POST['dist'];
        $sql="UPDATE admin set distribution=$flag";
        if(mysqli_query($conn,$sql)){
            if($flag==1)$error1="Marks distribution is enabled.";
            else $error1="Marks distribution is disabled";
        }else{
            $error1="Unable to enable/disable marks distribution.";
        }
    }
    $flag1=0;
    $error2="";
    if(isset($_POST["submit2"])){
        $flag1=$_POST['entry'];
        $sql="UPDATE admin set enter=$flag1";
        if(mysqli_query($conn,$sql)){
            if($flag1==1)$error2="Marks entry is enabled.";
            else $error2="Marks entry is disabled";
        }else{
            $error2="Unable to enable/disable marks entry.";
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
    <style>
        table{
            margin-top:0;
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
    <!-------------------Content-------------->
    <div class="row m-5">
        <div class="container content col col-3">
            <h2>Profile</h2>
            <hr style="width: 6vw;margin-left: 0vw;border: 2px solid;;margin-top: 1vw;">
            <p>
                <?php echo "Name: ".$_SESSION["name"];?>
            </p>
            <p>
                <?php echo "Employee ID: ".$_SESSION["id"];?>
            </p>
        </div>
<!------------Course detail-------------------->
        <div class="col-8">
            <div class="row">
                <div class="col-6 border bg-light rounded p-4">
                    <div class="row">
                        <h4>Enter Course Details :</h4>
                    </div>
                    <form method="post" action="">
                        <div class="row mb-3">
                            <label for="courseid" class="col-12 col-form-label">Course Id</label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="courseid" name="courseid">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="emplid" class="col-12 col-form-label">Employee Id</label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="emplid" name="emplid">
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" name="submit">
                    </form>
                    <p style="color:red;"><?php echo $error ?></p>
                </div>
<!------------To enable/diable marks disribution------------>
                <div class="col-4 border bg-light rounded p-4">
                    <div class="row">
                        <h4>Marks distribution:</h4>
                    </div>
                    <form method="post" action="" class="row">
                        <input type="radio" value=1 name="dist" class="col-2">Enable
                        <input type="radio" value=0 name="dist" class="col-2">Disable
                        <input type="submit" name="submit1" class="btn-sm btn-primary container mt-3">
                    </form>
                    <p style="color:red;"><?php echo $error1 ?></p>
                    <hr class="mt-5">
                    <hr class="mb-5">
<!------------To enable/diable marks entry------------------->
                    <div class="row">
                        <h4>Marks Entering:</h4>
                    </div>
                    <form method="post" action="" class="row">
                        <input type="radio" value=1 name="entry" class="col-2">Enable
                        <input type="radio" value=0 name="entry" class="col-2">Disable
                        <input type="submit" name="submit2" class="btn-sm btn-primary container mt-3">
                    </form>
                    <p style="color:red;"><?php echo $error2 ?></p>
                </div>
            </div>
        </div>
        <div class="container row mt-4">
<!---------------To find the list of teachers who have not entered their marks----------->
            <div class="p-4 bg-light col col-6 col-md-4 col-sm-6 border ">
                <h4>List of Teachers who have not entered the marks for current semester:</h4>
                <form method="post" action="" >
                    <input type="submit" class="btn btn-primary" name="submit3" value="Click Here">
                </form>
                <p style="color:red;"><?php echo $error3 ?></p>
            </div>
<!--------------To change semester----------->
            <div class="p-4 bg-light col col-6 col-md-4 col-sm-6 border">
                <h4>Click here to Change Semester:</h4>
                <form method="post" action="">
                    <input type="submit" class="btn btn-primary" name="submit4" value="Click Here" >
                </form>
                <p style="color:red;"><?php echo $error4 ?></p>
            <?php
            if(isset($_POST["submit4"])){
                $sql="DELETE from currsem where semester>=8";
                $result=mysqli_query($conn,$sql);
                $sql="UPDATE currsem set semester=semester+1";
                $result=mysqli_query($conn,$sql);
                if($result){
                    echo $error4="Semester is changed.";
                    $sql="UPDATE admin set `year`=year(now())";
                    $result=mysqli_query($conn,$sql);
                }else{
                    echo $error4="Something went wrong :)";
                }
            }
            ?>
            </div>
<!------------To calculate result-------------------->
            <div class="p-4 bg-light col col-6 col-md-4 col-sm-6 border">
                <h4>Click here to Calculate result:</h4>
                <p><font color="red">(Click only when marks of each student is entered by respective faculties.)</font></font></p>
                <form method="post" action="">
                    <input type="submit" class="btn btn-primary" name="submit5" value="Click Here">
                </form>
                <p style="color:red;"><?php echo $error5 ?></p>
            <?php
                $id="";
                $sum=$sumCredit=$flag=$spi=0;
                if(isset($_POST["submit5"])){
                    function gradePoint($data){
                        $ans="";
                        if($data=="A+")$ans=10;
                        else if($data=="A")$ans=9;
                        else if($data=="B+")$ans=8;
                        else if($data=="B")$ans=7;
                        else if($data=="C")$ans=6;
                        else if($data=="D")$ans=4;
                        else $ans=0;
                        return $ans;
                    }

                    $sql="SELECT * from currsem";
                    $result=mysqli_query($conn,$sql);
                    if($result){
                        while($row=mysqli_fetch_assoc($result)){
                            $id=$row["regno"];
                            $sem=$row["semester"];
                            $sql="SELECT * from course natural join markstheory where studentid=$id and 
                            markstheory.semester=$sem and markstheory.courseid=course.courseid and `year`=$year";
                            $result1=mysqli_query($conn,$sql);
                            if(!$result1){
                                $error5="Something went wrong5.";
                                echo $error5;
                            }
                            while($row=mysqli_fetch_assoc($result1)){
                                $sum=$sum+($row["credit"]*gradePoint($row["grade"]));
                                $sumCredit=$sumCredit+$row["credit"];
                                if($row["grade"]=="E")$flag=1;
                            }
                            $sql="SELECT * from course natural join markspractical where studentid=$id
                                and markspractical.semester=$sem and markspractical.courseid=course.courseid and `year`=$year";
                            $result2=mysqli_query($conn,$sql);
                            if(!$result2){
                                $error5="Something went wrong6.";
                                echo $error5;
                            }
                            while($row=mysqli_fetch_assoc($result2)){
                                $sum=$sum+($row["credit"]*gradePoint($row["grade"]));
                                $sumCredit=$sumCredit+$row["credit"];
                                if($row["grade"]=="E")$flag=1;
                            }
                            if($sumCredit>0)$spi=$sum/$sumCredit;
                            $status="";
                            $cpi=0;
                            if($flag==0 and $spi>4){
                                $status="Passed";
                            } else{
                                $status="Failed";
                            }
                            $sql="SELECT * from spicpistudent where regno=$id and semester=$sem";
                            $result3=mysqli_query($conn,$sql);
                            $row=mysqli_fetch_assoc($result3);
                            if($result3 and mysqli_num_rows($result3)>0){
                                $sql="UPDATE spicpistudent set spi=$spi,status='$status',
                                    totalgradepoint=$sumCredit,year=$year where regno=$id and semester=$sem";
                                $result4=mysqli_query($conn,$sql);
                                if(!$result4){
                                    $error5="Something went wrong2.";
                                    echo $error5;
                                }
                            }else{
                                $sql="INSERT Into spicpistudent values($id,$sem,$spi,$cpi,'$status',$sumCredit,$year)";
                                $result5=mysqli_query($conn,$sql);
                                if(!$result5){
                                    $error5="Something went wrong3.";
                                    echo $error5;
                                }
                            }
                            $sum=$sumCredit=0;
                            $sql="SELECT * from spicpistudent where regno=$id";
                            $result6=mysqli_query($conn,$sql);
                            if($result6){
                                while($row=mysqli_fetch_assoc($result6)){
                                    $sum=$sum+$row["spi"]*$row["totalgradepoint"];
                                    $sumCredit=$sumCredit+$row["totalgradepoint"];
                                }
                                if($sumCredit>0)$cpi=$sum/$sumCredit;
                                if($flag==1 and $cpi<5)$status="failed";
                                $sql="UPDATE spicpistudent set cpi=$cpi,status='$status' where regno=$id and cpi=0";
                                $result7=mysqli_query($conn,$sql);
                                if(!$result7){
                                    $error5="Something went wrong4.";
                                    echo $error5;
                                }
                                $sum=$sumCredit=$spi=$cpi=0;
                            }
                        }
                    }else{
                        $error5="Something went wrong1.";
                        echo $error5;
                    }   
                    echo "Result is calculated. Check 'spicpistudent' table.";
                }
            ?>
            </div>
        </div>
    <!----------php code to list teachers------------>
        <div>
            <?php
            if(isset($_POST["submit3"])){
                $sql="CREATE or replace view currCount as select courseid,count(m.courseid) 
                        as cnt,c.branch,c.semester,c.program from markstheory as m natural join 
                        course as c where m.courseid=c.courseid and year=$year group by m.courseid";
                $result=mysqli_query($conn,$sql);
                if($result){
                    $sql="SELECT emplid,name from professor where emplid in(SELECT emplid from 
                        course_prof where `year`=$year and courseid in (select c.courseid from
                        currcount as c natural join studentcount as s where c.branch=s.branch and 
                        c.semester=s.semester and c.program=s.program and cnt<countStudent))";
                    $result=mysqli_query($conn,$sql);
                    if($result){
                        if(mysqli_num_rows($result)>0){
                            echo "<p style='margin-top:1rem;'>List of teachers:</p>";
                            echo "<table>";
                            echo "<tr><td>Employee Id</td><td>Employee Name</td></tr>";
                            while($row=mysqli_fetch_assoc($result)){
                                echo"<tr><td>".$row["emplid"]."</td><td>".$row["name"]."</td></tr>";
                            }
                            echo "</table>";
                        }else{
                            $error3="No record found.";
                            echo $error3;
                        }
                    }else{
                        $error3="Something went wrong.";
                        echo $error3;
                    }
                }else{
                    $error3="Something went wrong.";
                    echo $error3;
                }
            }
            ?>
        </div>
    </div>
<!----------------footer-------------------------->
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
</body>

</html>