<link rel="stylesheet" href="styles/header.css">
<header>
    <h1 class="header-title">Invoice Processing</h1>

    <button class="menu-toggle" id="menuToggle">☰</button>

    <div class="dropdown-container">
        <div class="dropdown">
            <button class="dropdown-button">Your invoices</button>
            <div class="dropdown-content">
                <a href="your_invoices.php">View Invoices</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropdown-button">Add Invoice</button>
            <div class="dropdown-content">
                <a href="add_invoice.php">Upload Invoice</a>
            </div>
        </div>
        <?php if (isset($_SESSION['email'])): ?>
            <div class="dropdown">
                <button class="dropdown-button"><?php echo $_SESSION['email']; ?></button>
                <div class="dropdown-content">
                    <a href="profile.php">Profile</a>
                    <a href="scripts/logout_script.php">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <div class="dropdown">
                <button class="dropdown-button">Login</button>
                <div class="dropdown-content">
                    <a href="login.php">Login</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropdown-button">Register</button>
                <div class="dropdown-content">
                    <a href="register.php">Register</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</header>

<div class="mobile-menu" id="mobileMenu">
    <button class="close-menu" id="closeMenu">✖</button>
    <a href="your_invoices.php">Your invoices</a>
    <a href="add_invoice.php">Add Invoice</a>
    
    <?php if (isset($_SESSION['email'])): ?>
        <a href="profile.php">Profile</a>
        <a href="scripts/logout_script.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const menuToggle = document.getElementById("menuToggle");
        const mobileMenu = document.getElementById("mobileMenu");
        const closeMenu = document.getElementById("closeMenu");

        menuToggle.addEventListener("click", () => {
            mobileMenu.classList.toggle("open");
        });

        closeMenu.addEventListener("click", () => {
            mobileMenu.classList.remove("open");
        });
    });
</script>

