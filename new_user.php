<?php
session_start();
//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';
$user_id=$_SESSION['id'];
if (!isset($_SESSION['id'])){
    header('location : index.php');
}
if(isset($_GET['status'])){
    if ($_GET['status']=='logout'){
        require_once('Login.php');
        $logout = new Login();
        $message=$logout->adminLogout();
        $_SESSION['message']= $message;
    }
}

if (isset($_POST['btn_update_user_info'])){
    include("connection.php");
    require_once ('Pdf.php');
    $pdf = new Pdf();
    $message = $pdf->updateUserData();
    $_SESSION['message']=$message;
    header('Location: new_user.php');
}

if (isset($_POST['btn_insert_new_user'])){
    include("connection.php");
    require_once ('Pdf.php');
    $pdf = new Pdf();
    $message = $pdf->insertUserData();
    header('Location: new_user.php');
    $_SESSION['message']=$message;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Entry Form form</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</head>
<div class="container-fluid">
    <nav class="navbar navbar-default" >
        <div class="container" >
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="btn btn-success navbar-btn" href="search.php">Homepage</a>
            </div>
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
</div><!-- /.container-fluid -->
</nav>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h4 class="text-center text-success bg-info">
            <?php if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
            };
            unset($_SESSION['message']);
            ?>
        </h4>
        <div class="panel panel-default">
            <div class="panel-heading">Create/ Update Personnel Data</div>
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#1" data-toggle="tab">Update User Data</a>
                    </li>
                    <li><a href="#2" data-toggle="tab">Create User</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="1">
                        <h3 class="text-center text-primary">Update User Data</h3>
                        <div class="col-md-6 col-md-offset-3">
                            <form class="navbar-form navbar-left" method="POST" action="">
                                <div class="form-group">
                                    <input type="text" name="bd_no" class="form-control" placeholder="Enter Svc No">
                                </div>
                                <button type="submit" class="btn btn-default" name="btnSearch">Search</button>
                            </form>
                        </div>
                        <div class="col-md-12">

                            <?php
                            if (isset($_POST['btnSearch'])) {
                                require_once ('Pdf.php');
                                include_once 'connection.php';
                                $pdf = new Pdf();
                                $user = $pdf->selectIndividualUsers();

                                if (mysqli_num_rows($user) > 0) {
                                    $userInfo = mysqli_fetch_assoc($user);
                                    ?>
                                    <form class="form" method="POST" action="" data-toggle="validator" role="form">
                                        <div class="form-group row has-feedback">
                                            <label>1. Full Name</label>
                                            <input name="user_name" value="<?php echo $userInfo['user_name'] ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                                   data-pattern-error="Special Character (&,$,# etc) not allowed"
                                                   class="form-control"
                                                   placeholder="Full Name">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group row has-feedback">
                                            <label>2. Rank</label>
                                            <input name="rank" value="<?php echo $userInfo['rank'] ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                                   data-pattern-error="Special Character (&,$,# etc) not allowed"
                                                   class="form-control"
                                                   placeholder="Rank">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group row has-feedback">
                                            <label>3. Svc No</label>
                                            <input  value="<?php echo $userInfo['bd_no'] ?>" pattern="^[0-9 ]{1,}$"
                                                   data-pattern-error="Special Character (&,$,# etc) not allowed"
                                                   class="form-control"
                                                   placeholder="BD No" disabled>
                                            <input type="hidden" name="bd_no" value="<?php echo $userInfo['bd_no']; ?>">
                                        </div>

                                        <div class="form-group row has-feedback">
                                            <label>4. Branch/ Trade</label>
                                            <input name="trade" value="<?php echo $userInfo['trade'] ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                                   data-pattern-error="Special Character (&,$,# etc) not allowed"
                                                   class="form-control"
                                                   placeholder="Branch/ Trade">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group row">
                                            <label>5. Date of Birth</label>
                                            <input type="date" value="<?php echo $userInfo['date_of_birth'] ?>" class="form-control" name="date_of_birth">
                                        </div>

                                        <div class="form-group row has-feedback">
                                            <label>6. Present Password</label>
                                            <input name="user_password" value="<?php echo $userInfo['user_password'] ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                                   data-pattern-error="Special Character (&,$,# etc) not allowed"
                                                   class="form-control"
                                                   placeholder="Enter New PAssword">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <button style="margin-left: 280px" type="submit" class="btn btn-success"
                                                name="btn_update_user_info">Update User Info
                                        </button>
                                    </form>
                                <?php } else { ?>
                                    <h3 class="text-center text-primary">No User found with the svc no!</h3>
                                <?php }}?>
                        </div>
                    </div>
                    <div class="tab-pane" id="2">
                        <h3 class="text-center text-primary">Create New User</h3>
                        <div class="col-md-12">
                            <form class="form2" method="POST" action="" data-toggle="validator" role="form">
                                <div class="form-group row has-feedback">
                                    <label>1. Full Name</label>
                                    <input name="user_name" pattern="^[_A-z0-9-., ]{1,}$"
                                           data-pattern-error="Special Character (&,$,# etc) not allowed"
                                           class="form-control"
                                           placeholder="Full Name">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group row has-feedback">
                                    <label>2. Rank</label>
                                    <input name="rank" pattern="^[_A-z0-9-., ]{1,}$"
                                           data-pattern-error="Special Character (&,$,# etc) not allowed"
                                           class="form-control"
                                           placeholder="Rank">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group row has-feedback">
                                    <label>3. BD/No</label>
                                    <input name="bd_no" pattern="^[0-9 ]{1,}$"
                                           data-pattern-error="Special Character (&,$,# etc) not allowed"
                                           class="form-control"
                                           placeholder="BD No">
                                </div>

                                <div class="form-group row has-feedback">
                                    <label>4. Branch/Trade</label>
                                    <input name="trade" pattern="^[_A-z0-9-., ]{1,}$"
                                           data-pattern-error="Special Character (&,$,# etc) not allowed"
                                           class="form-control"
                                           placeholder="Branch/ Trade">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group row">
                                    <label>5. Date of Birth</label>
                                    <input type="date" class="form-control" name="date_of_birth">
                                </div>

                                <button style="margin-left: 280px" type="submit" class="btn btn-success"
                                        name="btn_insert_new_user">Create new User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="js/validator.js"></script>
</body>
</html>
