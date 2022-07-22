<?php

include "../common/app.php";

// Start session
session_start();

// Include and initialize DB class
require_once 'RegistrationController.php';
$users = new RegistrationController('../json_files/registration.json');

if(isset($_POST['register_btn']))
{
    $id = $_POST['id'];
    $FirstName = trim(strip_tags($_POST['FirstName']));
    $MiddleName = trim(strip_tags($_POST['MiddleName']));
    $LastName = trim(strip_tags($_POST['LastName']));
    $Email = trim(strip_tags($_POST['Email']));
    $Password = trim(strip_tags($_POST['Password']));
    $ConfirmPassword = trim(strip_tags($_POST['ConfirmPassword']));

    $result_password = $users->confirmPassword($Password, $ConfirmPassword);

    $id_str = '';
    if(!empty($id)){
        $id_str = '?id='.$id;
    }

    $errorMsg = '';
    if(empty($FirstName)){
        $errorMsg .= '<p>Please enter your first name.</p>';
    }
    if(empty($MiddleName)){
        $errorMsg .= '<p>Please enter your middle name.</p>';
    }
    if(empty($LastName)){
        $errorMsg .= '<p>Please enter your last name.</p>';
    }
    if(empty($Gender)){
        $errorMsg .= '<p>Please enter your gender.</p>';
    }
    if(empty($Nationality)){
        $errorMsg .= '<p>Please enter your nationality.</p>';
    }
    if(empty($Faculty)){
        $errorMsg .= '<p>Please enter your faculty.</p>';
    }
    if(empty($AdmissionYear)){
        $errorMsg .= '<p>Please enter your admission year.</p>';
    }
    if(empty($ResidentialHall)){
        $errorMsg .= '<p>Please enter your residential hall.</p>';
    }

    $registerData = array(
        'FirstName' => $FirstName,
        'MiddleName' => $MiddleName,
        'LastName' => $LastName,
        'Email' => $Email,
        'Password' => $Password,
    );

    $sessData['registerData'] = $registerData;

    if(empty($errorMsg))
    {
        if(!empty($_POST['id']))
        {
            $update = $users->update($registerData, $_POST['id']);

            if(!$update)
            {
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'User data has been updated successfully.';

                unset($sessData['registerData']);
            }
            else {
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred while update, please try again.';

                redirectUrl('../registration.php'.$id_str);
            }
        }
        else {
            $insert = $users->insert($registerData);

            if(!$insert)
            {
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'User data has been added successfully.';

                unset($sessData['registerData']);
            }
            else {
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred while inserting, please try again.';

                redirectUrl('../registration.php'.$id_str);
            }
        }
    }
    else {
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = '<p>Please fill all the mandatory fields.</p>'.$errorMsg;

        redirectUrl('../views/registration.php'.$id_str);
    }

    $_SESSION['sessData'] = $sessData;
}

redirectUrl('index.php');
exit();
?>