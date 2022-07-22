<?php

include "../common/app.php";

session_start();

// Retrieve session data
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Get student data
$postgraduate_students_data = $post_students_data = array();
if(!empty($_GET['id'])){
    // Include and initialize JSON class
    include "../controllers/StudentController.php";
    $students = new StudentController('../json_files/post_students.json');

    // Fetch the student data
    $postgraduate_students_data = $students->getPostSingle($_GET['id']);
}

$post_students_data = !empty($sessData['postStudentData']) ? $sessData['postStudentData'] : $postgraduate_students_data;
unset($_SESSION['sessData']['postStudentData']);

$actionLabel = !empty($_GET['id']) ? 'Edit' : 'Add';

// Get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--  Bootstrap CSS CDN  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <title>CRUD in PHP using JSON</title>
</head>
<body>

<div class="container">
    <h1>CRUD in PHP using JSON</h1>

    <!-- Display status message -->
    <?php if(!empty($statusMsg) && ($statusMsgType == 'success')): ?>
        <div class="alert alert-success"><?= $statusMsg; ?></div>
    <?php elseif(!empty($statusMsg) && ($statusMsgType == 'error')): ?>
        <div class="alert alert-danger"><?= $statusMsg; ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <h2><?= $actionLabel; ?> Postgraduate Student</h2>
        </div>
        <div class="col-md-6">
            <form method="post" action="../controllers/PostStudentAction.php">
                <div class="form-group">
                    <label>FirstName</label>
                    <input type="text" class="form-control" name="FirstName" value="<?= !empty($post_students_data['FirstName']) ? $post_students_data['FirstName'] : ''; ?>" required="">
                </div>
                <div class="form-group">
                    <label>MiddleName</label>
                    <input type="text" class="form-control" name="MiddleName" value="<?= !empty($post_students_data['MiddleName']) ? $post_students_data['MiddleName'] : ''; ?>" required="">
                </div>
                <div class="form-group">
                    <label>LastName</label>
                    <input type="text" class="form-control" name="LastName" value="<?= !empty($post_students_data['LastName']) ? $post_students_data['LastName'] : ''; ?>" required="">
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <input type="text" class="form-control" name="Gender" value="<?= !empty($post_students_data['Gender']) ? $post_students_data['Gender'] : ''; ?>" required="">
                </div>
                <div class="form-group">
                    <label>Nationality</label>
                    <input type="text" class="form-control" name="Nationality" value="<?= !empty($post_students_data['Nationality']) ? $post_students_data['Nationality'] : ''; ?>" required="">
                </div>
                <div class="form-group">
                    <label>Faculty</label>
                    <input type="text" class="form-control" name="Faculty" value="<?= !empty($post_students_data['Faculty']) ? $post_students_data['Faculty'] : ''; ?>" required="">
                </div>
                <div class="form-group">
                    <label>AdmissionYear</label>
                    <input type="text" class="form-control" name="AdmissionYear" value="<?= !empty($post_students_data['AdmissionYear']) ? $post_students_data['AdmissionYear'] : ''; ?>" required="">
                </div>
                <div class="form-group">
                    <label>SupervisorName</label>
                    <input type="text" class="form-control" name="SupervisorName" value="<?= !empty($post_students_data['SupervisorName']) ? $post_students_data['SupervisorName'] : ''; ?>" required="">
                </div>
                <div class="form-group">
                    <label>ResearchTopic</label>
                    <input type="text" class="form-control" name="ResearchTopic" value="<?= !empty($post_students_data['ResearchTopic']) ? $post_students_data['ResearchTopic'] : ''; ?>" required="">
                </div>

                <a href="<?=baseUrl('index.php')?>" class="btn btn-secondary"> Home </a>
                <input type="hidden" name="id" value="<?= !empty($postgraduate_students_data['id']) ? $postgraduate_students_data['id'] : ''; ?>">
                <input type="submit" name="add_post_btn" class="btn btn-success" value="Submit">
            </form>
        </div>
    </div>
</div>

<!--  Bootstrap JS CDN  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>
</html>
