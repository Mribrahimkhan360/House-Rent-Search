<?php
session_start();
include '../db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $rent = mysqli_real_escape_string($conn, $_POST['rent']);
    $rooms = intval($_POST['rooms']);
    $bathrooms = intval($_POST['bathrooms']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);

    // Handle image upload
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = $_FILES['image']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_name = 'house_' . time() . '.' . $file_extension;
            $upload_path = '../uploads/house-images/' . $image_name;
            
            // Create directory if not exists
            if (!file_exists('../uploads/house-images/')) {
                mkdir('../uploads/house-images/', 0777, true);
            }
            
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $error = 'Failed to upload image!';
            }
        } else {
            $error = 'Invalid image type. Only JPG, PNG, GIF allowed.';
        }
    }

    // Insert into database if no errors
    if (empty($error)) {
        $sql = "INSERT INTO houses (title, location, rent, rooms, bathrooms, description, image, contact_number) 
                VALUES ('$title', '$location', '$rent', $rooms, $bathrooms, '$description', '$image_name', '$contact_number')";
        
        if (mysqli_query($conn, $sql)) {
            $success = 'House added successfully!';
            // Reset form
            $_POST = array();
        } else {
            $error = 'Database error: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New House - Admin</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <h1>🏠 Admin Dashboard</h1>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="add-house.php">Add New House</a>
                <a href="../index.php">View Site</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="admin-container">
        <div class="form-container">
            <h2>➕ Add New House</h2>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">House Title *</label>
                    <input type="text" id="title" name="title" required 
                           placeholder="e.g., Modern 2BHK Apartment">
                </div>

                <div class="form-group">
                    <label for="location">Location *</label>
                    <input type="text" id="location" name="location" required 
                           placeholder="e.g., Dhanmondi, Dhaka">
                </div>

                <div class="form-group">
                    <label for="rent">Monthly Rent (৳) *</label>
                    <input type="number" id="rent" name="rent" required step="0.01" 
                           placeholder="e.g., 25000">
                </div>

                <div class="form-group">
                    <label for="rooms">Number of Rooms *</label>
                    <input type="number" id="rooms" name="rooms" required min="1" 
                           placeholder="e.g., 2">
                </div>

                <div class="form-group">
                    <label for="bathrooms">Number of Bathrooms *</label>
                    <input type="number" id="bathrooms" name="bathrooms" required min="1" 
                           placeholder="e.g., 2">
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number *</label>
                    <input type="text" id="contact_number" name="contact_number" required 
                           placeholder="e.g., 01712345678">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" 
                              placeholder="Enter house description..."></textarea>
                </div>

                <div class="form-group">
                    <label for="image">House Image (JPG, PNG, GIF)</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn btn-success">Add House</button>
                    <a href="dashboard.php" class="btn btn-primary" style="text-decoration: none; display: inline-block; text-align: center;">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 House Rent Search. All rights reserved.</p>
    </footer>
</body>
</html>

<?php mysqli_close($conn); ?>