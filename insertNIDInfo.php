<?php
session_start();

// Data Entry ID increment Code Start
$user_id=$_SESSION['id'];
include("connection.php");

// Data Entry ID increment Code End

if(isset($_POST["nid_ser_no_children"]))
{
     $nid_ser_no_children = $_POST["nid_ser_no_children"];
     $name_as_nid_children = $_POST["name_as_nid_children"];
     $nid_no_children = $_POST["nid_no_children"];
     $query = '';
 for($count = 0; $count<count($nid_ser_no_children); $count++)
 {
      $nid_ser_no_children_clean = mysqli_real_escape_string($connect, $nid_ser_no_children[$count]);
      $name_as_nid_children_clean = mysqli_real_escape_string($connect, $name_as_nid_children[$count]);
      $nid_no_children_clean = mysqli_real_escape_string($connect, $nid_no_children[$count]);
      if($nid_ser_no_children_clean != '')
      {
       $query .= '
       INSERT INTO nid_info_children(user_id,data_entry_id,nid_ser_no_children,  name_as_nid_children, nid_no_children) 
       VALUES("'.$_SESSION['id'].'","'.$_SESSION['dataId'].'","'.$nid_ser_no_children_clean.'",  "'.$name_as_nid_children_clean.'", "'.$nid_no_children_clean.'"); 
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
    echo 'Nid Info All Fields are Required';
 }
}

?>