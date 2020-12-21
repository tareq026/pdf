<?php
session_start();
// Data Entry ID increment Code Start
$user_id=$_SESSION['id'];
include("connection.php");

// Data Entry ID increment Code End
if(isset($_POST["children_contact_ser_no"]))
{
    $children_contact_ser_no = $_POST["children_contact_ser_no"];
    $children_contact_mobile_no = $_POST["children_contact_mobile_no"];
    $children_contact_imei_no = $_POST["children_contact_imei_no"];
    $children_contact_email_address = $_POST["children_contact_email_address"];
    $query = '';
    for($count = 0; $count<count($children_contact_ser_no); $count++)
    {
        $children_contact_ser_no_clean = mysqli_real_escape_string($connect, $children_contact_ser_no[$count]);
        $children_contact_mobile_no_clean = mysqli_real_escape_string($connect, $children_contact_mobile_no[$count]);
        $children_contact_imei_no_clean = mysqli_real_escape_string($connect, $children_contact_imei_no[$count]);
        $children_contact_email_address_clean = mysqli_real_escape_string($connect, $children_contact_email_address[$count]);
        if($children_contact_ser_no_clean != '')
        {
            $query .= '
       INSERT INTO contact_details_children(user_id,data_entry_id,children_contact_ser_no,children_contact_mobile_no,children_contact_imei_no,children_contact_email_address) 
       VALUES("'.$_SESSION['id'].'","'.$_SESSION['dataId'].'","'.$children_contact_ser_no_clean.'", "'.$children_contact_mobile_no_clean.'", "'.$children_contact_imei_no_clean.'", "'.$children_contact_email_address_clean.'"); 
       ';
        }
    }

    if($query != '')
    {
        if(mysqli_multi_query($connect, $query))
        {
            //echo 'Transit Info Inserted Successfully';
        }
        else
        {
            echo 'Error';
        }
    }
    else
    {
        echo 'contact All Fields are Required';
    }
}

?>

