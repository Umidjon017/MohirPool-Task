<?php

include "../common/app.php";

// Start session
session_start();

// Include and initialize DB class
require_once 'StudentController.php';
$undergraduate_students = new StudentController('../json_files/under_students.json');

if(isset($_POST['add_under_btn']))
{
    // Get form fields value
    $id = $_POST['id'];
    $FirstName = trim(strip_tags($_POST['FirstName']));
    $MiddleName = trim(strip_tags($_POST['MiddleName']));
    $LastName = trim(strip_tags($_POST['LastName']));
    $Gender = trim(strip_tags($_POST['Gender']));
    $Nationality = trim(strip_tags($_POST['Nationality']));
    $Faculty = trim(strip_tags($_POST['Faculty']));
    $AdmissionYear = trim(strip_tags($_POST['AdmissionYear']));
    $ResidentialHall = trim(strip_tags($_POST['ResidentialHall']));

    $id_str = '';
    if(!empty($id)){
        $id_str = '?id='.$id;
    }

    // Fields validation
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

    // Submitted form data
    $underStudentData = array(
        'FirstName' => $FirstName,
        'MiddleName' => $MiddleName,
        'LastName' => $LastName,
        'Gender' => $Gender,
        'Nationality' => $Nationality,
        'Faculty' => $Faculty,
        'AdmissionYear' => $AdmissionYear,
        'ResidentialHall' => $ResidentialHall,
    );

    // Store the submitted field value in the session
    $sessData['underStudentData'] = $underStudentData;

    // Submit the form data
    if(empty($errorMsg))
    {
        if(!empty($_POST['id']))
        {
            // Update student data
            $update = $undergraduate_students->updateUnder($underStudentData, $_POST['id']);

            if(!$update)
            {
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'Undergraduate Student data has been updated successfully.';

                // Remove submitted fields value from session
                unset($sessData['underStudentData']);
            }
            else {
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred while update, please try again.';

                // Set redirect url
                redirectUrl('../views/under-student-add.php'.$id_str);
            }
        }
        else {
            // Insert student data
            $insert = $undergraduate_students->insertUnder($underStudentData);

            if(!$insert)
            {
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'Undergraduate Student data has been added successfully.';

                // Remove submitted fields value from session
                unset($sessData['underStudentData']);
            }
            else {
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred while inserting, please try again.';

                // Set redirect url
                redirectUrl('../views/under-student-add.php'.$id_str);
            }
        }
    }
    else {
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = '<p>Please fill all the mandatory fields.</p>'.$errorMsg;

        // Set redirect url
        redirectUrl('../views/under-student-add.php'.$id_str);
    }

    // Store status into the session
    $_SESSION['sessData'] = $sessData;
}
elseif(($_REQUEST['action_type'] == 'delete') && !empty($_GET['id']))
{
    // Delete data
    $delete = $undergraduate_students->deleteUnder($_GET['id']);

    if(!$delete){
        $sessData['status']['type'] = 'success';
        $sessData['status']['msg'] = 'Undergraduate Student data has been deleted successfully.';
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Some problem occurred while deleting, please try again.';
    }

    // Store status into the session
    $_SESSION['sessData'] = $sessData;
}

// Redirect to the respective page
redirectUrl('index.php');
exit();
?>