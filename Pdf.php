<?php

class Pdf
{
    protected $link;
    public function __construct()
    {
        $this->link = mysqli_connect('localhost','root','','pdf');
    }
    public function insertUserData()
    {
        $bd_no =  $_POST['bd_no'];
        $rank =  $_POST['rank'];
        $user_name = $_POST['user_name'];
        $trade = $_POST['trade'];
        $user_password = $_POST['bd_no'];
        $date_of_birth = $_POST['date_of_birth'];

        $sql = "INSERT INTO users(bd_no,rank,user_name,trade,user_password,date_of_birth)
                VALUES ('$bd_no','$rank','$user_name','$trade','$user_password','$date_of_birth')";
        if (mysqli_query($this->link, $sql)) {
            $message = "New User Inserted Successfully!";
            return $message;
        } else {
            die("insertUserData Query Problem : " . mysqli_error($this->link));
        }
    }

    public function selectAllUsers(){
        $sql = "SELECT * FROM users";
        if (mysqli_query($this->link, $sql)) {
            $result = mysqli_query($this->link,$sql);
            return $result;
        } else {
            die("visit_info Insert Query Problem : " . mysqli_error($this->link));
        }
    }

    public function selectIndividualUsers(){
        $sql = "SELECT * FROM users WHERE bd_no = '$_POST[bd_no]'";
        if (mysqli_query($this->link, $sql)) {
            $result = mysqli_query($this->link,$sql);
            return $result;
        } else {
            die("visit_info Insert Query Problem : " . mysqli_error($this->link));
        }
    }

    public function updateUserData()
    {
        $sql = "UPDATE users
              SET 
              rank = '$_POST[rank]',
              user_name = '$_POST[user_name]',
              trade = '$_POST[trade]',
              date_of_birth = '$_POST[date_of_birth]',
              user_password = '$_POST[user_password]'
              WHERE bd_no='$_POST[bd_no]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "User Information Updated Successfully!";
            return $message;
        } else {
            die('updateUserData Update Query Problem : ' . mysqli_error($this->link));
        }
    }
    public function savePersonnelInfo()

    {
        $user_id =  $_SESSION['id'];
        $data_entry_id =  $_SESSION['data_entry_id'];
        $full_name =  $_POST['full_name'];
        $rank =  $_POST['rank'];
        $bd_no = $_POST['bd_no'];
        $br_trade = $_POST['br_trade'];
        $unit = $_POST['unit'];
        $date_of_birth = $_POST['date_of_birth'];
        $passport_no = $_POST['passport_no'];
        $mar_status= $_POST['mar_status'];
        $child_male = $_POST['child_male'];
        $child_female = $_POST['child_female'];
        $self_nid_name = $_POST['self_nid_name'];
        $self_nid_no = $_POST['self_nid_no'];
        $spouse_nid_name = $_POST['spouse_nid_name'];
        $spouse_nid_no = $_POST['spouse_nid_no'];
        $present_address = $_POST['present_address'];
        $permanent_address = $_POST['permanent_address'];
        $vehicle_name =  $_POST['vehicle_name'];
        $reg_no = $_POST['reg_no'];
        $self_bank_name = $_POST['self_bank_name'];
        $self_branch = $_POST['self_branch'];
        $self_bank_account_num = $_POST['self_bank_account_num'];
        $spouse_bank_name = $_POST['spouse_bank_name'];
        $spouse_branch = $_POST['spouse_branch'];
        $spouse_bank_account_num =  $_POST['spouse_bank_account_num'];
        $children_bank_name = $_POST['children_bank_name'];
        $children_branch = $_POST['children_branch'];
        $children_bank_account_num = $_POST['children_bank_account_num'];


        $sql = "INSERT INTO
                personnel_info(user_id,data_entry_id,full_name,rank,bd_no,br_trade,unit,date_of_birth,passport_no,mar_status,child_male,child_female,self_nid_name,self_nid_no,spouse_nid_name,spouse_nid_no,present_address,permanent_address,vehicle_name,reg_no,self_bank_name,self_branch,self_bank_account_num,spouse_bank_name,spouse_branch,spouse_bank_account_num,children_bank_name,children_branch,children_bank_account_num)
                VALUES
                ('$user_id','$data_entry_id','$full_name','$rank','$bd_no','$br_trade','$unit','$date_of_birth','$passport_no','$mar_status','$child_male','$child_female','$self_nid_name','$self_nid_no','$spouse_nid_name','$spouse_nid_no','$present_address','$permanent_address','$vehicle_name','$reg_no','$self_bank_name','$self_branch','$self_bank_account_num','$spouse_bank_name','$spouse_branch','$spouse_bank_account_num','$children_bank_name','$children_branch','$children_bank_account_num')";

        if (mysqli_query($this->link,$sql)){
            $message = "Personnel Data Inserted Successfully";
            return $message;
        }
        else {
            die("Query Problem : ".mysqli_error($this->link));
        }
    }
    public function savePersonnelInfoAdmin()

    {  $photo_name = $_FILES['upload_image']['name'];
        $photo_path = $_FILES['upload_image']['tmp_name'];
        //echo $photo_name.'_'.$photo_path;die;
        $upload_image =$photo_name;
        move_uploaded_file($photo_path, "photo/$photo_name");

        $user_id =  $_SESSION['id'];
        $data_entry_id =  $_SESSION['data_entry_id'];
        $full_name =  $_POST['full_name'];
        $rank =  $_POST['rank'];
        $bd_no = $_POST['bd_no'];
        $br_trade = $_POST['br_trade'];
        $unit = $_POST['unit'];
        $date_of_birth = $_POST['date_of_birth'];
        $passport_no = $_POST['passport_no'];
        $mar_status= $_POST['mar_status'];
        $child_male = $_POST['child_male'];
        $child_female = $_POST['child_female'];
        $self_nid_name = $_POST['self_nid_name'];
        $self_nid_no = $_POST['self_nid_no'];
        $spouse_nid_name = $_POST['spouse_nid_name'];
        $spouse_nid_no = $_POST['spouse_nid_no'];
        $present_address = $_POST['present_address'];
        $permanent_address = $_POST['permanent_address'];
        $vehicle_name =  $_POST['vehicle_name'];
        $reg_no = $_POST['reg_no'];
        $self_bank_name = $_POST['self_bank_name'];
        $self_branch = $_POST['self_branch'];
        $self_bank_account_num = $_POST['self_bank_account_num'];
        $spouse_bank_name = $_POST['spouse_bank_name'];
        $spouse_branch = $_POST['spouse_branch'];
        $spouse_bank_account_num =  $_POST['spouse_bank_account_num'];
        $children_bank_name = $_POST['children_bank_name'];
        $children_branch = $_POST['children_branch'];
        $children_bank_account_num = $_POST['children_bank_account_num'];


        $sql = "INSERT INTO
                personnel_info(user_id,data_entry_id,full_name,upload_image,rank,bd_no,br_trade,unit,date_of_birth,passport_no,mar_status,child_male,child_female,self_nid_name,self_nid_no,spouse_nid_name,spouse_nid_no,present_address,permanent_address,vehicle_name,reg_no,self_bank_name,self_branch,self_bank_account_num,spouse_bank_name,spouse_branch,spouse_bank_account_num,children_bank_name,children_branch,children_bank_account_num)
                VALUES
                ('$user_id','$data_entry_id','$full_name','$upload_image','$rank','$bd_no','$br_trade','$unit','$date_of_birth','$passport_no','$mar_status','$child_male','$child_female','$self_nid_name','$self_nid_no','$spouse_nid_name','$spouse_nid_no','$present_address','$permanent_address','$vehicle_name','$reg_no','$self_bank_name','$self_branch','$self_bank_account_num','$spouse_bank_name','$spouse_branch','$spouse_bank_account_num','$children_bank_name','$children_branch','$children_bank_account_num')";

        if (mysqli_query($this->link,$sql)){
            $message = "Personnel Data Inserted Successfully";
            return $message;
        }
        else {
            die("Query Problem : ".mysqli_error($this->link));
        }
    }
    public function viewpdfList(){
        $sql="SELECT * FROM personnel_info ORDER BY id DESC";
        if(mysqli_query($this->link, $sql)){
            $queryResult=mysqli_query($this->link, $sql);
            return $queryResult;
        }else{
            die('Query Problem'. mysqli_error($this->link));
        }
    }

    public function updateDataEntryForm($data){

        $sql = "UPDATE personnel_info
              SET 
              full_name='$data[full_name]',
              rank='$data[rank]',
              bd_no='$data[bd_no]',
              br_trade='$data[br_trade]',
              unit='$data[unit]',
              date_of_birth='$data[date_of_birth]',
              passport_no='$data[passport_no]',
              mar_status='$data[mar_status]',
              child_male='$data[child_male]',
              child_female='$data[child_female]',
              self_nid_name='$data[self_nid_name]',
              self_nid_no='$data[self_nid_no]',
              spouse_nid_no='$data[spouse_nid_no]',
              self_nid_name='$data[self_nid_name]',
              present_address='$data[present_address]',
              permanent_address='$data[permanent_address]',
              vehicle_name='$data[vehicle_name]',
              reg_no='$data[reg_no]',
              self_bank_name='$data[self_bank_name]',
              self_branch='$data[self_branch]',
              self_bank_account_num='$data[self_bank_account_num]',
              spouse_bank_name='$data[spouse_bank_name]',
              spouse_branch='$data[spouse_branch]',
              spouse_bank_account_num='$data[spouse_bank_account_num]',
              children_bank_name='$data[children_bank_name]',
              children_branch='$data[children_branch]',
              children_bank_account_num='$data[children_bank_account_num]'
              WHERE id='$data[id]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Your Data Updated Successfully";
            return $message;
        } else {
            die('Data Entry Update Query Problem : ' . mysqli_error($this->link));
        }
    }
    public function updateDataEntryFormAdmin($data){

        $photo_name = $_FILES['upload_image']['name'];
        $photo_path = $_FILES['upload_image']['tmp_name'];
        //echo $photo_name.'_'.$photo_path;die;
        $upload_image =$photo_name;
        move_uploaded_file($photo_path, "photo/$photo_name");
        if($upload_image != ''){
            $upload_image =$photo_name;
        }else{
            $upload_image =$data['uploaded_image'];
        }

        $sql = "UPDATE personnel_info
              SET 
              full_name='$data[full_name]',
              upload_image='$upload_image',
              rank='$data[rank]',
              bd_no='$data[bd_no]',
              br_trade='$data[br_trade]',
              unit='$data[unit]',
              date_of_birth='$data[date_of_birth]',
              passport_no='$data[passport_no]',
              mar_status='$data[mar_status]',
              child_male='$data[child_male]',
              child_female='$data[child_female]',
              self_nid_name='$data[self_nid_name]',
              self_nid_no='$data[self_nid_no]',
              spouse_nid_no='$data[spouse_nid_no]',
              self_nid_name='$data[self_nid_name]',
              present_address='$data[present_address]',
              permanent_address='$data[permanent_address]',
              vehicle_name='$data[vehicle_name]',
              reg_no='$data[reg_no]',
              self_bank_name='$data[self_bank_name]',
              self_branch='$data[self_branch]',
              self_bank_account_num='$data[self_bank_account_num]',
              spouse_bank_name='$data[spouse_bank_name]',
              spouse_branch='$data[spouse_branch]',
              spouse_bank_account_num='$data[spouse_bank_account_num]',
              children_bank_name='$data[children_bank_name]',
              children_branch='$data[children_branch]',
              children_bank_account_num='$data[children_bank_account_num]'
              WHERE id='$data[id]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Your Data Updated Successfully";
            return $message;
        } else {
            die('Data Entry Update Query Problem : ' . mysqli_error($this->link));
        }
    }
    public function updateMobileNoStatus(){

        $sql = "UPDATE per_mobile_num
              SET 
              present_status = '$_POST[present_status]'
              WHERE id='$_POST[mobile_no_id]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Your Data Updated Successfully";
            return $message;
        } else {
            die('Data Entry Update Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function viewDataEntryFormUpdate($user_id,$data_entry_id)
    {
        $sql = "SELECT * FROM personnel_info WHERE user_id='$user_id'&& data_entry_id='$data_entry_id'";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('data entry Problem : ' . mysqli_error($this->link));
        }
    }
    public function getDynamicTableData($sql)
    {
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('Get Dynamic Table Data Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function viewPasswordResetRequestList()
    {
        $sql = "SELECT * FROM users WHERE pass_reset_request='requested' ORDER BY bd_no";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('viewPasswordResetRequestList Query Problem : ' . mysqli_error($this->link));
        }
    }

}
