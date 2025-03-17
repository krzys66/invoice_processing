<?php
    session_start();
    $connect = mysqli_connect('localhost', 'root', '', 'invoice_processing');
    
    $email = $_POST['login-email-php'];
    $password = $_POST['login-password-php'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (sha1($password) == $row['password']) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $email;

            header("Location: ../add_invoice.php");
        } else {
            $_SESSION['login_error'] = 'Wrong password!';
            header("Location: ../login.php");
        }
    } else {
            $_SESSION['login_error'] = 'User does not exist!';
            header("Location: ../login.php");
    }

    mysqli_close($connect);
?>