<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/form.css">
    <link rel="stylesheet" href="styles/loading.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php session_start(); include 'components/header.php'; ?>
    <main>
        <form action="scripts/register_script.php" id="register-form" method="post">
            <label for="register-email-php">Email:</label>
            <input type="email" style="width: 100%" id="register-email" name="register-email-php" required placeholder="Enter your email">
            
            <label for="register-password-php">Password:</label>
            <input type="password" id="register-password" name="register-password-php" required placeholder="Enter your password">

            <label for="register-repeat-php">Password:</label>
            <input type="password" id="register-repeat" name="register-repeat-php" required placeholder="Repeat your password">
            
            <button type="button" onclick="register()">Register</button>
            
            <div class="loading-block">
                <p class="message-text">Registering...</p>
                <div class="preloader"></div>
            </div>
            <?php
                if (isset($_SESSION['register_error'])) {
                    echo "<p class='error' style='display: block; color: red;'>" . $_SESSION['register_error'] . '</p>';
                    unset($_SESSION['register_error']);
                }
            ?>
        </form>
    </main>
    <?php include 'components/footer.php'; ?>
</body>
<script>
    function register() {
        let loadingBlock = document.querySelector('.loading-block');
        let messageText = document.querySelector('.message-text');
        let preloader = document.querySelector('.preloader');
        let error = document.querySelector('.error');
        
        const emailInput = document.getElementById('register-email');
        const passwordInput = document.getElementById('register-password');
        const repeatInput = document.getElementById('register-repeat');

        if (error) {
            error.style.display = 'none';
        }

        if (!emailInput.value || !emailInput.checkValidity()) {
            loadingBlock.style.display = 'flex';
            messageText.style.color = 'red';
            messageText.innerHTML = 'Please enter a valid e-mail address.';
            preloader.style.display = 'none';
            setTimeout(() => {
                loadingBlock.style.display = 'none';
                messageText.style.color = 'green';
                messageText.innerHTML = 'Registering...';
                preloader.style.display = 'block';
            }, 2000);
            return;
        }
        if (!passwordInput.value) {
            loadingBlock.style.display = 'flex';
            messageText.style.color = 'red';
            messageText.innerHTML = 'Please enter a password.';
            preloader.style.display = 'none';
            setTimeout(() => {
                loadingBlock.style.display = 'none';
                messageText.style.color = 'green';
                messageText.innerHTML = 'Registering...';
                preloader.style.display = 'block';
            }, 2000);
            return;
        }
        if (passwordInput.value !== repeatInput.value) {
            loadingBlock.style.display = 'flex';
            messageText.style.color = 'red';
            messageText.innerHTML = 'Passwords do not match.';
            preloader.style.display = 'none';
            setTimeout(() => {
                loadingBlock.style.display = 'none';
                messageText.style.color = 'green';
                messageText.innerHTML = 'Registering...';
                preloader.style.display = 'block';
            }, 2000);
            return; 
        }
        
        event.preventDefault();

        loadingBlock.style.display = 'flex';

        setTimeout(() => {
            document.getElementById('register-form').submit();
        }, 2000);
    }
</script>
</html>