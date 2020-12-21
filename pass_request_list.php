<style>

    .button2
    {
        float: none;
        display: block;
        text-align: right;
        margin: 5px;
        color: white;
        background-color: #4cae4c;
    }
</style>
<?php
session_start();
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
if (isset($_POST['btn_reset_password'])) {
    require_once('Login.php');
    $data = new Login();
    $message .= $data->resetUserPassword($_POST);
    header('Location: pass_request_list.php');
}
require_once('Pdf.php');
$Pdf = new Pdf();
$viewPasswordRequest = $Pdf->viewPasswordResetRequestList();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset Request</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</head>
<body>
<div class="container-fluid">
    <nav class="navbar navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="btn btn-success navbar-btn" href="search.php">Homepage</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="text-transform: uppercase;"><?php echo "Welcome ".$_SESSION['user_name'];?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="?status=logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
<div class="row">
    <?php if (mysqli_num_rows($viewPasswordRequest)>0) {?>
        <div class="well">
            <h3 class="text-center text-primary">Password Reset Requests</h3>
            <table class="table table-hover table-striped table-bordered">
                <tr>
                    <th class="text-center">Ser No</th>
                    <th class="text-center">BD No</th>
                    <th class="text-center">Rank</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Br/Trade</th>
                    <th class="text-center">Action</th>
                </tr>
                <?php $serial_number = 1;
                while ($viewPasswordRequestList = mysqli_fetch_assoc($viewPasswordRequest)) { ?>
                    <tr>
                        <td class="text-center"><?php echo $serial_number++; ?></td>
                        <td class="text-center"><?php echo $viewPasswordRequestList['bd_no']; ?></td>
                        <td class="text-center"><?php echo $viewPasswordRequestList['rank']; ?></td>
                        <td class="text-center"><?php echo $viewPasswordRequestList['user_name']; ?></td>
                        <td class="text-center"><?php echo $viewPasswordRequestList['trade']; ?></td>
                        <form action="" method="post">
                            <td class="text-center">
                                <input type="hidden" value="<?php echo $viewPasswordRequestList['user_id']; ?>" name="user_id">
                                <input type="hidden" value="<?php echo $viewPasswordRequestList['bd_no']; ?>" name="bd_no">
                                <button class='btn btn-danger' type='submit' name='btn_reset_password'> Reset Password </button>
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php } ?>
</div>

</body>
