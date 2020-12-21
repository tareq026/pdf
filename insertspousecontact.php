<?php
session_start();
// Data Entry ID increment Code Start
$user_id=$_SESSION['id'];
include("connection.php");

// Data Entry ID increment Code End
if(isset($_POST["spouse_contact_ser_no"]))
{
    $spouse_contact_ser_no = $_POST["spouse_contact_ser_no"];
    $spouse_contact_mobile_no = $_POST["spouse_contact_mobile_no"];
    $spouse_contact_imei_no = $_POST["spouse_contact_imei_no"];
    $spouse_contact_email_address = $_POST["spouse_contact_email_address"];
    $query = '';
    for($count = 0; $count<count($spouse_contact_ser_no); $count++)
    {
        $spouse_contact_ser_no_clean = mysqli_real_escape_string($connect, $spouse_contact_ser_no[$count]);
        $spouse_contact_mobile_no_clean = mysqli_real_escape_string($connect, $spouse_contact_mobile_no[$count]);
        $spouse_contact_imei_no_clean = mysqli_real_escape_string($connect, $spouse_contact_imei_no[$count]);
        $spouse_contact_email_address_clean = mysqli_real_escape_string($connect, $spouse_contact_email_address[$count]);
        if($spouse_contact_ser_no_clean != '')
        {
            $query .= '
       INSERT INTO contact_details_spouse(user_id,data_entry_id,spouse_contact_ser_no, spouse_contact_mobile_no, spouse_contact_imei_no,spouse_contact_email_address) 
       VALUES("'.$_SESSION['id'].'","'.$_SESSION['dataId'].'","'.$spouse_contact_ser_no_clean.'",  "'.$spouse_contact_mobile_no_clean.'", "'.$spouse_contact_imei_no_clean.'", "'.$spouse_contact_email_address_clean.'"); 
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

