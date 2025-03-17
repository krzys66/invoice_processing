<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <form action="scripts/login_script.php" id="login-form" method="post">
            <label for="login-email-php">Email:</label>
            <input type="email" style="width: 100%" id="login-email" name="login-email-php" required placeholder="Enter your email">
            
            <label for="login-password-php">Password:</label>
            <input type="password" id="login-password" name="login-password-php" required placeholder="Enter your password">
            
            <button type="button" onclick="login()">Login</button>
            
            <div class="loading-block">
                <p class="message-text">Logging</p>
                <div class="preloader"></div>
            </div>

            <?php
                if (isset($_SESSION['login_error'])) {
                    echo "<p class='error' style='display: block; color: red;'>" . $_SESSION['login_error'] . '</p>';
                    unset($_SESSION['login_error']);
                }
            ?>
        </form>
    </main>
    <?php include 'components/footer.php'; ?>
</body>
<script>
    function login() {
        let loadingBlock = document.querySelector('.loading-block');
        let messageText = document.querySelector('.message-text');
        let preloader = document.querySelector('.preloader');
        let error = document.querySelector('.error');

        const emailInput = document.getElementById('login-email');
        const passwordInput = document.getElementById('login-password');

        if(error) {
            error.style.display = 'none';
        }

        if (!emailInput.value && !emailInput.checkValidity()) {
            loadingBlock.style.display = 'flex';
            messageText.style.color = 'red';
            messageText.innerHTML = 'Please enter a valid e-mail address.';
            preloader.style.display = 'none';
            setTimeout(() => {
                loadingBlock.style.display = 'none';
                messageText.style.color = 'green';
                messageText.innerHTML = 'Logging...';
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
                messageText.innerHTML = 'Logging...';
                preloader.style.display = 'block';
            }, 2000);
            return;
        }
        event.preventDefault();

        loadingBlock.style.display = 'flex';

        setTimeout(() => {
            document.getElementById('login-form').submit();
        }, 2000);
    }
</script>
</html>