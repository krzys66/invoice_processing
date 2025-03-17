<?php
    session_start();
    $connect = mysqli_connect('localhost', 'root', '', 'invoice_processing');

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT file_name, json_file FROM invoices WHERE id = $id AND id_user = " . $_SESSION['id'];
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $file_path = '../uploads/' . $row['file_name'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            $file_path_json = '../processed/' . $row['json_file'];
            if (file_exists($file_path_json)) {
                unlink($file_path_json);
            }

            $sql = "DELETE FROM invoices WHERE id = $id AND id_user = " . $_SESSION['id'];
            $result = mysqli_query($connect, $sql);

            header("Location: ../your_invoices.php");
        }
    }

    mysqli_close($connect);
?>
