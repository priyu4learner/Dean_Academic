<?php require 'connection.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dean Academics MNNIT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="image/MNNIT.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    
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
                        data-bs-target="#profLogin">Professor
                        Login</button></div>
                <div class="col-4 item" style="border-left: white solid;"><button type="button" class="btn "
                        data-bs-toggle="modal" data-bs-target="#studLogin">Student
                        Login</button></div>
                <div class="col-4 item" style="border-left: white solid;"><button type="button" class="btn"
                        data-bs-toggle="modal" data-bs-target="#adminLogin">Admin
                        Login</button></div>
            </div>
            <!---------Modals---------->
            <!-----modal for professor-------->
            <div class="modal fade" id="profLogin" tabindex="-1" aria-labelledby="profLoginLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="profLoginLabel">Professor Login</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            <form method="post" action="proflogin.php">
                                <label for="emplid" class="col-12 col-form-label">Employee Number</label>
                                <div class="col-12">
                                    <input type="text" id="emplid" name="emplid">
                                </div>
                                <label for="inputPassword" class="col-12 col-form-label">Password</label>
                                <div class="col-12">
                                    <input type="password" class="form-control" id="inputPassword" name="inputPassword">
                                </div>
                                <div class="modal-footer" style="align-items: center;">
                                <input type="submit" name="submit" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!------modal for student---------->
            <div class="modal fade" id="studLogin" tabindex="-1" aria-labelledby="studLoginLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="studLoginLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            <form method="post" action="studentlogin.php">
                                <label for="regno" class="col-12 col-form-label">Registration Number</label>
                                <div class="col-12">
                                    <input type="text" id="regno" name="regno">
                                </div>
                                <label for="inputPassword" class="col-12 col-form-label">Password</label>
                                <div class="col-12">
                                    <input type="password" class="form-control" id="inputPassword" name="inputPassword">
                                </div>
                                <div class="modal-footer" style="align-items: center;">
                                <input type="submit" name="submit" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!------modal for admin------------>
            <div class="modal fade" id="adminLogin" tabindex="-1" aria-labelledby="adminLoginLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="adminLoginLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            <form method="post" action="adminlogin.php">
                                <label for="emplid" class="col-12 col-form-label">Employee Number</label>
                                <div class="col-12">
                                    <input type="text" id="emplid" name="emplid" required>
                                </div>
                                <label for="inputPassword" class="col-12 col-form-label">Password</label>
                                <div class="col-12">
                                    <input type="password" class="form-control" id="inputPassword" name="inputPassword" required>
                                </div>
                                <div class="modal-footer" style="align-items: center;">
                                    <input type="submit" name="submit" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    
    <!---------------sub-header------------->
    <div class="subheader">
        <img src="image/background.png" alt="" class="img-fluid">
    </div>
    <!-------------------Content-------------->
    <div class="container content">
        <h3>ABOUT MNNIT</h3>
        <hr style="width: 6vw;margin-left: 0vw;border: 2px solid;;margin-top: 1vw;">
        <div class="container">
            <p>
                Motilal Nehru National Institute Of Technology, Allahabad was formerly Motilal Nehru Regional
                Engineering College, Allahabad . It is an institute with total commitment to quality and
                excellence in
                academic pursuits, is among one of the leading institutes in INDIA and was established in year
                1961 as a
                joint enterprise of Govt. of India and Govt. of U.P. in accordance with the scheme of
                establishment of
                REC. However with effect from June 26th of 2002 the college became deemed university and is now
                known as
                Motilal Nehru National Institute of technology.</p>
            <p>
                The foundation stone of the college was laid by the first Prime Minister of India, Pt. Jawahar
                Lal Nehru
                on the 3rd of may, 1961 on a site spreading over 222 acres on the banks of the river Ganga. The
                main
                building of college was inaugurated by another illustrious son of India, Prime Minister Sri Lal
                Bahadur
                Shastri on 18th of April, 1965.</p>
            <p>
                The students are extensively exposed to cross-cultural environment as candidates from various
                other
                countries such as Sri Lanka, Nepal, Bangladesh, Bhutan, Mauritius, Malaysia, Iran, Yemen, Iraq,
                Palestine and Thailand also join MNNIT for various undergraduate and post-graduate programs.</p>
            <p>
                MNNIT is fully residential institution with eight hostels for boys and two for girls.
            </p>
            <hr>
            <p>
                <font size="4px"><strong>Note:</strong> For help in any regard, the office of Dean (Academics)
                    can be
                    reached on e-mail: <a href="mailto:academics@mnnit.ac.in">academics@mnnit.ac.in</a><br>In
                    case of
                    any grievance, please contact <a href="mailto:deanacademic@mnnit.ac.in">deanacademic@mnnit.ac.in</a>
                </font>
            </p>
        </div>
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
</body>

</html>