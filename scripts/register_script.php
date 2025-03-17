<?php
    $connect = mysqli_connect('localhost', 'root', '', 'invoice_processing');
    session_start(); 

    $email = $_POST['register-email-php'];
    $password = $_POST['register-password-php'];

    $hashedPassword = sha1($password);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($connect, $sql);

    if (mysqli_fetch_row($result) > 0) {
        $_SESSION['register_error'] = 'User already exists!';
        header("Location: ../register.php");
    } else {
        $sql2 = "INSERT INTO users (email, password) VALUES ('$email', '$hashedPassword')";
        $result2 = mysqli_query($connect, $sql2);
        header("Location: ../login.php");
    }

    mysqli_close($connect);
?>