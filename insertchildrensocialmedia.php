<?php
session_start();
// Data Entry ID increment Code Start
$user_id=$_SESSION['id'];
include("connection.php");

// Data Entry ID increment Code End
if(isset($_POST["children_social_media_ser_no"]))
{
    $children_social_media_ser_no = $_POST["children_social_media_ser_no"];
    $children_social_media_email_address = $_POST["children_social_media_email_address"];
    $children_social_media_platform = $_POST["children_social_media_platform"];
    $children_social_media_link = $_POST["children_social_media_link"];
    $children_social_media_mobile_no = $_POST["children_social_media_mobile_no"];
    $query = '';
    for($count = 0; $count<count($children_social_media_ser_no); $count++)
    {
        $children_social_media_ser_no_clean = mysqli_real_escape_string($connect, $children_social_media_ser_no[$count]);
        $children_social_media_email_address_clean = mysqli_real_escape_string($connect, $children_social_media_email_address[$count]);
        $children_social_media_platform_clean = mysqli_real_escape_string($connect, $children_social_media_platform[$count]);
        $children_social_media_link_clean = mysqli_real_escape_string($connect, $children_social_media_link[$count]);
        $children_social_media_mobile_no_clean = mysqli_real_escape_string($connect, $children_social_media_mobile_no[$count]);
        if($children_social_media_ser_no_clean != '')
        {
            $query .= '
       INSERT INTO social_media_table_children(user_id,data_entry_id,children_social_media_ser_no,  children_social_media_email_address, children_social_media_platform, children_social_media_link,children_social_media_mobile_no) 
       VALUES("'.$_SESSION['id'].'","'.$_SESSION['dataId'].'","'.$children_social_media_ser_no_clean.'","'.$children_social_media_email_address_clean.'", "'.$children_social_media_platform_clean.'", "'.$children_social_media_link_clean.'", "'.$children_social_media_mobile_no_clean.'"); 
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

