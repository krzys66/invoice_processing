<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add invoice</title>
    <link rel="stylesheet" href="styles/filebox.css">
    <link rel="stylesheet" href="styles/form.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/loading.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php session_start(); include 'components/header.php'; ?>
    <main>
        <section id="form">
            <form action="scripts/add_invoice_script.php" method="post" id="invoice-form" enctype="multipart/form-data" >
                <label for="invoice-photo-php">Upload Photo of Invoice:</label>
                <div class="upload-box">
                    <label for="invoice-photo-php" class="upload-label">
                        <p>Browse Files</p>
                        <p class="sub-text">Drag and drop files here</p>
                        <p class="sub-text-phone">Take a photo of invoice</p>
                        <input name="invoice-photo-php" required type="file" id="invoice-photo" />
                    </label>
                    <p id="file-name"></p>
                </div>

                <?php if(!isset($_SESSION['email'])): ?>

                <label for="invoice-email-php">Your Email:</label>
                <input type="email" id="invoice-email" name="invoice-email-php" required placeholder="Enter your email">

                <?php else: ?>

                <label for="invoice-email-php">Your Email:</label>
                <input type="email" id="invoice-email" name="invoice-email-php" required placeholder="Enter your email" value="<?php echo $_SESSION['email']; ?>" readonly>

                <?php endif; ?>

                <button type="button" onclick="submitProcessing(event)">Process Invoice</button>
            
                <div class="loading-block">
                    <p class="message-text">Successfully uploaded!</p>
                    <div class="preloader"></div>
                </div>

                <?php
                if (isset($_SESSION['invoice_error'])) {
                    echo "<p class='error' style='display: block; color: red;'>" . $_SESSION['invoice_error'] . '</p>';
                    unset($_SESSION['invoice_error']);
                }
                ?>
            </form>

        </section>
    </main>
    <?php include 'components/footer.php'; ?>
</body>
<script>
    document.getElementById("invoice-photo").addEventListener("change", function () {
        const fileName = this.files[0] ? this.files[0].name : "";
        document.getElementById("file-name").innerHTML = fileName;
    });

    function submitProcessing(event) {
        let loadingBlock = document.querySelector('.loading-block');
        let messageText = document.querySelector('.message-text');
        let preloader = document.querySelector('.preloader');

        let formSection = document.getElementById('invoice-form');

        const fileInput = document.getElementById('invoice-photo');
           
        if (!fileInput.files.length) {
            loadingBlock.style.display = 'flex';
            messageText.style.color = 'red';
            messageText.innerHTML = 'Please select a file to upload.';
            preloader.style.display = 'none';
            setTimeout(() => {
                loadingBlock.style.display = 'none';
                messageText.style.color = 'green';
                messageText.innerHTML = 'Successfully uploaded!';
                preloader.style.display = 'block';
            }, 2000);
            return;
        }

        <?php if(!isset($_SESSION['email'])): ?>

        const emailInput = document.getElementById('invoice-email'); 

        if (!emailInput.value && !emailInput.checkValidity()) {
            loadingBlock.style.display = 'flex';
            messageText.style.color = 'red';
            messageText.innerHTML = 'Please enter a valid email address.';
            preloader.style.display = 'none';
            setTimeout(() => {
                loadingBlock.style.display = 'none';
                messageText.style.color = 'green';
                messageText.innerHTML = 'Successfully uploaded!';
                preloader.style.display = 'block';
            }, 2000);
            return;
        }

        <?php endif; ?>

        event.preventDefault();

        loadingBlock.style.display = 'flex';

        setTimeout(() => {
            document.getElementById('invoice-form').submit();
        }, 2000);
    }
</script>
</html>
