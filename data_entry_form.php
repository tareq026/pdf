<?php
      session_start();
/*echo '<pre>';
print_r($_SESSION);
echo '</pre>';*/

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

    $message ='';
    if(isset($_POST['btn_submit'])){
        //Data entry id increase code
        include("connection.php");
        $sql = "SELECT data_entry_id FROM personnel_info WHERE user_id='$user_id' ORDER BY data_entry_id DESC LIMIT 1" or die("database error:". mysqli_error($connString));
        if(mysqli_query($connect, $sql))
        {
            $dataId = mysqli_query($connect, $sql);
            $dataId = mysqli_fetch_assoc($dataId);
            $dataId = $dataId['data_entry_id'];
            $_SESSION['data_entry_id']= ++$dataId;
        }
        else
        {
            $_SESSION['data_entry_id']= 1;
        }

        require_once ('Pdf.php');
        $data = new Pdf();
        $message = $data->savePersonnelInfo();
        header("Location: view_data_entry_form.php");
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
<body>
  <div class="container-fluid">
      <nav class="navbar navbar-default" >
          <div class="container" >
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                  <a class="btn btn-success navbar-btn" href="view_data_entry_form.php">Homepage</a>
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
        <div class="well" >
          <h4 class="text-center text-info"><?php echo $message; ?></h4>
          <h3 class="text-center text-default"><b><u>PERSONAL INFORMATION</u></b></h3>
       <form class="form" id="dataEntryForm"  method="POST" action="" enctype="multipart/form-data" data-toggle="validator" role="form">
              <div class="form-group row">
                  <div class="col-md-12">
                      <label>1. Name</label>
                      <input  value="<?php echo $_SESSION['user_name'] ?>"  type="text" required class="form-control" id="full_name" name="full_name" placeholder="Enter your Full Name" >
                      <div class="help-block with-errors"></div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-4">
                      <label>2. Rank</label>
                      <input   value="<?php echo $_SESSION['rank'] ?>"  type="text" required class="form-control" id="rank" name="rank" placeholder="Rank" >
                      <h6>Update Rank if neccessary.</h6>
                      <div class="help-block with-errors"></div>
                  </div>
                  <div class="col-md-4">
                      <label>3. BD/No</label>
                      <input   value="<?php echo $_SESSION['bd_no'] ?>"   type="number" required class="form-control" id="bd_no" name="bd_no" placeholder="BD/No" >
                  </div>
				  <div class="col-md-4">
                      <label>4. Branch/Trade</label>
                      <input    value="<?php echo $_SESSION['trade'] ?>"  type="text" required class="form-control" id="br_trade" name="br_trade" placeholder="Branch/Trade" >
                      <div class="help-block with-errors"></div>
                  </div>
              </div>

              <div class="row">
                  <div class="form-group col-md-4">
                      <label >5. Unit </label>
                      <input pattern="^[_A-z0-9-., ]{1,}$"
                             data-pattern-error="Special Character (&,$,# etc) not allowed"  type="text" required class="form-control" id="unit" name="unit" placeholder="unit">
                      <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group col-md-4">
                      <label>6. Date Of Birth</label>
                      <input value="<?php echo $_SESSION['date_of_birth'] ?>" type="date" required class="form-control" id="datepicker" name="date_of_birth" placeholder="Date_Of_Birth" >
                      <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group col-md-4">
                      <label>7. Passport No </label>
                      <input pattern="^[_A-z0-9-., ]{1,}$"
                             data-pattern-error="Special Character (&,$,# etc) not allowed"  type="text"  class="form-control" id="unit" name="passport_no" placeholder="Passport No">
                      <div class="help-block with-errors"></div>
                  </div>
              </div>
           <div class="form-group row">
                      <div class="col-md-4">
                          <label>8. Marital Status: </label> </br>
                      <label class="radio-inline">
                          <input type="radio"  name="mar_status" value="Married">Married
                      </label>
                      <label class="radio-inline">
                          <input type="radio" name="mar_status" value="Unmarried">Unmarried
                      </label>
                      </div>
                      <div class="col-md-3">
                          <label>09. Number Of Child </label><br>
                          <label>a.Male </label>
                          <input data-pattern-error="Special Character not allowed ! "
                                 pattern="^[_0-9-., ]{1,}$" type="text"  class="form-control"  name="child_male" placeholder="Male">
                          <div class="help-block with-errors"></div>
                      </div>
                      <div class="col-md-3"><br>
                          <label> b.Female </label><br>
                          <input data-pattern-error="Special Character not allowed ! "
                                 pattern="^[_0-9-., ]{1,}$" type="text" class="form-control"  name="child_female" placeholder="Female">
                          <div class="help-block with-errors"></div>
                      </div>
                  </div>
           <div  class="table-responsive">
               <label>10. Personal Mobile Number </label>
               <table class="table table-bordered" id="new_mobile_num" style="margin-bottom: 5px">
                   <tr>
                       <th width="10%">Ser No</th>
                       <th width="35%">Mobile Number</th>
                       <th width="10%">Action</th>

                   </tr>
                   <tr>
                       <td style="background-color: white" contenteditable="true" class="ser_no_mobile">01</td>
                       <td style="background-color: white" contenteditable="true" class="personal_mob_num"></td>
                       <td style="background-color: white" ><button type="button" name="addnumber" id="addnumber" class="btn btn-success btn-xs">Add</button></td>
                   </tr>
               </table>
           </div>

           <div class="row">
               <div class="col-md-12">
                 <label>11.  National Id Information </label> </br>
               </div>
               <div class="form-group col-md-6">
                   <label>a. Self  National Id Information </label>
                   <input pattern="^[_A-z. ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text" required class="form-control" id="per nid name" name="self_nid_name" placeholder="Name As NID">
                   <div class="help-block with-errors"></div>
               </div>
               <div class="form-group col-md-6">
                   <label> </label>
                   <input pattern="^[_0-9-., ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text"  class="form-control" id="per nid no" name="self_nid_no" placeholder="Nid No">
                   <div class="help-block with-errors"></div>
               </div>
           </div>
               <div  class="form-group row">
               <div  class="col-md-6">
                   <label>b. Spouse  National Id Information </label>
                   <input   pattern="^[_A-z. ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text"  class="form-control" id="spouse nid name" name="spouse_nid_name" placeholder="Name As NID">
                   <div class="help-block with-errors"></div>
               </div>
               <div class="col-md-6">
                   <label> </label>
                   <input pattern="^[_0-9-., ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text" class="form-control" id="spouse nid no" name="spouse_nid_no" placeholder="Nid No">
                   <div class="help-block with-errors"></div>
               </div>
           </div>
           <div  class="table-responsive">
               <label>c. Children  National Id Information </label><br>
               <label>Do you have Children?</label>
               <input class="btn btn-info" type="button" value="Yes" name="children" />
               <input class="btn btn-info" type="button" value="No" name="children" />
               <table style="display: none" class="table table-bordered" id="nid_info_children" style="margin-bottom: 5px"><br>
                   <tr>
                       <th width="10%">Ser No</th>
                       <th width="35%">Name As Nid</th>
                       <th width="30%">NID NO</th>
                       <th width="10%">Action</th>
                   </tr>
                   <tr>
                       <td style="background-color: white" contenteditable="true" class="nid_ser_no_children"></td>
                       <td style="background-color: white" contenteditable="true" class="name_as_nid_children"></td>
                       <td style="background-color: white" contenteditable="true" class="nid_no_children"></td>
                       <td style="background-color: white"><button type="button" name="addnid" id="addnid" class="btn btn-success btn-xs">Add</button></td>
                   </tr>
               </table>
           </div>
           </br>
           <div  class="table-responsive">
               <label>12.  Contact Details </label> </br>
               <label>a.  Self Contact Details  </label>
               <table class="table table-bordered" id="contact_details_self" style="margin-bottom: 5px">
                   <tr>
                       <th width="10%">Ser No</th>
                       <th width="20%">Mobile No</th>
                       <th width="20%">IMEI No</th>
                       <th width="30%">Email Address</th>
                       <th width="10%">Action</th>
                   </tr>
                   <tr>
                       <td style="background-color: white" contenteditable="true" class="self_contact_ser_no"></td>
                       <td style="background-color: white" contenteditable="true" class="self_contact_mobile_no"></td>
                       <td style="background-color: white" contenteditable="true" class="self_contact_imei_no"></td>
                       <td style="background-color: white" contenteditable="true" class="self_contact_email_address"></td>
                       <td style="background-color: white"><button type="button" name="selfaddContact" id="selfaddContact" class="btn btn-success btn-xs">Add</button></td>
                   </tr>
               </table>

           </div>
           <div  class="table-responsive">
               <label>b.  Spouse Contact Details  </label>
               <table class="table table-bordered" id="contact_details_spouse" style="margin-bottom: 5px">
                   <tr>
                       <th width="10%">Ser No</th>
                       <th width="20%">Mobile No</th>
                       <th width="20%">IMEI No</th>
                       <th width="30%">Email Address</th>
                       <th width="10%">Action</th>
                   </tr>
                   <tr>
                       <td style="background-color: white" contenteditable="true" class="spouse_contact_ser_no"></td>
                       <td style="background-color: white" contenteditable="true" class="spouse_contact_mobile_no"></td>
                       <td style="background-color: white" contenteditable="true" class="spouse_contact_imei_no"></td>
                       <td style="background-color: white" contenteditable="true" class="spouse_contact_email_address"></td>
                       <td style="background-color: white"><button type="button" name="spouseaddContact" id="spouseaddContact" class="btn btn-success btn-xs">Add</button></td>
                   </tr>
               </table>

           </div>
           <div  class="table-responsive">
               <label>c.  Children Contact Details  </label>
               <table class="table table-bordered" id="contact_details_children" style="margin-bottom: 5px">
                   <tr>
                       <th width="10%">Ser No</th>
                       <th width="20%">Mobile No</th>
                       <th width="20%">IMEI No</th>
                       <th width="30%">Email Address</th>
                       <th width="10%">Action</th>
                   </tr>
                   <tr>
                       <td style="background-color: white" contenteditable="true" class="children_contact_ser_no"></td>
                       <td style="background-color: white" contenteditable="true" class="children_contact_mobile_no"></td>
                       <td style="background-color: white" contenteditable="true" class="children_contact_imei_no"></td>
                       <td style="background-color: white" contenteditable="true" class="children_contact_email_address"></td>
                       <td style="background-color: white"><button type="button" name="childrenaddContact" id="childrenaddContact" class="btn btn-success btn-xs">Add</button></td>
                   </tr>
               </table>

           </div>
           </br>
           <div  class="table-responsive">
               <label>13.  Social Media Information </label> </br>
               <label>a.  Self Social Media Information </label>
               <table class="table table-bordered" id="social_media_table_self" style="margin-bottom: 5px">
                   <tr>
                       <th width="10%">Ser No</th>
                       <th width="20%">Email Address</th>
                       <th width="20%">Social Media Platform
                           <h6> Use Facebook,Twitter,Viber,Imo,whatsapp</h6>
                       </th>
                       <th width="20%">Link</th>
                       <th width="20%">Mobile No</th>
                       <th width="10%">Action</th>
                   </tr>
                   <tr>
                       <td style="background-color: white" contenteditable="true" class="self_social_media_ser_no"></td>
                       <td style="background-color: white" contenteditable="true" class="self_social_media_email_address"></td>
                       <td style="background-color: white" contenteditable="true" class="self_social_media_platform"></td>
                       <td style="background-color: white" contenteditable="true" class="self_social_media_link"></td>
                       <td style="background-color: white" contenteditable="true" class="self_social_media_mobile_no"></td>
                       <td style="background-color: white"><button type="button" name="addselfsocialmedia" id="addselfsocialmedia" class="btn btn-success btn-xs">Add</button></td>
                   </tr>
               </table>
           </div>
           <div  class="table-responsive">
               <label>b.  Spouse Social Media Information </label>
               <table class="table table-bordered" id="social_media_table_spouse" style="margin-bottom: 5px">
                   <tr>
                       <th width="10%">Ser No</th>
                       <th width="20%">Email Address</th>
                       <th width="20%">Social Media Platform
                           <h6> Use Facebook,Twitter,Viber,Imo,whatsapp</h6></th>
                       <th width="20%">Link</th>
                       <th width="20%">Mobile No</th>
                       <th width="10%">Action</th>
                   </tr>
                   <tr>
                       <td style="background-color: white" contenteditable="true" class="spouse_social_media_ser_no"></td>
                       <td style="background-color: white" contenteditable="true" class="spouse_social_media_email_address"></td>
                       <td style="background-color: white" contenteditable="true" class="spouse_social_media_platform"></td>
                       <td style="background-color: white" contenteditable="true" class="spouse_social_media_link"></td>
                       <td style="background-color: white" contenteditable="true" class="spouse_social_media_mobile_no"></td>
                       <td style="background-color: white"><button type="button" name="addspousesocialmedia" id="addspousesocialmedia" class="btn btn-success btn-xs">Add</button></td>
                   </tr>
               </table>
           </div>
           <div  class="table-responsive">
               <label>c.  Children Social Media Information </label>
               <table class="table table-bordered" id="social_media_table_children" style="margin-bottom: 5px">
                   <tr>
                       <th width="10%">Ser No</th>
                       <th width="20%">Email Address</th>
                       <th width="20%">Social Media Platform
                           <h6> Use Facebook,Twitter,Viber,Imo,whatsapp</h6></th>
                       <th width="20%">Link</th>
                       <th width="20%">Mobile No</th>
                       <th width="10%">Action</th>
                   </tr>
                   <tr>
                       <td style="background-color: white" contenteditable="true" class="children_social_media_ser_no"></td>
                       <td style="background-color: white" contenteditable="true" class="children_social_media_email_address"></td>
                       <td style="background-color: white" contenteditable="true" class="children_social_media_platform"></td>
                       <td style="background-color: white" contenteditable="true" class="children_social_media_link"></td>
                       <td style="background-color: white" contenteditable="true" class="children_social_media_mobile_no"></td>
                       <td style="background-color: white"><button type="button" name="addchildrensocialmedia" id="addchildrensocialmedia" class="btn btn-success btn-xs">Add</button></td>
                   </tr>
               </table>
           </div>
           <div class="form-group row">
               <div class="col-md-12">
                   <label>14. Present address</label>
                   <textarea pattern="^[_A-z0-9-., ]{1,}$"
                             data-pattern-error="Special Character (&,$,# etc) not allowed" type="text" required class="form-control" id="present_address" name="present_address" placeholder="Present address"></textarea>
                   <div class="help-block with-errors"></div>
               </div>
           </div>
           <div class="form-group row">
               <div class="col-md-12">
                   <label>15. Permanent Address</label>
                   <textarea pattern="^[_A-z0-9-., ]{1,}$"
                             data-pattern-error="Special Character (&,$,# etc) not allowed" type="text" required class="form-control" id="permanent_address" name="permanent_address" placeholder="Permanent Address"></textarea>
                   <div class="help-block with-errors"></div>
               </div>
           </div>
           <div class="form-group row">
                   <div class="col-md-12">
                      <label>16. Personal Vehicle Information </label> </br>
                   </div>
               <div class="col-md-6">
                   <input pattern="^[_A-z0-9-., ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text"  class="form-control"  name="vehicle_name" placeholder="Vehicle Name">
                   <div class="help-block with-errors"></div>
               </div>
               <div class="col-md-6">
                   <input pattern="^[_A-z0-9-., ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text"  class="form-control" name="reg_no" autocomplete="off" placeholder="Registration No">
                   <div class="help-block with-errors"></div>
               </div>
           </div>
           <div class="form-group row">
               <div class="col-md-12">
                   <label>17.  Bank Information </label> </br>
               </div>
               <div class="col-md-4">
                   <label>&nbsp;&nbsp;a. Self Bank Information </label> </br>
                   <input pattern="^[_A-z0-9-., ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text"  class="form-control" id="Bank Name" name="self_bank_name" placeholder="Bank Name">
                   <div class="help-block with-errors"></div>
               </div>
               <div class="col-md-4">
                   <label> <br></label>
                   <input pattern="^[_A-z0-9-., ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text"  class="form-control" id="branch" name="self_branch" autocomplete="off" placeholder="Branch">
                   <div class="help-block with-errors"></div>
               </div>
               <div class="col-md-4">
                   <label><br></label>
                   <input pattern="^[_A-z0-9-., ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text"  class="form-control" id="Bank Account Number" name="self_bank_account_num" autocomplete="off" placeholder="Bank Account Number">
                   <div class="help-block with-errors"></div>
               </div>
           </div>
               <div class="form-group row">
               <div class="col-md-4">
                   <label>&nbsp;&nbsp;b. Spouse Bank Information </label> </br>
                   <input pattern="^[_A-z0-9-., ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text"  class="form-control" id="Bank Name" name="spouse_bank_name" placeholder="Bank Name">
                   <div class="help-block with-errors"></div>
               </div>
               <div class="col-md-4">
                   <label><br></label>
                   <input pattern="^[_A-z0-9-., ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text"  class="form-control" id="branch" name="spouse_branch" autocomplete="off" placeholder="Branch">
                   <div class="help-block with-errors"></div>
               </div>
               <div class="col-md-4">
                   <label><br></label>
                   <input pattern="^[_A-z0-9-., ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text"  class="form-control" id="Bank Account Number" name="spouse_bank_account_num" autocomplete="off" placeholder="Bank Account Number">
                   <div class="help-block with-errors"></div>
               </div>
               </div>
           <div class="form-group row">
               <div class="col-md-4">
                   <label>&nbsp;&nbsp;c. Children Bank Information </label> </br>
                   <input pattern="^[_A-z0-9-., ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text"  class="form-control" id="Bank Name" name="children_bank_name" placeholder="Bank Name">
                   <div class="help-block with-errors"></div>
               </div>
               <div class="col-md-4">
                   <label><br></label>
                   <input pattern="^[_A-z0-9-., ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text"  class="form-control" id="branch" name="children_branch" autocomplete="off" placeholder="Branch">
                   <div class="help-block with-errors"></div>
               </div>
               <div class="col-md-4">
                   <label><br></label>
                   <input pattern="^[_A-z0-9-., ]{1,}$"
                          data-pattern-error="Special Character (&,$,# etc) not allowed" type="text"  class="form-control" id="Bank Account Number" name="children_bank_account_num" autocomplete="off" placeholder="Bank Account Number">
                   <div class="help-block with-errors"></div>
               </div>
           </div>
              <div class="form-group row">
                <div class="col-md-offset-5 col-md-7">
                  <button type="submit" class="btn btn-success" id="save" name="btn_submit">Submit</button>
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
    $(function () {
        $("input[name=children]").click(function () {
            if ($(this).val() == "Yes") {
                $("#nid_info_children").show();
            } else {
                $("#nid_info_children").hide();
            }
        });
    });
    </script>
<script>
    $(document).ready(function() {
        var count = 1;

        // 07. nid table add function
        $('#addnid').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='nid_ser_no_children'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='name_as_nid_children'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='nid_no_children'></td>";
            html_code += "<td style='background-color: white'><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#nid_info_children').append(html_code);
        });

        // a. self contact add function
        $('#selfaddContact').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='self_contact_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='self_contact_mobile_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='self_contact_imei_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='self_contact_email_address'></td>";
            html_code += "<td style='background-color: white'><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#contact_details_self').append(html_code);
        });
        // b. spouse contact add function
        $('#spouseaddContact').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='spouse_contact_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='spouse_contact_mobile_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='spouse_contact_imei_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='spouse_contact_email_address'></td>";
            html_code += "<td style='background-color: white'><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#contact_details_spouse').append(html_code);
        });
        // c. children contact add function
        $('#childrenaddContact').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='children_contact_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='children_contact_mobile_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='children_contact_imei_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='children_contact_email_address'></td>";
            html_code += "<td style='background-color: white'><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#contact_details_children').append(html_code);
        });
        // 09.  self social media table add function
        $('#addselfsocialmedia').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='self_social_media_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='self_social_media_email_address'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='self_social_media_platform'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='self_social_media_link'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='self_social_media_mobile_no'></td>";
            html_code += "<td style='background-color: white'><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#social_media_table_self').append(html_code);
        });
        // 09.  spouse social media table add function
        $('#addspousesocialmedia').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='spouse_social_media_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='spouse_social_media_email_address'></td>";
            html_code += "<td style='background-color: white'contenteditable='true' class='spouse_social_media_platform'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='spouse_social_media_link'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='spouse_social_media_mobile_no'></td>";
            html_code += "<td style='background-color: white'><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#social_media_table_spouse').append(html_code);
        });
        // 09.  children social media table add function
        $('#addchildrensocialmedia').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='children_social_media_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='children_social_media_email_address'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='children_social_media_platform'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='children_social_media_link'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='children_social_media_mobile_no'></td>";
            html_code += "<td style='background-color: white'><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#social_media_table_children').append(html_code);
        });
        // add mobile number
        $('#addnumber').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='ser_no_mobile'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='personal_mob_num'></td>";
            html_code += "<td style='background-color: white'><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#new_mobile_num').append(html_code);
        });


        $(document).on('click', '.remove', function () {
            var delete_row = $(this).data("row");
            $('#' + delete_row).remove();
        });

        $('#dataEntryForm').validator().on('submit', function (e) {
            if (e.isDefaultPrevented()) {
                // handle the invalid form...
                alert("Please Fill the form correctly.");
            } else {
                var nid_ser_no_children = [];
                var name_as_nid_children = [];
                var nid_no_children = [];
                $('.nid_ser_no_children').each(function () {
                    nid_ser_no_children.push($(this).text());
                });
                $('.name_as_nid_children').each(function () {
                    name_as_nid_children.push($(this).text());
                });
                $('.nid_no_children').each(function () {
                    nid_no_children.push($(this).text());
                });

                $.ajax({
                    url: "insertNIDInfo.php",
                    method: "POST",
                    data: {
                        nid_ser_no_children: nid_ser_no_children,
                        name_as_nid_children: name_as_nid_children,
                        nid_no_children: nid_no_children
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });

                var self_contact_ser_no = [];
                var self_contact_mobile_no = [];
                var self_contact_imei_no = [];
                var self_contact_email_address = [];
                $('.self_contact_ser_no').each(function () {
                    self_contact_ser_no.push($(this).text());
                });
                $('.self_contact_mobile_no').each(function () {
                    self_contact_mobile_no.push($(this).text());
                });
                $('.self_contact_imei_no').each(function () {
                    self_contact_imei_no.push($(this).text());
                });
                $('.self_contact_email_address').each(function () {
                    self_contact_email_address.push($(this).text());
                });

                $.ajax({
                    url: "insertselfcontact.php",
                    method: "POST",
                    data: {
                        self_contact_ser_no: self_contact_ser_no,
                        self_contact_mobile_no: self_contact_mobile_no,
                        self_contact_imei_no: self_contact_imei_no,
                        self_contact_email_address: self_contact_email_address
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });
                var spouse_contact_ser_no = [];
                var spouse_contact_mobile_no = [];
                var spouse_contact_imei_no = [];
                var spouse_contact_email_address = [];
                $('.spouse_contact_ser_no').each(function () {
                    spouse_contact_ser_no.push($(this).text());
                });
                $('.spouse_contact_mobile_no').each(function () {
                    spouse_contact_mobile_no.push($(this).text());
                });
                $('.spouse_contact_imei_no').each(function () {
                    spouse_contact_imei_no.push($(this).text());
                });
                $('.spouse_contact_email_address').each(function () {
                    spouse_contact_email_address.push($(this).text());
                });

                $.ajax({
                    url: "insertspousecontact.php",
                    method: "POST",
                    data: {
                        spouse_contact_ser_no: spouse_contact_ser_no,
                        spouse_contact_mobile_no: spouse_contact_mobile_no,
                        spouse_contact_imei_no: spouse_contact_imei_no,
                        spouse_contact_email_address: spouse_contact_email_address
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });

                var children_contact_ser_no = [];
                var children_contact_mobile_no = [];
                var children_contact_imei_no = [];
                var children_contact_email_address = [];
                $('.children_contact_ser_no').each(function () {
                    children_contact_ser_no.push($(this).text());
                });
                $('.children_contact_mobile_no').each(function () {
                    children_contact_mobile_no.push($(this).text());
                });
                $('.children_contact_imei_no').each(function () {
                    children_contact_imei_no.push($(this).text());
                });
                $('.children_contact_email_address').each(function () {
                    children_contact_email_address.push($(this).text());
                });

                $.ajax({
                    url: "insertchildrencontact.php",
                    method: "POST",
                    data: {
                        children_contact_ser_no: children_contact_ser_no,
                        children_contact_mobile_no: children_contact_mobile_no,
                        children_contact_imei_no: children_contact_imei_no,
                        children_contact_email_address: children_contact_email_address
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });

                var self_social_media_ser_no = [];
                var self_social_media_email_address = [];
                var self_social_media_platform = [];
                var self_social_media_link = [];
                var self_social_media_mobile_no = [];
                $('.self_social_media_ser_no').each(function () {
                    self_social_media_ser_no.push($(this).text());
                });

                $('.self_social_media_email_address').each(function () {
                    self_social_media_email_address.push($(this).text());
                });
                $('.self_social_media_platform').each(function () {
                    self_social_media_platform.push($(this).text());
                });
                $('.self_social_media_link').each(function () {
                    self_social_media_link.push($(this).text());
                });
                $('.self_social_media_mobile_no').each(function () {
                    self_social_media_mobile_no.push($(this).text());
                });
                $.ajax({
                    url: "insertselfsocialmedia.php",
                    method: "POST",
                    data: {
                        self_social_media_ser_no: self_social_media_ser_no,
                        self_social_media_email_address: self_social_media_email_address,
                        self_social_media_platform: self_social_media_platform,
                        self_social_media_link: self_social_media_link,
                        self_social_media_mobile_no: self_social_media_mobile_no
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });
                var spouse_social_media_ser_no = [];
                var spouse_social_media_email_address = [];
                var spouse_social_media_platform = [];
                var spouse_social_media_link = [];
                var spouse_social_media_mobile_no = [];
                $('.spouse_social_media_ser_no').each(function () {
                    spouse_social_media_ser_no.push($(this).text());
                });

                $('.spouse_social_media_email_address').each(function () {
                    spouse_social_media_email_address.push($(this).text());
                });
                $('.spouse_social_media_platform').each(function () {
                    spouse_social_media_platform.push($(this).text());
                });
                $('.spouse_social_media_link').each(function () {
                    spouse_social_media_link.push($(this).text());
                });
                $('.spouse_social_media_mobile_no').each(function () {
                    spouse_social_media_mobile_no.push($(this).text());
                });
                $.ajax({
                    url: "insertspousesocialmedia.php",
                    method: "POST",
                    data: {
                        spouse_social_media_ser_no: spouse_social_media_ser_no,
                        spouse_social_media_email_address: spouse_social_media_email_address,
                        spouse_social_media_platform: spouse_social_media_platform,
                        spouse_social_media_link: spouse_social_media_link,
                        spouse_social_media_mobile_no: spouse_social_media_mobile_no
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });
                var children_social_media_ser_no = [];
                var children_social_media_email_address = [];
                var children_social_media_platform = [];
                var children_social_media_link = [];
                var children_social_media_mobile_no = [];
                $('.children_social_media_ser_no').each(function () {
                    children_social_media_ser_no.push($(this).text());
                });

                $('.children_social_media_email_address').each(function () {
                    children_social_media_email_address.push($(this).text());
                });
                $('.children_social_media_platform').each(function () {
                    children_social_media_platform.push($(this).text());
                });
                $('.children_social_media_link').each(function () {
                    children_social_media_link.push($(this).text());
                });
                $('.children_social_media_mobile_no').each(function () {
                    children_social_media_mobile_no.push($(this).text());
                });
                $.ajax({
                    url: "insertchildrensocialmedia.php",
                    method: "POST",
                    data: {
                        children_social_media_ser_no: children_social_media_ser_no,
                        children_social_media_email_address: children_social_media_email_address,
                        children_social_media_platform: children_social_media_platform,
                        children_social_media_link: children_social_media_link,
                        children_social_media_mobile_no: children_social_media_mobile_no
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });

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
                        fetch_item_data();
                    }
                });
            }
        });
    });
</script>