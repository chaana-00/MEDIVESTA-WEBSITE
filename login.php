<?php
session_start();

/* HARD-CODED ADMIN CREDENTIALS */
$admin_username = "admin";
$admin_password = "V@69farm"; // change this

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_username && $password === $admin_password) {

        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $admin_username;

        header("Location: admin-dashboard.php");
        exit();
    } else {
        echo "<script>
                alert('Invalid admin credentials');
                window.location='index.html';
              </script>";
    }
}
?>
