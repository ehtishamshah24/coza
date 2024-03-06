<?php 
include('query.php');
include('header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mt-5">
            <form action="" method="post">
                <div class="form-group">
                  <label for="">Email</label>
                  <input type="text" name="userEmail" id="" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                  <label for="">Password</label>
                  <input type="text" name="userPassword" id="" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
                <a href="">Forgot Password</a>
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4" name="signUp">Sign Up</button>
                        <p class="text-center mb-5">Already have an Account? <a href="signin.php">Sign In</a></p>
            </form>
        </div>
    </div>
</div>



<?php 
include('footer.php');
?>