<?php
session_start();
/*echo '<pre>';
print_r($_POST);
echo '</pre>';*/
$user_id = $_GET['user_id'];
$data_entry_id = $_GET['data_entry_id'];

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

    $message ='';
    require_once 'Pdf.php';
    $pdf = new Pdf();

if (isset($_POST['btn_update_admin'])) {
        $message = $pdf->updateDataEntryFormAdmin($_POST);

    $_SESSION['message']=$message;
    header('Location: search.php');
}
    require_once 'Pdf.php';
    $pdf = new Pdf();
if (isset($_POST['updateMobileNoStatus'])) {
    /*echo '<pre>';
    print_r($_POST);
    echo '</pre>';*/
    $message = $pdf->updateMobileNoStatus();
    //header('Location: data_entry_form_update.php');
}
$personnel = $pdf->viewDataEntryFormUpdate($user_id,$data_entry_id);
$personnel_info = mysqli_fetch_assoc($personnel);

/*$sql = "SELECT upload_image FROM personnel_info WHERE id=$user_id";
$result = mysqli_query("$sql");
$row = mysqli_fetch_assoc($result);
mysqli_close($this);

header("Content-type: image/jpeg");*/


$nidSql= "SELECT nid_ser_no_children,name_as_nid_children,nid_no_children FROM nid_info_children WHERE user_id='$user_id'&&data_entry_id='$data_entry_id' ORDER BY id";
$nidInfo = $pdf->getDynamicTableData($nidSql);

$selfContactSql= "SELECT self_contact_ser_no,self_contact_mobile_no,self_contact_imei_no,self_contact_email_address FROM contact_details_self WHERE user_id='$user_id'&&data_entry_id='$data_entry_id' ORDER BY id";
$contactSelf = $pdf->getDynamicTableData($selfContactSql);

$spouseContactSql= "SELECT spouse_contact_ser_no,spouse_contact_mobile_no,spouse_contact_imei_no,spouse_contact_email_address FROM contact_details_spouse WHERE user_id='$user_id'&&data_entry_id='$data_entry_id' ORDER BY id";
$contactSpouse = $pdf->getDynamicTableData($spouseContactSql);

$childrenContactSql= "SELECT children_contact_ser_no,children_contact_mobile_no,children_contact_imei_no,children_contact_email_address FROM contact_details_children WHERE user_id='$user_id'&&data_entry_id='$data_entry_id' ORDER BY id";
$contactChildren = $pdf->getDynamicTableData($childrenContactSql);

$selfSocialMediaSql= "SELECT self_social_media_ser_no,self_social_media_email_address,self_social_media_platform,self_social_media_link,self_social_media_mobile_no FROM social_media_table_self WHERE user_id='$user_id'&&data_entry_id='$data_entry_id' ORDER BY id";
$socialMediaSelf = $pdf->getDynamicTableData($selfSocialMediaSql);

$spouseSocialMediaSql= "SELECT spouse_social_media_ser_no,spouse_social_media_email_address,spouse_social_media_platform,spouse_social_media_link,spouse_social_media_mobile_no FROM social_media_table_spouse WHERE user_id='$user_id'&&data_entry_id='$data_entry_id' ORDER BY id";
$socialMediaSpouse = $pdf->getDynamicTableData($spouseSocialMediaSql);

$childrenSocialMediaSql= "SELECT children_social_media_ser_no,children_social_media_email_address,children_social_media_platform,children_social_media_link,children_social_media_mobile_no FROM social_media_table_children WHERE user_id='$user_id'&&data_entry_id='$data_entry_id' ORDER BY id";
$socialMediaChildren = $pdf->getDynamicTableData($childrenSocialMediaSql);

$mobileSql= "SELECT * FROM per_mobile_num WHERE user_id='$user_id'&&data_entry_id='$data_entry_id' ORDER BY id";
$mobilenum = $pdf->getDynamicTableData($mobileSql);

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
<body>
<div class="container-fluid">
    <nav class="navbar navbar-default">
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
    <div class="col-md-10 col-md-offset-1">
        <div class="well">
            <h4 class="text-center text-info"><?php echo $message; ?></h4>
            <h3 class="text-center text-default"><b><u>PERSONAL INFORMATION</u></b></h3>
            <form class="form" method="POST" action="" enctype="multipart/form-data" data-toggle="validator"
                  role="form">
                <input type="hidden" name="id" value="<?php echo $personnel_info['id']; ?>">
                <div class=" row">
                    <div class=" form-group col-md-6">
                        <label>1. Name</label>
                        <input type="text" required   value="<?php echo $personnel_info['full_name']; ?>" class="form-control" id="full_name" name="full_name" placeholder="Enter your Full Name">
                    </div>
                    <div class="col-md-3">
                        <label>Upload Image</label>
                        <input type="file" name="upload_image"  placeholder="Upload Image">
                    </div>
                    <div class=" col-md-3">
                        <input type="hidden" required  name="uploaded_image" value="<?php echo $personnel_info['upload_image']; ?>">
                        <label> Image</label>
                        <img style='width:100px; height:80px' src='photo/<?php echo $personnel_info['upload_image']; ?>' class='rounded-circle'>
                    </div>
                </div>
                <div class=" row">
                    <div class=" form-group col-md-4">
                        <label>2. Rank</label>
                        <input  type="text" required   value="<?php echo $personnel_info['rank']; ?>"class="form-control" id="rank" name="rank" placeholder="Rank">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class=" form-group col-md-4">
                        <label>3. BD/No</label>
                        <input type="number" value="<?php echo $personnel_info['bd_no']; ?>" class="form-control" id="bd_no" name="bd_no" placeholder="BD/No">
                    </div>
                    <div class=" form-group col-md-4">
                        <label>4. Branch/Trade</label>
                        <input  type="text" required   value="<?php echo $personnel_info['br_trade']; ?>"class="form-control" id="br_trade" name="br_trade" placeholder="Branch/Trade">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class=" form-group col-md-4">
                        <label>5. Unit </label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z0-9-., ]{1,}$" type="text" required   value="<?php echo $personnel_info['unit']; ?>"class="form-control" id="unit" name="unit" placeholder="unit">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class=" form-group col-md-4">
                        <label>6. Date Of Birth</label>
                        <input  type="date" required   value="<?php echo $personnel_info['date_of_birth']; ?>" class="form-control" id="datepicker" name="date_of_birth" placeholder="Date_Of_Birth">
                    </div>
                    <div class="col-md-4">
                        <label>7. Passport No </label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z0-9-., ]{1,}$" type="text"  value="<?php echo $personnel_info['passport_no']; ?>" class="form-control" id="unit" name="passport_no" placeholder="Passport No">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label>9. Marital Status:<?php echo $personnel_info['mar_status']; ?> </label> </br>
                        <label class="radio-inline">
                            <input type="radio" name="mar_status" <?=$personnel_info['mar_status']=="Married" ? "checked" : ""?> value="Married"  >Married
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="mar_status" <?=$personnel_info['mar_status']=="Unmarried" ? "checked" : ""?> value="Unmarried" >Unmarried
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label>10. Number Of Child </label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_0-9-., ]{1,}$" type="text" value="<?php echo $personnel_info['child_male']; ?>" class="form-control"  name="child_male" placeholder="Male">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-2">
                        <label> <br> </label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_0-9-., ]{1,}$" type="text" value="<?php echo $personnel_info['child_female']; ?>" class="form-control"  name="child_female" placeholder="Female">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <?php $sl=1; if (mysqli_num_rows($mobilenum)>0 ) { ?>
                    <div  class="table-responsive">
                        <label>11.  Personal Mobile Number </label> </br>
                        <label>a. Existing Mobile Number </label>
                        <table class="table table-bordered" id="update_mobile_num" style="margin-bottom: 5px;">
                            <tr>
                                <th style="text-align: center; width:5%">Ser No</th>
                                <th style="text-align: center; width:25%">Mobile Number</th>
                                <th style="text-align: center; width:35%">Status</th>
                                <th style="text-align: center; width:20%">Action</th>

                            </tr>
                            <?php while ($mobile = mysqli_fetch_assoc($mobilenum))  { ?>
                                <tr>
                                    <td style="background-color: white; text-align: center"><?php echo $sl++; ?></td>
                                    <td style="background-color: white; text-align: center" ><?php echo $mobile['personal_mob_num']; ?>
                                    </td>
                                    <form action="" method="post">
                                        <td style="background-color: white;text-align: center">
                                            <input  type="hidden" name="mobile_no_id" class="id"  value="<?php echo $mobile['id']; ?>">
                                            <label class="form-check">
                                                <input disabled type="checkbox" class="present_status" name="present_status" <?=$mobile['present_status']=="used" ? "checked" : ""?> value="used">Used
                                            </label>
                                            <label class="form-check">
                                                <input type="checkbox" class="present_status" name="present_status" <?=$mobile['present_status']=="unused" ? "checked" : ""?> value="unused">Unused
                                            </label></td>
                                        <td style="background-color: white; text-align: center"><button type="submit" name="updateMobileNoStatus" class="btn btn-info btn-md">Update</button></td>
                                    </form>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                <?php } ?>
                <!--<div  class="table-responsive">
                    <label>b. Add New Mobile Number </label>
                    <table class="table table-bordered" id="new_mobile_num" style="margin-bottom: 5px">
                        <tr>
                            <th width="10%">Ser No</th>
                            <th width="35%">Mobile Number</th>
                            <th width="10%">Action</th>

                        </tr>
                        <tr>
                            <td style="background-color: white" contenteditable="true" class="ser_no_mobile">1</td>
                            <td style="background-color: white" contenteditable="true" class="personal_mob_num"></td>
                            <td style="background-color: white"><button type="button" name="addnumber" id="addnumber" class="btn btn-success btn-xs">Add</button></td>
                        </tr>
                    </table>
                </div>-->

                <div class=" row">
                    <div class="col-md-12">
                        <label>12.  National Id Information </label> </br>
                    </div>
                    <div class=" form-group col-md-6">
                        <label>a. Self  National Id Information </label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z. ]{1,}$"  type="text" required   value="<?php echo $personnel_info['self_nid_name']; ?>" class="form-control" id="per nid name" name="self_nid_name" placeholder="Name As NID">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-6">
                        <label> </label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_0-9-., ]{1,}$"  type="text"   value="<?php echo $personnel_info['self_nid_no']; ?>"class="form-control" id="per nid no" name="self_nid_no" placeholder="Nid No">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>b. Spouse  National Id Information </label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z. ]{1,}$"  type="text"  value="<?php echo $personnel_info['spouse_nid_name']; ?>"class="form-control" id="spouse nid name" name="spouse_nid_name" placeholder="Name As NID">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-6">
                        <label> </label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_0-9-., ]{1,}$"  type="text" value="<?php echo $personnel_info['spouse_nid_no']; ?>"class="form-control" id="spouse nid no" name="spouse_nid_no" placeholder="Nid No">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <?php $sl=1; if (mysqli_num_rows($nidInfo)>0 ) { ?>
                    <div  class="table-responsive">
                        <label>c. Children  National Id Information </label>
                        <table class="table table-bordered" id="nid_info_children" style="margin-bottom: 5px">
                            <tr>
                                <th style="text-align: center; width:10%">Ser No</th>
                                <th style="text-align: center; width:35%">Name As Nid</th>
                                <th style="text-align: center; width:30%">NID NO</th>

                            </tr>
                            <?php while ($nid = mysqli_fetch_assoc($nidInfo)) { ?>
                                <tr>
                                    <td style="background-color: white;text-align: center" ><?php echo $sl++; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['name_as_nid_children']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['nid_no_children']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                <?php } ?>
                </br>
                <?php $sl=1; if (mysqli_num_rows($contactSelf)>0 ) { ?>
                    <div  class="table-responsive">
                        <label>13.  Contact Details </label> </br>
                        <label>a.  Self Contact Details  </label>
                        <table class="table table-bordered" id="contact_details_self" style="margin-bottom: 5px">
                            <tr>
                                <th style="text-align: center; width:10%">Ser No</th>
                                <th style="text-align: center; width:20%">Mobile No</th>
                                <th style="text-align: center; width:20%">IMEI No</th>
                                <th style="text-align: center; width:30%">Email Address</th>
                            </tr>
                            <?php while ($nid = mysqli_fetch_assoc($contactSelf)) { ?>
                                <tr>
                                    <td style="background-color: white;text-align: center" ><?php echo $sl++; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['self_contact_mobile_no']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['self_contact_imei_no']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['self_contact_email_address']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>

                    </div>
                <?php } ?>
                <br>

                <?php $sl=1; if (mysqli_num_rows($contactSpouse)>0 ) { ?>
                    <div  class="table-responsive">
                        <label>b.  Spouse Contact Details  </label>
                        <table class="table table-bordered" id="contact_details_spouse" style="margin-bottom: 5px">
                            <tr>
                                <th style="text-align: center; width:10%">Ser No</th>
                                <th style="text-align: center; width:20%">Mobile No</th>
                                <th style="text-align: center; width:20%">IMEI No</th>
                                <th style="text-align: center; width:30%">Email Address</th>
                            </tr>
                            <?php while ($nid = mysqli_fetch_assoc($contactSpouse)) { ?>
                                <tr>
                                    <td style="background-color: white;text-align: center" ><?php echo $sl++; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['spouse_contact_mobile_no']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['spouse_contact_imei_no']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['spouse_contact_email_address']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>

                    </div>
                <?php } ?>
                <br>
                <?php $sl=1; if (mysqli_num_rows($contactChildren)>0 ) { ?>
                    <div  class="table-responsive">
                        <label>c.  Children Contact Details  </label>
                        <table class="table table-bordered" id="contact_details_children" style="margin-bottom: 5px">
                            <tr>
                                <th style="text-align: center; width:10%">Ser No</th>
                                <th style="text-align: center; width:20%">Mobile No</th>
                                <th style="text-align: center; width:20%">IMEI No</th>
                                <th style="text-align: center; width:30%">Email Address</th>
                            </tr>
                            <?php while ($nid = mysqli_fetch_assoc($contactChildren)) { ?>
                                <tr>
                                    <td style="background-color: white;text-align: center" ><?php echo $sl++; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['children_contact_mobile_no']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['children_contact_imei_no']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['children_contact_email_address']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>

                    </div>
                <?php } ?>
                </br>
                <?php $sl=1; if (mysqli_num_rows($socialMediaSelf)>0 ) { ?>
                    <div  class="table-responsive">
                        <label>14.  Social Media Information </label> </br>
                        <label>a.  Self Social Media Information </label>
                        <table class="table table-bordered" id="social_media_table_self" style="margin-bottom: 5px">
                            <tr>
                                <th style="text-align: center; width:10%">Ser No</th>
                                <th style="text-align: center; width:20%">Email Address</th>
                                <th style="text-align: center; width:20%">Social Media Platform</th>
                                <th style="text-align: center; width:20%">Link</th>
                                <th style="text-align: center; width:20%">Mobile No</th>
                            </tr>
                            <?php while ($nid = mysqli_fetch_assoc($socialMediaSelf)) { ?>
                                <tr>
                                    <td style="background-color: white;text-align: center" ><?php echo $sl++; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['self_social_media_email_address']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['self_social_media_platform']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['self_social_media_link']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['self_social_media_mobile_no']; ?></td>

                                </tr>
                            <?php } ?>
                        </table>

                    </div>
                <?php } ?>
                </br>
                <?php $sl=1; if (mysqli_num_rows($socialMediaSpouse)>0 ) { ?>
                    <div  class="table-responsive">
                        <label>b.  Spouse Social Media Information </label>
                        <table class="table table-bordered" id="social_media_table_spouse" style="margin-bottom: 5px">
                            <tr>
                                <th style="text-align: center; width:10%">Ser No</th>
                                <th style="text-align: center; width:20%">Email Address</th>
                                <th style="text-align: center; width:20%">Social Media Platform

                                </th>
                                <th style="text-align: center; width:20%">Link</th>
                                <th style="text-align: center; width:20%">Mobile No</th>
                            </tr>
                            <?php while ($nid = mysqli_fetch_assoc($socialMediaSpouse)) { ?>
                                <tr>
                                    <td style="background-color: white;text-align: center" ><?php echo $sl++; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['spouse_social_media_email_address']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['spouse_social_media_platform']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['spouse_social_media_link']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['spouse_social_media_mobile_no']; ?></td>

                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                <?php } ?>
                <br>
                <?php $sl=1; if (mysqli_num_rows($socialMediaChildren)>0 ) { ?>
                    <div  class="table-responsive">
                        <label>c.  Children Social Media Information </label>
                        <table class="table table-bordered" id="social_media_table_children" style="margin-bottom: 5px">
                            <tr>
                                <th style="text-align: center; width:10%">Ser No</th>
                                <th style="text-align: center; width:20%">Email Address</th>
                                <th style="text-align: center; width:20%">Social Media Platform</th>
                                <th style="text-align: center; width:20%">Link</th>
                                <th style="text-align: center; width:20%">Mobile No</th>
                            </tr>
                            <?php while ($nid = mysqli_fetch_assoc($socialMediaChildren)) { ?>
                                <tr>
                                    <td style="background-color: white;text-align: center" ><?php echo $sl++; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['children_social_media_email_address']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['children_social_media_platform']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['children_social_media_link']; ?></td>
                                    <td style="background-color: white;text-align: center" ><?php echo $nid['children_social_media_mobile_no']; ?></td>

                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                <?php } ?>
                <br>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label>15. Present address</label>
                        <textarea data-pattern-error="Special Character (&,$,# etc) not allowed"
                                  pattern="^[_A-z0-9-., ]{1,}$" type="text" required   class="form-control" id="present_address" name="present_address" placeholder="Present address"> <?php echo htmlspecialchars($personnel_info['present_address']); ?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label>15. Permanent Address</label>
                        <textarea data-pattern-error="Special Character (&,$,# etc) not allowed"
                                  pattern="^[_A-z0-9-., ]{1,}$" type="text" required    class="form-control" id="permanent_address" name="permanent_address" placeholder="Permanent Address"> <?php echo htmlspecialchars($personnel_info['permanent_address']); ?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label>16. Personal Vehicle Information </label> </br>
                    </div>
                    <div class="col-md-6">
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z0-9-., ]{1,}$" type="text"  value="<?php echo $personnel_info['vehicle_name']; ?>"class="form-control"  name="vehicle_name" placeholder="Vehicle Name">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-6">
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z0-9-., ]{1,}$" type="text"  value="<?php echo $personnel_info['reg_no']; ?>"class="form-control" name="reg_no" autocomplete="off" placeholder="Registration No">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label>17.  Bank Information </label> </br>
                    </div>
                    <div class="col-md-4">
                        <label>&nbsp;&nbsp;a. Self Bank Information </label> </br>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z0-9-., ]{1,}$" type="text" value="<?php echo $personnel_info['self_bank_name']; ?>" class="form-control" id="Bank Name" name="self_bank_name" placeholder="Bank Name">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-4">
                        <label> <br></label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z0-9-., ]{1,}$" type="text"  value="<?php echo $personnel_info['self_branch']; ?>" class="form-control" id="branch" name="self_branch" autocomplete="off" placeholder="Branch">
                    </div>
                    <div class="col-md-4">
                        <label><br></label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z0-9-., ]{1,}$" type="text"  value="<?php echo $personnel_info['self_bank_account_num']; ?>" class="form-control" id="Bank Account Number" name="self_bank_account_num" autocomplete="off" placeholder="Bank Account Number">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label>&nbsp;&nbsp;b. Spouse Bank Information </label> </br>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z0-9-., ]{1,}$" type="text"  value="<?php echo $personnel_info['spouse_bank_name']; ?>" class="form-control" id="Bank Name" name="spouse_bank_name" placeholder="Bank Name">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-4">
                        <label><br></label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z0-9-., ]{1,}$" type="text"  value="<?php echo $personnel_info['spouse_branch']; ?>" class="form-control" id="branch" name="spouse_branch" autocomplete="off" placeholder="Branch">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-4">
                        <label><br></label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z0-9-., ]{1,}$" type="text"  value="<?php echo $personnel_info['spouse_bank_account_num']; ?>" class="form-control" id="Bank Account Number" name="spouse_bank_account_num" autocomplete="off" placeholder="Bank Account Number">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label>&nbsp;&nbsp;c. Children Bank Information </label> </br>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z0-9-., ]{1,}$" type="text"  value="<?php echo $personnel_info['children_bank_name']; ?>" class="form-control" id="Bank Name" name="children_bank_name" placeholder="Bank Name">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-4">
                        <label><br></label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z0-9-., ]{1,}$" type="text"  value="<?php echo $personnel_info['children_branch']; ?>" class="form-control" id="branch" name="children_branch" autocomplete="off" placeholder="Branch">
                    </div>
                    <div class="col-md-4">
                        <label><br></label>
                        <input data-pattern-error="Special Character (&,$,# etc) not allowed"
                               pattern="^[_A-z0-9-., ]{1,}$" type="text"   value="<?php echo $personnel_info['children_bank_account_num']; ?>"class="form-control" id="Bank Account Number" name="children_bank_account_num" autocomplete="off" placeholder="Bank Account Number">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-offset-5 col-md-7">
                        <button type="submit" class="btn btn-success" id="save" name="btn_update_admin">Update Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<script src="js/validator.js"></script>
</body>
</html>

<script>
    /*$(document).ready(function() {
        var count = 1;
        $('#addnumber').click(function(){
            count = count + 1;
            var html_code = "<tr id='row"+count+"'>";
            html_code += "<td contenteditable='true' class='ser_no_mobile'></td>";
            html_code += "<td contenteditable='true' class='personal_mob_num'></td>";
            html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#new_mobile_num').append(html_code);
        });
        $(document).on('click', '.remove', function(){
            var delete_row = $(this).data("row");
            $('#' + delete_row).remove();
        });
        $('#save').click(function() {
            var ser_no_mobile = [];
            var personal_mob_num = [];
            $('.ser_no_mobile').each(function () {
                ser_no_mobile.push($(this).text());
            });

            $('.personal_mob_num').each(function () {
                personal_mob_num.push($(this).text());
            });

            $.ajax({
                url: "insertmobilenumber.php",
                method: "POST",
                data: {
                    ser_no_mobile: ser_no_mobile,
                    personal_mob_num: personal_mob_num,
                },
                success: function (data) {
                    //alert(data);
                    $("td[contentEditable='true']").text("");
                    for (var i = 2; i <= count; i++) {
                        $('tr#' + i + '').remove();
                    }
                    //fetch_item_data();
                }
            });

            /*var present_status = [];
            var id = [];
            var mobile_no = [];

            $('.present_status').each(function () {
                present_status.push($(this).val());
            });
            $('.id').each(function () {
                id.push($(this).val());
            });
            $('.mobile_no').each(function () {
                mobile_no.push($(this).val());
            });

            $.ajax({
                url: "updateMobileNumber.php",
                method: "POST",
                data: {present_status: present_status, id: id, mobile_no: mobile_no},

                success: function (data) {
                    //alert(data);
                    $('.present_status').val();
                    for (var i = 2; i <= count; i++) {
                        $('tr#' + i + '').remove();
                    }
                    //fetch_item_data();
                }
            });*/



        });
    });
</script>