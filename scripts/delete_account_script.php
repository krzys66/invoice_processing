<?php
session_start();
$connect = mysqli_connect('localhost', 'root', '', 'invoice_processing');

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $sql = "DELETE FROM invoices WHERE id_user = (SELECT id FROM users WHERE email='$email')";
    $result = mysqli_query($connect, $sql);

    $sql = "DELETE FROM users WHERE email='$email'";
    $result = mysqli_query($connect, $sql);

    session_unset();
    session_destroy();

    header("Location: ../add_invoice.php");
    exit();
}

mysqli_close($connect);
?>

