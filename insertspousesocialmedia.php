<?php
session_start();
// Data Entry ID increment Code Start
$user_id=$_SESSION['id'];
include("connection.php");
// Data Entry ID increment Code End
if(isset($_POST["spouse_social_media_ser_no"]))
{
    $spouse_social_media_ser_no = $_POST["spouse_social_media_ser_no"];
    $spouse_social_media_email_address = $_POST["spouse_social_media_email_address"];
    $spouse_social_media_platform = $_POST["spouse_social_media_platform"];
    $spouse_social_media_link = $_POST["spouse_social_media_link"];
    $spouse_social_media_mobile_no = $_POST["spouse_social_media_mobile_no"];
    $query = '';
    for($count = 0; $count<count($spouse_social_media_ser_no); $count++)
    {
        $spouse_social_media_ser_no_clean = mysqli_real_escape_string($connect, $spouse_social_media_ser_no[$count]);
        $spouse_social_media_email_address_clean = mysqli_real_escape_string($connect, $spouse_social_media_email_address[$count]);
        $spouse_social_media_platform_clean = mysqli_real_escape_string($connect, $spouse_social_media_platform[$count]);
        $spouse_social_media_link_clean = mysqli_real_escape_string($connect, $spouse_social_media_link[$count]);
        $spouse_social_media_mobile_no_clean = mysqli_real_escape_string($connect, $spouse_social_media_mobile_no[$count]);
        if($spouse_social_media_ser_no_clean != '')
        {
            $query .= '
       INSERT INTO social_media_table_spouse(user_id,data_entry_id,spouse_social_media_ser_no,spouse_social_media_email_address,spouse_social_media_platform, spouse_social_media_link,spouse_social_media_mobile_no) 
       VALUES("'.$_SESSION['id'].'","'.$_SESSION['dataId'].'","'.$spouse_social_media_ser_no_clean.'",  "'.$spouse_social_media_email_address_clean.'", "'.$spouse_social_media_platform_clean.'", "'.$spouse_social_media_link_clean.'", "'.$spouse_social_media_mobile_no_clean.'"); 
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
        echo 'socialmedia All Fields are Required';
    }
}

?>
