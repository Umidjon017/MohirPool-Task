<?php
include "common/app.php";
include "includes/header.php";
include "includes/navbar.php";
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h4>Register
                            <a href="<?=baseUrl('index.php')?>" class="btn btn-outline-secondary float-end"> Home </a>
                        </h4>
                    </div>
                    <form action="" method="post">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="">First Name</label>
                                <input type="text" name="FirstName" class="form-control" required/>
                            </div>
                            <div class="mb-3">
                                <label for="">Middle Name</label>
                                <input type="text" name="MiddleName" class="form-control" required/>
                            </div>
                            <div class="mb-3">
                                <label for="">Last Name</label>
                                <input type="text" name="LastName" class="form-control" required/>
                            </div>
                            <div class="mb-3">
                                <label for="">Email ID</label>
                                <input type="email" name="Email" class="form-control" required/>
                            </div>
                            <div class="mb-3">
                                <label for="">Password</label>
                                <input type="password" name="Password" class="form-control" required/>
                            </div>
                            <div class="mb-3">
                                <label for="">Confirm Password</label>
                                <input type="password" name="ConfirmPassword" class="form-control" required/>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="register_btn" class="btn btn-primary w-100"> Create </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include "includes/footer.php"; ?>