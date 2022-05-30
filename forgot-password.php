<?php
// error_reporting(0);
include("header.php");
include('./DB/config.php');
session_start();


    //if user click continue button in forgot password form
    if(isset($_POST['sendMail'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $check_email = "SELECT * FROM patreg WHERE email='$email'";
        $run_sql = mysqli_query($con, $check_email);
        if(mysqli_num_rows($run_sql) > 0){
            $code = rand(999999, 111111);
            $insert_code = "UPDATE patreg SET code = $code WHERE email = '$email'";
            $run_query =  mysqli_query($con, $insert_code);
            if($run_query){
                header('location: smtp/index.php?Token='.$code.'&ID='.$email.'');
            }else{
                echo "<div style='color:white;'>Something went wrong!</div>";
            }
        }else{

            echo "<div style='color:white;'>Something went wrong!</div>";
        }
    }

    if(isset($_POST['changepass'])){

        $newPass = $_POST['confirmPassword'];
        $newPass = md5($newPass);

        $email = $_POST['email'];
        $Token = $_POST['Token'];
        
        $check_email = "SELECT * FROM patreg WHERE email='$email' AND code='$Token'";
        $run_sql = mysqli_query($con, $check_email);
        if(mysqli_num_rows($run_sql) > 0){
            $update_code = "UPDATE patreg SET cpassword ='$newPass' WHERE code='$Token'";
            $update_code2 = "UPDATE patreg SET pass ='$newPass' WHERE code='$Token'";
            $run_query =  mysqli_query($con, $update_code);
            $run_query2 =  mysqli_query($con, $update_code2);
            if($run_query){
                header('location: index1.php');
            }else{
                echo "<div style='color:white;'>Something went wrong !</div>";
            }
        }
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
        integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="style2.css">

    <title>Medscribe</title>
  <link rel = "icon" href="./images/Pic1.png" type = "image/png">

</head>
<style type="text/css">
    #inputbtn:hover {
        cursor: pointer;
    }

    .card {
        background: #f8f9fa;
        border-top-left-radius: 5% 5%;
        border-bottom-left-radius: 5% 5%;
        border-top-right-radius: 5% 5%;
        border-bottom-right-radius: 5% 5%;
    }
</style>

<body style="background: -webkit-linear-gradient(left, #3931af, #00c6ff); background-size: cover;">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">

            <a class="navbar-brand js-scroll-trigger" href="index.php"
                style="margin-top: 10px;margin-left:-65px;font-family: 'IBM Plex Sans', sans-serif;">
                <h4>
                    <img src="./images/Pic1.png" style="width:30px; height:30px;" alt="Logo">
                    &nbsp Medscribe
                </h4>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item" style="margin-right: 40px;">
                        <a class="nav-link js-scroll-trigger" href="index.php"
                            style="color: white;font-family: 'IBM Plex Sans', sans-serif;">
                            <h6>HOME</h6>
                        </a>
                    </li>

                    <li class="nav-item" style="margin-right: 40px;">
                        <a class="nav-link js-scroll-trigger" href="services.html"
                            style="color: white;font-family: 'IBM Plex Sans', sans-serif;">
                            <h6>ABOUT US</h6>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="contact.html"
                            style="color: white;font-family: 'IBM Plex Sans', sans-serif;">
                            <h6>CONTACT</h6>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <div class="container-fluid" style="margin-top:60px;margin-bottom:60px;color:#34495E;">
        <div class="row">



            <div class="col-md-7" style="padding-left: 180px; ">
                <div style="-webkit-animation: mover 2s infinite alternate; animation: mover 1s infinite alternate;">
                    <img src="images/ambulance1.png" alt=""
                        style="width: 20%;padding-left: 40px;margin-top: 150px;margin-left: 45px;margin-bottom:15px">
                </div>

                <div style="color: white;">
                    <h4 style="font-family: 'IBM Plex Sans', sans-serif;"> We are here for you!</h4>
                </div>

            </div>

            <div class="col-md-4" style="margin-top: 5%;right: 8%">
                <div class="card" style="font-family: 'IBM Plex Sans', sans-serif;">
                    <div class="card-body">
                        <center>
                            <i class="fa fa-hospital-o fa-3x" aria-hidden="true" style="color:#0062cc"></i>
                            <br>
                            <h3 style="margin-top: 10%">Password Reset</h3><br>

                            <!-- send mail -->
                            <?php
                            if(!isset($_GET['password-reset'])){
                               
                            ?>
                            <form class="form-group" method="POST" action="forgot-password.php">
                                <div class="row" style="margin-top: 5%">
                                    <div class="col-md-9">
                                        <input type="email" name="email" id="email" class="form-control"
                                            placeholder="Registered Email " required />
                                    </div>
                                    <button type="submit" class="btn btn-success" name="sendMail" id="sendMail">Send</button>
                                </div>
                            </form>
                            <?php
                             
                            }
                            ?>

                            <!-- reset -->
                            <?php
                            if(isset($_GET['password-reset'])){
                               
                                $email = $_GET['ID'];
                                $Token = $_GET['Token'];
                            ?>
                            <form class="form-group" method="POST" action="forgot-password.php">
                                <input type="hidden" name="Token" id="Token" value="<?php echo $Token ?>">
                                <input type="hidden" name="email" id="email" value="<?php echo $email ?>">
                                <div class="row" style="margin-top: 5%">
                                    <div class="col-md-12 ">
                                        <input type="text" name="password" id="password" class="form-control" placeholder="New Password"
                                            required />
                                    </div>
                                    <div class="col-md-12" style="margin-top: 2%">
                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" required />
                                    </div>

                                </div>

                                <div class="mt-3">
                                    <button type="submit" name="changepass" id="changepass" class="btn btn-success">Change Password</button>
                                </div>

                            </form>
                            <?php
                             
                            }
                            ?>

                            <!-- go back to login -->
                            <div class="row">

                                <div class="col-md-6" style="margin-top: 5%">
                                    <a href="index1.php" class="btn btn-primary float-left">Back</a></div>

                            </div>
                        </center>
                    </div>
                </div>
            </div>


        </div>
    </div>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
        integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous">
    </script>
</body>

</html>