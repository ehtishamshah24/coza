<?php
session_start();
include('AdminPanel/dbcon.php');

if (isset($_POST['signIn'])) {
    $useremail = $_POST['userEmail'];
    $userpassword = $_POST['userPassword'];
    $query = $pdo->prepare("SELECT * FROM user WHERE email = :uemail AND password = :upassword");
    $query->bindParam(':uemail', $useremail);
    $query->bindParam(':upassword', $userpassword);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user['role_id'] == 1) {
            $_SESSION['AdEmail'] = $user['email'];
            $_SESSION['AdName'] = $user['name'];
            echo "<script>alert('Login successfully'); location.assign('AdminPanel/index.php')</script>";
        } 
        else if ($user['role_id'] == 2) {
            $_SESSION['userId'] = $user['id'];
            $_SESSION['userEmail'] = $user['email'];
            $_SESSION['userName'] = $user['name'];
            echo "<script>alert('Login successfully'); location.assign('index.php')</script>";
        } 
        else if ($user['role_id'] == 3) {
            $_SESSION['Manager'] = $user['email'];
            echo "<script>alert('Login successfully'); location.assign('vieproduct.php')</script>";
        }
    } 
        else {
           echo "<script>alert('Invalid credentials'); location.assign('signin.php')</script>";
    }
}

//   Signup

if(isset($_POST['signUp'])){
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];
    $query = $pdo->prepare('INSERT INTO user ( email, password) VALUES( :uEmail, :uPassword)');
    $query->bindParam('uEmail', $userEmail);
    $query->bindParam('uPassword', $userPassword);
    $query->execute();
    echo "<script>alert('Signup Successfully');
    location.assign('index.php')</script>";
}
?>