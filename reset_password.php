<?php
    session_start();
    $message='';
if (!isset($_SESSION['id'])) {
    header('location: index.php');
}

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'logout') {
        require_once('Login.php');
        $logout = new Login();
        $message = $logout->adminLogout();
        $_SESSION['message'] = $message;
    }
}
    if (isset($_POST['btn_reset_password'])){
        require_once('Login.php');
        $register = new Login();
        $message=$register->userResetPassword($_POST);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <nav class="navbar navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="text-transform: uppercase;"><?php echo "Welcome ".$_SESSION['user_name'];?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="?status=logout">Logout</a></li>
                        <li><a href="reset_password.php">change password</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
</div>
    <div class="container" style="margin-top: 60px">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="well" style="background-color: #b3d7ff">
                  <h3 class="text-center text-success">Change your Password!</h3>
                  <hr/>
                    <h4 class="text-center text-danger"><?php echo $message;?></h4>
                  <form class="form-horizontal" method="POST" action="" data-toggle="validator">
                    <div class="row">
                      <label class="col-md-4 control-label">Svc No</label>
                      <div class="col-md-8 form-group has-feedback">
                        <input type="text" pattern="[A-z0-9_ ]{1,}$" data-pattern-error="No special character is allowed!" class="form-control" placeholder="Svc No" name="bd_no" value="<?php echo $_SESSION['bd_no']; ?>" disabled>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-md-4 control-label">New Password</label>
                      <div class="col-md-8 form-group has-feedback">
                        <input type="password" id="password" data-minlength="6" data-error="Password minimum 6 character !" class="form-control" placeholder="Password" name="user_password" required>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-md-4 control-label">Confirm New Password</label>
                      <div class="col-md-8 form-group has-feedback">
                        <input type="password" data-match="#password" data-error="Password and Confirm password does not match !" class="form-control" placeholder="Confirm Password" name="cf_user_password" required>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-offset-4 col-md-8">
                        <button type="submit" class="btn btn-success btn-block" name="btn_reset_password">Change Your Password</button>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
    <script src="js/validator.js"></script>
</body>
</html>