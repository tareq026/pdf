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
/*echo '<pre>';
print_r($_SESSION);
echo '</pre>';*/

if(isset($_GET['status'])){
    if ($_GET['status']=='logout'){
        require_once('Login.php');
        $logout = new Login();
        $message=$logout->adminLogout();
        $_SESSION['message']= $message;
    }
}
include("connection.php");
$sql = "SELECT * FROM personnel_info ORDER By bd_no";
$result = mysqli_query($connect,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Result</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dataTables.min.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="js/dataTables.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="btn btn-success navbar-btn" href="search.php">Homepage</a>
                <a class="btn btn-success navbar-btn" href="pass_request_list.php">View Password Request</a>
                <a class="btn btn-success navbar-btn" href="data_entry_admin.php">Data Entry Form</a>
                <a class="btn btn-success navbar-btn" href="new_user.php">User</a>
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
        </div>
</div>
</nav>
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <table class="table-bordered" style="margin-top: 5%;">
            <thead>
            <tr>
                <th>Ser No</th>
                <th>Bd NO</th>
                <th>Rank</th>
                <th>Name</th>
                <th>Trade</th>
                <th>Mobile No</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            </thead>
            <?php $sl=1; while($row = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td><?php echo $sl++; ?></td>
                    <td><?php echo $row->bd_no ?></td>
                    <td><?php echo $row->rank ?></td>
                    <td><?php echo $row->full_name ?></td>
                    <td><?php echo $row->br_trade ?></td>
                    <td>
                        <?php
                        $mobile_numbers='';
                        $sql = "SELECT * FROM per_mobile_num WHERE user_id='$row->user_id'";
                        $result1 = mysqli_query($connect,$sql);
                        while($mob = mysqli_fetch_object($result1)) {
                            $mobile_numbers .= $mob->personal_mob_num."<br>";
                        }
                        echo $mobile_numbers;
                        ?>
                    </td>
                    <td><img style='width:50px; height:50px' src='photo/<?php echo $row->upload_image ?>' class='rounded-circle'></td>
                    <td>
                        <a href="generate_form_pdf.php?data_entry_id=<?php echo $row->data_entry_id ?>&&user_id=<?php echo $row->user_id ?>" class='btn btn-primary'>View Data</a>
                        <a href="data_entry_update_admin.php?data_entry_id=<?php echo $row->data_entry_id ?>&&user_id=<?php echo $row->user_id ?>" class='btn btn-primary'>Update</a>
                    </td>

                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<script type="text/javascript" >
    $(document).ready(function() {
        $('table').DataTable();
    } );
</script>
</body>