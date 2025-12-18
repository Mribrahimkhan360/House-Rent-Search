<?php
session_start();
include '../db.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_email'] = $user['email'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = 'Invalid email or password!';
        }
    } else {
        $error = 'Invalid email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - House Rent Search</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <h1>🏠 House Rent Search - Admin</h1>
            <nav>
                <a href="../index.php">← Back to Home</a>
            </nav>
        </div>
    </header>

    <!-- Login Form -->
    <div class="login-container">
        <h2>🔐 Admin Login</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required 
                       placeholder="admin@houserent.com">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required 
                       placeholder="Enter your password">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
                Login
            </button>
        </form>

        <div style="margin-top: 20px; text-align: center; color: #666; font-size: 13px;">
            <p><strong>Demo Credentials:</strong></p>
            <p>Email: admin1@houserent.com</p>
            <p>Password: admin123</p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 House Rent Search. All rights reserved.</p>
    </footer>
</body>
</html>

<?php mysqli_close($conn); ?>