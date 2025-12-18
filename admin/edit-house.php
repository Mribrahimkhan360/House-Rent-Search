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

// Get house ID
$house_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($house_id <= 0) {
    header("Location: dashboard.php");
    exit();
}

// Fetch house details
$sql = "SELECT * FROM houses WHERE id = $house_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: dashboard.php");
    exit();
}

$house = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $rent = mysqli_real_escape_string($conn, $_POST['rent']);
    $rooms = intval($_POST['rooms']);
    $bathrooms = intval($_POST['bathrooms']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);

    $image_name = $house['image']; // Keep old image by default

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = $_FILES['image']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_name = 'house_' . time() . '.' . $file_extension;
            $upload_path = '../uploads/house-images/' . $image_name;
            
            if (!file_exists('../uploads/house-images/')) {
                mkdir('../uploads/house-images/', 0777, true);
            }
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                // Delete old image
                if (!empty($house['image']) && file_exists('../uploads/house-images/' . $house['image'])) {
                    unlink('../uploads/house-images/' . $house['image']);
                }
            } else {
                $error = 'Failed to upload new image!';
            }
        } else {
            $error = 'Invalid image type. Only JPG, PNG, GIF allowed.';
        }
    }

    // Update database if no errors
    if (empty($error)) {
        $update_sql = "UPDATE houses SET 
                       title = '$title',
                       location = '$location',
                       rent = '$rent',
                       rooms = $rooms,
                       bathrooms = $bathrooms,
                       description = '$description',
                       image = '$image_name',
                       contact_number = '$contact_number'
                       WHERE id = $house_id";
        
        if (mysqli_query($conn, $update_sql)) {
            $success = 'House updated successfully!';
            // Refresh house data
            $result = mysqli_query($conn, "SELECT * FROM houses WHERE id = $house_id");
            $house = mysqli_fetch_assoc($result);
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
    <title>Edit House - Admin</title>
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
            <h2>✏️ Edit House</h2>

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
                           value="<?php echo htmlspecialchars($house['title']); ?>">
                </div>

                <div class="form-group">
                    <label for="location">Location *</label>
                    <input type="text" id="location" name="location" required 
                           value="<?php echo htmlspecialchars($house['location']); ?>">
                </div>

                <div class="form-group">
                    <label for="rent">Monthly Rent (৳) *</label>
                    <input type="number" id="rent" name="rent" required step="0.01" 
                           value="<?php echo $house['rent']; ?>">
                </div>

                <div class="form-group">
                    <label for="rooms">Number of Rooms *</label>
                    <input type="number" id="rooms" name="rooms" required min="1" 
                           value="<?php echo $house['rooms']; ?>">
                </div>

                <div class="form-group">
                    <label for="bathrooms">Number of Bathrooms *</label>
                    <input type="number" id="bathrooms" name="bathrooms" required min="1" 
                           value="<?php echo $house['bathrooms']; ?>">
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number *</label>
                    <input type="text" id="contact_number" name="contact_number" required 
                           value="<?php echo htmlspecialchars($house['contact_number']); ?>">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($house['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Current Image</label>
                    <?php if (!empty($house['image'])): ?>
                        <img src="../uploads/house-images/<?php echo $house['image']; ?>" 
                             style="max-width: 200px; border-radius: 5px; margin-top: 10px;" 
                             alt="Current">
                    <?php else: ?>
                        <p style="color: #888;">No image uploaded</p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="image">Upload New Image (JPG, PNG, GIF)</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <small style="color: #888;">Leave empty to keep current image</small>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn btn-success">Update House</button>
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