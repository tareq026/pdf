<?php
session_start();
// Data Entry ID increment Code Start
$user_id=$_SESSION['id'];
include("connection.php");

// Data Entry ID increment Code End
if(isset($_POST["self_contact_ser_no"]))
{
    $self_contact_ser_no = $_POST["self_contact_ser_no"];
    $self_contact_mobile_no = $_POST["self_contact_mobile_no"];
    $self_contact_imei_no = $_POST["self_contact_imei_no"];
    $self_contact_email_address = $_POST["self_contact_email_address"];
    $query = '';
    for($count = 0; $count<count($self_contact_ser_no); $count++)
    {
        $self_contact_ser_no_clean = mysqli_real_escape_string($connect, $self_contact_ser_no[$count]);
        $self_contact_mobile_no_clean = mysqli_real_escape_string($connect, $self_contact_mobile_no[$count]);
        $self_contact_imei_no_clean = mysqli_real_escape_string($connect, $self_contact_imei_no[$count]);
        $self_contact_email_address_clean = mysqli_real_escape_string($connect, $self_contact_email_address[$count]);
        if($self_contact_ser_no_clean != '')
        {
            $query .= '
       INSERT INTO contact_details_self(user_id,data_entry_id,self_contact_ser_no, self_contact_mobile_no, self_contact_imei_no,self_contact_email_address) 
       VALUES("'.$_SESSION['id'].'","'.$_SESSION['dataId'].'","'.$self_contact_ser_no_clean.'", "'.$self_contact_mobile_no_clean.'", "'.$self_contact_imei_no_clean.'", "'.$self_contact_email_address_clean.'"); 
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
