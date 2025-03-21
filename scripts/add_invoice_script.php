<?php
session_start();
$connect = mysqli_connect('localhost', 'root', '', 'invoice_processing');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["invoice-photo-php"])) {
    $current_datetime = date('Y-m-d_H-i-s');

    $email = '';
    if(isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    } else {
        $email = $_POST['invoice-email-php'];
    }

    $target_dir = "../uploads/";
    $original_name = basename($_FILES["invoice-photo-php"]["name"]);
    $imageFileType = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
    
    $valid_extensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $valid_extensions)) {
        $_SESSION['invoice_error'] = 'File is not an image!';
        header("Location: ../add_invoice.php");
        exit(); 
    }

    $new_file_name = $current_datetime . '_' . $email . '_' . $original_name;
    $target_file = $target_dir . $new_file_name;
    
    move_uploaded_file($_FILES["invoice-photo-php"]["tmp_name"], $target_file);

    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $sql = "SELECT id FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];

        $sql = "INSERT INTO invoices (file_name, id_user, status) VALUES ('$new_file_name', $user_id, 'unprocessed')";
        $result = mysqli_query($connect, $sql);
    }

    header("Location: ../add_invoice.php");
}

mysqli_close($connect);
?>
