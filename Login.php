<?php

class Login{

        protected $link;
        public function __construct(){
            $this->link= mysqli_connect('localhost', 'root', '','pdf');

        }

        public function adminLoginCheck($data){
            $bd_no=$data['bd_no'];
            $date_of_birth=$data['date_of_birth'];
            $user_password=$data['user_password'];
            $sql = "SELECT * FROM users WHERE bd_no='$bd_no'";
            if (mysqli_query($this->link, $sql)) {
                $queryResult = mysqli_query($this->link, $sql);
                if (mysqli_num_rows($queryResult) > 0) {
                    $userInfo = mysqli_fetch_assoc($queryResult);
                    if ($date_of_birth==$userInfo['date_of_birth']){
                        if ($user_password == $userInfo['user_password']) {
                            session_start();
                            $_SESSION['id'] = $userInfo['id'];
                            $_SESSION['bd_no'] = $userInfo['bd_no'];
                            $_SESSION['user_role'] = $userInfo['user_role'];
                            $_SESSION['user_name'] = $userInfo['user_name'];
                            $_SESSION['rank'] = $userInfo['rank'];
                            $_SESSION['trade'] = $userInfo['trade'];
                            $_SESSION['date_of_birth'] = $userInfo['date_of_birth'];
                            header('location: index.php');
                        }
                        else {
                            $message = "Password is not correct!<br> Please reset your password.";
                        }
                    }else{
                        $message = "Your date of birth is not correct!<br> Please enter correct date of birth.";
                    }
                }else{
                    $message = "You are not registered! <br> Please contact with Dte AI(3050 or 01769993050)";
                }
            }
            else {
                die('Login Query Problem : ' . mysqli_error($this->link));
            }
            return $message;
        }
    public function userResetPassword($data)
    {
        $sql = "SELECT * FROM users WHERE bd_no='$_SESSION[bd_no]'";
        $queryResult = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($queryResult)>0) {
            $sql = "UPDATE users SET
            user_password='$data[user_password]'
            WHERE bd_no='$_SESSION[bd_no]'";
            if (mysqli_query($this->link, $sql)) {
                $_SESSION['message'] = "Password changed Successfully! <br> Pl login again with new password.";
                $this->adminLogout();
                header('Location: index.php');
            } else {
                die('Password Reset Error : ' . mysqli_error($this->link));
            }
        } else {
            $message = "";
            return $message;
        }
    }
    public function passwordResetRequest()
    {
        $bd_no = $_POST['bd_no'];
        $date_of_birth = $_POST['date_of_birth'];
        $sql = "SELECT * FROM users WHERE bd_no='$bd_no'";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            if (mysqli_num_rows($queryResult) > 0) {
                $userInfo = mysqli_fetch_assoc($queryResult);

                if ($date_of_birth==$userInfo['date_of_birth']){
                    $sql = "UPDATE users
                            SET
                            pass_reset_request='requested'
                            WHERE bd_no='$_POST[bd_no]'";

                    if (mysqli_multi_query($this->link, $sql)) {
                        $message = "Your Password Reset Request sent Successfully!";
                    } else {
                        die('passwordResetRequest Query Problem : ' . mysqli_error($this->link));
                    }

                }else{
                    $message = "Your date of birth is not correct!<br> Please enter correct date of birth.";
                }
            }
            else{
                $message = "You are not registered! <br> Please contact with(3050 or 01769993050)";
            }
        }
        else {
            die('passwordResetRequest query Problem : ' . mysqli_error($this->link));
        }
        return $message;
    }
    public function resetUserPassword($data)
    {
        $sql = "UPDATE users
              SET 
              user_password = $data[bd_no],
              pass_reset_request = NULL 
              WHERE bd_no='$data[bd_no]'";

        if (mysqli_multi_query($this->link, $sql)) {
            $message = "Data Updated Successfully!";
            return $message;
        } else {
            die('Pass Reset Request Action Query Problem : ' . mysqli_error($this->link));
        }
    }

        public function adminLogout(){
            session_destroy();
            /*unset($_SESSION['id']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_role']);
            unset($_SESSION['data_entry_id']);
            unset($_SESSION['bd_no']);
            unset($_SESSION['date_of_birth']);
            unset($_SESSION['trade']);
            unset($_SESSION['dataId']);
            unset($_SESSION['rank']);*/
            header('Location: index.php');
        }
    }
?>