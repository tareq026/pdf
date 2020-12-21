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
} else {
    include("connection.php");
    $sql = "SELECT * FROM personnel_info WHERE user_id='$_SESSION[id]'";
    $result = mysqli_query($connect,$sql);
}

if(isset($_GET['status'])){
    if ($_GET['status']=='logout'){
        require_once('Login.php');
        $logout = new Login();
        $message=$logout->adminLogout();
        $_SESSION['message']= $message;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Result</title>
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
</div><!-- /.container-fluid -->
</nav>
<div class="row">
    <div class="col-md-8 col-md-offset-2" style="margin-top: 5%;">
        <div class="row">
            <?php
            ?>

        </div>
        <table class="table table-bordered">
            <tr>
                <th>Bd NO</th>
                <th>Rank</th>
                <th>Name</th>
                <th>Trade</th>
                <th>Mobile NO</th>
                <th>Action</th>
            </tr>
            <?php while($row = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td><?php echo $row->bd_no ?></td>
                    <td><?php echo $row->rank ?></td>
                    <td><?php echo $row->full_name ?></td>
                    <td><?php echo $row->br_trade ?></td>
                    <td>
                    <?php
                    $mobile_numbers='';
                    $sql = "SELECT * FROM per_mobile_num WHERE user_id='$row->user_id'";
                    $result = mysqli_query($connect,$sql);
                    while($mob = mysqli_fetch_object($result)) {
                        $mobile_numbers .= $mob->personal_mob_num."<br>";
                    }
                     echo $mobile_numbers;
                    ?>
                    </td>
                    <td>
                        <a href="generate_form_pdf.php?data_entry_id=<?php echo $row->data_entry_id ?>&&user_id=<?php echo $row->user_id ?>" class='btn btn-primary'>View Data</a>
                        <a href="data_entry_form_update.php?data_entry_id=<?php echo $row->data_entry_id ?>&&user_id=<?php echo $row->user_id ?>" class='btn btn-primary'>Update</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
</body>
