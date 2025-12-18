<?php
session_start();
include '../db.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if email already exists
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Email already registered!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $sql = "INSERT INTO users (email, password) 
                    VALUES ('$email', '$hashed_password')";

            if (mysqli_query($conn, $sql)) {
                $success = "Registration successful! You can login now.";
            } else {
                $error = "Something went wrong. Try again!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - House Rent Search</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header>
    <div class="container">
        <h1>🏠 House Rent Search - Admin</h1>
        <nav>
            <a href="login.php">← Back to Login</a>
        </nav>
    </div>
</header>

<div class="login-container">
    <h2>📝 Admin Registration</h2>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" required placeholder="admin@houserent.com">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required placeholder="Enter password">
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required placeholder="Confirm password">
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%; margin-top:10px;">
            Register
        </button>
    </form>

    <p style="margin-top:15px; text-align:center; font-size:13px;">
        Already have an account?  
        <a href="login.php">Login here</a>
    </p>
</div>

<footer>
    <p>&copy; 2024 House Rent Search. All rights reserved.</p>
</footer>

</body>
</html>

<?php mysqli_close($conn); ?>
