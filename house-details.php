<?php
include 'db.php';

// Get house ID
$house_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($house_id <= 0) {
    header("Location: index.php");
    exit();
}

// Fetch house details
$sql = "SELECT * FROM houses WHERE id = $house_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$house = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($house['title']); ?> - House Details</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <h1>🏠 House Rent Search</h1>
            <nav>
                <a href="index.php">← Back to Listings</a>
                <a href="admin/login.php">Admin Login</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="house-details">
            <!-- House Image -->
            <img src="<?php echo !empty($house['image']) ? 'uploads/house-images/' . $house['image'] : 'https://via.placeholder.com/800x500?text=No+Image'; ?>" 
                 alt="<?php echo htmlspecialchars($house['title']); ?>">

            <!-- House Title -->
            <h1><?php echo htmlspecialchars($house['title']); ?></h1>
            
            <!-- Price -->
            <p class="price">৳ <?php echo number_format($house['rent'], 2); ?> per month</p>

            <!-- Details Grid -->
            <div class="details-grid">
                <div class="detail-item">
                    <strong>📍 Location</strong>
                    <p><?php echo htmlspecialchars($house['location']); ?></p>
                </div>

                <div class="detail-item">
                    <strong>🛏️ Bedrooms</strong>
                    <p><?php echo $house['rooms']; ?> Rooms</p>
                </div>

                <div class="detail-item">
                    <strong>🚿 Bathrooms</strong>
                    <p><?php echo $house['bathrooms']; ?> Bathrooms</p>
                </div>

                <div class="detail-item">
                    <strong>📞 Contact Number</strong>
                    <p><a href="tel:<?php echo $house['contact_number']; ?>" style="color: #667eea; text-decoration: none;">
                        <?php echo htmlspecialchars($house['contact_number']); ?>
                    </a></p>
                </div>
            </div>

            <!-- Description -->
            <div style="margin-top: 30px;">
                <h2 style="color: #667eea; margin-bottom: 15px;">📝 Description</h2>
                <p style="line-height: 1.8; color: #555;">
                    <?php echo nl2br(htmlspecialchars($house['description'])); ?>
                </p>
            </div>

            <!-- Contact Section -->
            <div style="margin-top: 30px; padding: 25px; background: #f8f9fa; border-radius: 10px; text-align: center;">
                <h3 style="color: #667eea; margin-bottom: 15px;">Interested in this property?</h3>
                <p style="margin-bottom: 15px; color: #666;">Contact the owner directly</p>
                <a href="tel:<?php echo $house['contact_number']; ?>" 
                   class="btn btn-success" 
                   style="display: inline-block; text-decoration: none;">
                    📞 Call <?php echo htmlspecialchars($house['contact_number']); ?>
                </a>
            </div>

            <!-- Back Button -->
            <div style="margin-top: 30px; text-align: center;">
                <a href="index.php" class="btn btn-primary">← Back to House Listings</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 House Rent Search. All rights reserved.</p>
    </footer>
</body>
</html>

<?php mysqli_close($conn); ?>