<?php
session_start();
$user_id=$_SESSION['id'];

if (!isset($user_id)){
    header('location : index.php');
} else {
    // Data Entry ID increment Code Start
    include("connection.php");
    $sql = "SELECT * FROM personnel_info WHERE user_id='$user_id'" or die("database error:". mysqli_error($connect));
    $result = mysqli_query($connect,$sql);
    if(mysqli_num_rows($result)>0)
    {
        $data = mysqli_fetch_assoc($result);
        $dataId = $data['data_entry_id'];
        $user_id = $data['user_id'];
        //$dataId= ++$dataId;
        $_SESSION['dataId']=$dataId;
        header("Location: data_entry_form_update.php?data_entry_id=$dataId&&user_id=$user_id");
    }else{
        $_SESSION['dataId']=1;
        header("Location: data_entry_form.php");
    }
    // Data Entry ID increment Code End
}
