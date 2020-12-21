<?php
    session_start();
    /*if (isset($_SESSION['id'])){
        header('location:homepage.php');
    }*/
    $message='';
    if (isset($_POST['btn_register'])){
        require_once('Login.php');
        $register = new Login();
        $message=$register->userRegistration($_POST);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Registration</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container" style="margin-top: 60px">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="well" style="background-color: #b3d7ff">
                  <h3 class="text-center text-success">New User Registration</h3>
                  <hr/>
                    <h4 class="text-center text-danger"><?php echo $message;?></h4>
                  <form class="form-horizontal" method="POST" action="" data-toggle="validator">
                    <div class="row">
                      <label class="col-md-4 control-label">Enter Your Full Name</label>
                      <div class="col-md-8 form-group has-feedback">
                        <input type="text" pattern="[A-z_ ]{1,}$" data-pattern-error="No special character & number is allowed!" class="form-control" placeholder="Full Name" name="user_name" required>
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <div class="row">
                      <label class="col-md-4 control-label">Svc No</label>
                      <div class="col-md-8 form-group has-feedback">
                        <input type="text" pattern="[A-z0-9_ ]{1,}$" data-pattern-error="No special character is allowed!" class="form-control" placeholder="Svc No" name="bd_no" required>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <div class="row">
                      <label class="col-md-4 control-label">Password</label>
                      <div class="col-md-8 form-group has-feedback">
                        <input type="password" id="password" data-minlength="6" data-error="Password minimum 6 character !" class="form-control" placeholder="Password" name="user_password" minlength="6" required>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-md-4 control-label">Confirm Password</label>
                      <div class="col-md-8 form-group has-feedback">
                        <input type="password" data-match="#password" data-error="Password and Confirm password does not match !" class="form-control" placeholder="Password" name="cf_user_password" minlength="6" required>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-offset-4 col-md-8">
                        <button type="submit" class="btn btn-success btn-block" name="btn_register">Register</button>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>



    <script src="js/jquery-1.12.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/validator.js"></script>
</body>
</html>