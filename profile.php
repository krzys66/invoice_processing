<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/overlay.css">
</head>
<body>
    <?php session_start(); include 'components/header.php'; ?>
    <main>
        <section class='bolded-text'>
                <p> <?php echo $_SESSION['email']; ?> </p>
        </section>
        
        <?php
            $connect = mysqli_connect('localhost', 'root', '', 'invoice_processing');

            $sql = 'SELECT create_date FROM users WHERE email = "' . $_SESSION['email'] . '"';
            $result = mysqli_query($connect, $sql);
            $row = mysqli_fetch_array($result);
            $create_date = $row[0];                     
            $sql2 = 'SELECT COUNT(*) FROM invoices INNER JOIN users ON invoices.id_user = users.id WHERE email = "' . $_SESSION['email'] . '"';
            $result2 = mysqli_query($connect, $sql2);
            $row2 = mysqli_fetch_array($result2);
            $invoice_count = $row2[0];

            echo "<section style='font-weight: normal;' class='bolded-text'>";
            echo "<p>Account created: $create_date</p>";
            if($invoice_count == 0) {
                echo "<p><a href='add_invoice.php'>Upload your first invoice!</a></p>";
            } else if($invoice_count == 1) {
                echo "<p>You have <b> $invoice_count </b> invoice</p>";
            } else {
                echo "<p>You have <b> $invoice_count </b> invoices</p>";
            }
            
            echo "</section>";
        ?>

        <button class='delete-button' onclick='showOverlay()' >Delete account</button>
    </main>
    <?php include 'components/footer.php'; ?>

    <div id='overlay-delete-account' class="overlay">
        <div class="overlay-content">
            <p>Are you sure you want to delete your account? (All invoices will be lost)</p>
            <button onclick="confirmDelete()">Yes</button>
            <button onclick="hideOverlay()">No</button>
        </div>
    </div>
</body>
<script>
    function showOverlay() {
        document.getElementById('overlay-delete-account').style.display = 'flex';
    }

    function hideOverlay() {
        document.getElementById('overlay-delete-account').style.display = 'none';
    }

    function confirmDelete() {
        window.location.href = 'scripts/delete_account_script.php';
    }
</script>
</html>