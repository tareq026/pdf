<?php
session_start();
// Data Entry ID increment Code Start
$user_id=$_SESSION['id'];
include("connection.php");

// Data Entry ID increment Code End
if(isset($_POST["ser_no_mobile"]))
{
    $ser_no_mobile = $_POST["ser_no_mobile"];
    $personal_mob_num = $_POST["personal_mob_num"];
    $query = '';
    for($count = 0; $count<count($ser_no_mobile); $count++)
    {
        $ser_no_mobile_clean = mysqli_real_escape_string($connect, $ser_no_mobile[$count]);
        $personal_mob_num_clean = mysqli_real_escape_string($connect, $personal_mob_num[$count]);
        if($personal_mob_num_clean != '')
        {
            $query .= '
       INSERT INTO per_mobile_num(user_id,data_entry_id,ser_no_mobile,personal_mob_num) 
       VALUES("'.$_SESSION['id'].'","'.$_SESSION['dataId'].'","'.$ser_no_mobile_clean.'", "'.$personal_mob_num_clean.'"); 
       ';
        }
    }

    if($query != '')
    {
        if(mysqli_multi_query($connect, $query))
        {
            echo 'Data Updated Successfully';
        }
        else
        {
            echo 'Self Social Media Info'.mysqli_error($connect);
        }
    }
    else
    {
        echo 'contact All Fields are Required';
    }
}

?>
