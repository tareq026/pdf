<?php
session_start();
include("connection.php");

if(isset($_POST["self_social_media_ser_no"]))
{
    $self_social_media_ser_no = $_POST["self_social_media_ser_no"];
    $self_social_media_email_address = $_POST["self_social_media_email_address"];
    $self_social_media_platform = $_POST["self_social_media_platform"];
    $self_social_media_link = $_POST["self_social_media_link"];
    $self_social_media_mobile_no = $_POST["self_social_media_mobile_no"];
    $query = '';
    for($count = 0; $count<count($self_social_media_ser_no); $count++)
    {
        $self_social_media_ser_no_clean = mysqli_real_escape_string($connect, $self_social_media_ser_no[$count]);
        $self_social_media_email_address_clean = mysqli_real_escape_string($connect, $self_social_media_email_address[$count]);
        $self_social_media_platform_clean = mysqli_real_escape_string($connect, $self_social_media_platform[$count]);
        $self_social_media_link_clean = mysqli_real_escape_string($connect, $self_social_media_link[$count]);
        $self_social_media_mobile_no_clean = mysqli_real_escape_string($connect, $self_social_media_mobile_no[$count]);
        if($self_social_media_ser_no_clean != '')
        {
            $query .= '
       INSERT INTO social_media_table_self(user_id,data_entry_id,self_social_media_ser_no,self_social_media_email_address,self_social_media_platform,self_social_media_link,self_social_media_mobile_no) 
       VALUES("'.$_SESSION['id'].'","'.$_SESSION['dataId'].'","'.$self_social_media_ser_no_clean.'",  "'.$self_social_media_email_address_clean.'", "'.$self_social_media_platform_clean.'", "'.$self_social_media_link_clean.'", "'.$self_social_media_mobile_no_clean.'"); 
       ';
        }
    }

    if($query != '')
    {
        if(mysqli_multi_query($connect, $query))
        {
            echo 'Self Social Media Info Inserted Successfully';
        }
        else
        {
            echo 'Self Social Media Info'.mysqli_error($connect);
        }
    }
    else
    {
        echo 'Self Social Media Info All Fields are Required';
    }
}

?>