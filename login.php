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
                        <h4> Login
                            <a href="<?=baseUrl('index.php')?>" class="btn btn-outline-secondary float-end"> Home </a>
                        </h4>
                    </div>
                    <form action="" method="post">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="">Email ID</label>
                                <input type="email" name="email" class="form-control" required/>
                            </div>
                            <div class="mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" required/>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="login_btn" class="btn btn-primary w-100"> Enter </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include "includes/footer.php"; ?>
