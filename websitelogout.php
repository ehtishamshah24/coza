<?php
include('query.php');

// session_unset();
unset($_SESSION['userEmail']);



echo "<script>location.assign('index.php')</script>"
?>