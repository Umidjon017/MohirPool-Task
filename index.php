<?php
session_start();

// Retrieve session data
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Include and utilize Json class
require "controllers/StudentController.php";
$undergraduate_students = new StudentController('json_files/under_students.json');
$postgraduate_students = new StudentController('json_files/post_students.json');

// Fetch the student's data
$under_students = $undergraduate_students->getUnderRows();
$post_students = $postgraduate_students->getPostRows();

// Get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

if (isset($_POST['under_search']))
{
    $under_search = $undergraduate_students->searchUnderSingle($_POST['under_search_value']);
}

if (isset($_POST['post_search']))
{
    $post_search = $postgraduate_students->searchPostSingle($_POST['post_search_value']);
}

include "common/app.php";
include "includes/header.php";
include "includes/navbar.php";
?>

<div class="container">
    <h1 class="text-center mt-2 mb-5">'X University' Students CRUD</h1>

    <!-- Display status message -->
    <?php if(!empty($statusMsg) && ($statusMsgType == 'success')): ?>
        <div class="alert alert-success"><?= $statusMsg; ?></div>
    <?php elseif(!empty($statusMsg) && ($statusMsgType == 'error')): ?>
        <div class="alert alert-danger"><?= $statusMsg; ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12 head">
            <h5>Undergraduate Students
                <a href="views/under-student-add.php" class="btn btn-success float-end"><i class="plus"></i> New Student </a>
            </h5>
        </div>

        <form action="" method="post">
            <input type="number" class="form-control" placeholder="Search students by ID then press ENTER" name="under_search_value">
            <input type="submit" class="btn btn-outline-success" value="Search..." name="under_search">
        </form>

        <!-- Search the students -->
        <table class="table table-success table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>FirstName</th>
                    <th>MiddleName</th>
                    <th>LastName</th>
                    <th>Gender</th>
                    <th>Nationality</th>
                    <th>Faculty</th>
                    <th>AdmissionYear</th>
                    <th>ResidentialHall</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($_POST['under_search_value'])) { foreach($under_search as $row){ ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['FirstName']; ?></td>
                    <td><?= $row['MiddleName']; ?></td>
                    <td><?= $row['LastName']; ?></td>
                    <td><?= $row['Gender']; ?></td>
                    <td><?= $row['Nationality']; ?></td>
                    <td><?= $row['Faculty']; ?></td>
                    <td><?= $row['AdmissionYear']; ?></td>
                    <td><?= $row['ResidentialHall']; ?></td>
                    <td>
                        <a href="views/under-student-add.php?id=<?= $row['id']; ?>" class="btn btn-warning">edit</a>
                        <a href="controllers/UnderStudentAction.php?action_type=delete&id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">delete</a>
                    </td>
                </tr>
            <?php } }else{ ?>
                <tr><td colspan="10">No students found...</td></tr>
            <?php } ?>
            </tbody>
        </table>

        <hr>

        <!-- List the students -->
        <table class="table table-success table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>FirstName</th>
                <th>MiddleName</th>
                <th>LastName</th>
                <th>Gender</th>
                <th>Nationality</th>
                <th>Faculty</th>
                <th>AdmissionYear</th>
                <th>ResidentialHall</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($under_students)) { foreach($under_students as $row){ ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['FirstName']; ?></td>
                    <td><?= $row['MiddleName']; ?></td>
                    <td><?= $row['LastName']; ?></td>
                    <td><?= $row['Gender']; ?></td>
                    <td><?= $row['Nationality']; ?></td>
                    <td><?= $row['Faculty']; ?></td>
                    <td><?= $row['AdmissionYear']; ?></td>
                    <td><?= $row['ResidentialHall']; ?></td>
                    <td>
                        <a href="views/under-student-add.php?id=<?= $row['id']; ?>" class="btn btn-warning">edit</a>
                        <a href="controllers/UnderStudentAction.php?action_type=delete&id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">delete</a>
                    </td>
                </tr>
            <?php } }else{ ?>
                <tr><td colspan="10">No students found...</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 head">
            <h5>Postgraduate Students
                <a href="views/post-student-add.php" class="btn btn-success float-end"><i class="plus"></i> New Student </a>
            </h5>
        </div>

        <form action="" method="post">
            <input type="number" class="form-control" placeholder="Search students by ID then press ENTER" name="post_search_value">
            <input type="submit" class="btn btn-outline-success" value="Search..." name="post_search">
        </form>

        <!-- Search the students -->
        <table class="table table-danger table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>FirstName</th>
                <th>MiddleName</th>
                <th>LastName</th>
                <th>Gender</th>
                <th>Nationality</th>
                <th>Faculty</th>
                <th>AdmissionYear</th>
                <th>SupervisorName</th>
                <th>ResearchTopic</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($_POST['post_search_value'])) { foreach($post_search as $row){ ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['FirstName']; ?></td>
                    <td><?= $row['MiddleName']; ?></td>
                    <td><?= $row['LastName']; ?></td>
                    <td><?= $row['Gender']; ?></td>
                    <td><?= $row['Nationality']; ?></td>
                    <td><?= $row['Faculty']; ?></td>
                    <td><?= $row['AdmissionYear']; ?></td>
                    <td><?= $row['SupervisorName']; ?></td>
                    <td><?= $row['ResearchTopic']; ?></td>
                    <td>
                        <a href="views/under-student-add.php?id=<?= $row['id']; ?>" class="btn btn-warning">edit</a>
                        <a href="controllers/UnderStudentAction.php?action_type=delete&id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">delete</a>
                    </td>
                </tr>
            <?php } }else{ ?>
                <tr><td colspan="11">No students found...</td></tr>
            <?php } ?>
            </tbody>
        </table>

        <hr>

        <!-- List the students -->
        <table class="table table-danger table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>FirstName</th>
                <th>MiddleName</th>
                <th>LastName</th>
                <th>Gender</th>
                <th>Nationality</th>
                <th>Faculty</th>
                <th>AdmissionYear</th>
                <th>SupervisorName</th>
                <th>ResearchTopic</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($post_students)) { foreach($post_students as $row){ ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['FirstName']; ?></td>
                    <td><?= $row['MiddleName']; ?></td>
                    <td><?= $row['LastName']; ?></td>
                    <td><?= $row['Gender']; ?></td>
                    <td><?= $row['Nationality']; ?></td>
                    <td><?= $row['Faculty']; ?></td>
                    <td><?= $row['AdmissionYear']; ?></td>
                    <td><?= $row['SupervisorName']; ?></td>
                    <td><?= $row['ResearchTopic']; ?></td>
                    <td>
                        <a href="views/post-student-add.php?id=<?= $row['id']; ?>" class="btn btn-warning">edit</a>
                        <a href="controllers/PostStudentAction.php?action_type=delete&id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">delete</a>
                    </td>
                </tr>
            <?php } }else{ ?>
                <tr><td colspan="11">No students found...</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<?php include "includes/footer.php"; ?>