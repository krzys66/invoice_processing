<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Invoices</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/form.css">
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php session_start(); include 'components/header.php'; ?>
    <main>
        <?php if(!isset($_SESSION['email'])):  ?>

        <p>You are not logged in. Please log in to see your invoices.</p>
        <p>If you didn't create your account yet, invoices will be send to your e-mail.</p>
        <button><a href="login.php">Login</a></button>
        
        <?php else: ?>
        
        <section class="bolded-text">
            <p>Invoices for <?php echo $_SESSION['email']; ?></p>
        </section>

        <section class="invoices">
        <?php 
            $connect = mysqli_connect('localhost', 'root', '', 'invoice_processing');

            $sql = 'SELECT invoices.id, file_name, json_file, status FROM invoices WHERE id_user = ' . $_SESSION['id'];
            $result = mysqli_query($connect, $sql);

            if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                echo '<div class="invoice">';

                if($row[3] == 'processed') {
                    echo "<p><a href='processed/" . basename($row[2]) . "' download>" . basename($row[2]) . "</a></p>";
                } else {
                    echo '<p>' . $row[1] . '</p>';
                }  

                if ($row[3] == 'processed') {
                    echo '<span class="status-icon"><i class="fas fa-check-circle" style="color: green;"></i></span>';
                } else {
                    echo '<span class="status-icon"><i class="fas fa-times-circle" style="color: red;"></i></span>';
                }

                echo '<span class="delete-icon"><i class="fas fa-trash-alt" style="color: red; cursor: pointer;" onclick="deleteInvoice(' . $row[0] . ')"></i></span>';


                echo '</div>';
                }
            } else {
                echo '<p>No invoices found.</p>';
            }
            mysqli_close($connect);
            ?>
        </section>
        
        <?php endif; ?>
    </main>
    <?php include 'components/footer.php'; ?>
</body>
<script>
    function deleteInvoice(id) {
        window.location.href = 'scripts/delete_invoice_script.php?id=' + id;
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".invoice p").forEach(el => {
            el.setAttribute("title", el.innerText);
        });
    });

</script>
</html>