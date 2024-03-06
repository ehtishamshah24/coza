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
                        <button type="submit" class="btn btn-primary w-100 py-3  mb-4" name="signIn">Sign In</button>
                        <p class="text-center mb-5">Don't have an Account? <a href="signup.php">Sign Up</a></p>
            </form>
        </div>
    </div>
</div>



<?php 
include('footer.php');
?>