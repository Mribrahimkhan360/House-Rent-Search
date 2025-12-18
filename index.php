<?php
include 'db.php';

// Get search parameters
$location = isset($_GET['location']) ? mysqli_real_escape_string($conn, $_GET['location']) : '';
$max_rent = isset($_GET['max_rent']) ? mysqli_real_escape_string($conn, $_GET['max_rent']) : '';
$rooms = isset($_GET['rooms']) ? mysqli_real_escape_string($conn, $_GET['rooms']) : '';

// Build query
$sql = "SELECT * FROM houses WHERE 1=1";

if (!empty($location)) {
    $sql .= " AND location LIKE '%$location%'";
}

if (!empty($max_rent)) {
    $sql .= " AND rent <= $max_rent";
}

if (!empty($rooms)) {
    $sql .= " AND rooms >= $rooms";
}

$sql .= " ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);
$total_houses = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Rent Search - Find Your Dream Home</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdn.hugeicons.com/font/hgi-stroke-rounded.css" />
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <h1>🏠 House Rent Search</h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="admin/login.php">Admin Login</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <!-- Search Section -->
        <section class="search-section">
            <h2><i class="hgi hgi-stroke hgi-search-01"></i> Search Your Ideal Home</h2>
            <form method="GET" action="index.php" class="search-form">
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" 
                           placeholder="e.g., Dhanmondi, Gulshan" 
                           value="<?php echo htmlspecialchars($location); ?>">
                </div>

                <div class="form-group">
                    <label for="max_rent">Max Rent (৳)</label>
                    <input type="number" id="max_rent" name="max_rent" 
                           placeholder="e.g., 30000" 
                           value="<?php echo htmlspecialchars($max_rent); ?>">
                </div>

                <div class="form-group">
                    <label for="rooms">Min Rooms</label>
                    <select id="rooms" name="rooms">
                        <option value="">Any</option>
                        <option value="1" <?php echo $rooms == '1' ? 'selected' : ''; ?>>1+</option>
                        <option value="2" <?php echo $rooms == '2' ? 'selected' : ''; ?>>2+</option>
                        <option value="3" <?php echo $rooms == '3' ? 'selected' : ''; ?>>3+</option>
                        <option value="4" <?php echo $rooms == '4' ? 'selected' : ''; ?>>4+</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary">Search Houses</button>
                </div>
            </form>
        </section>

        <!-- Listings Section -->
        <section class="listings">
            <h2>Available Houses (<?php echo $total_houses; ?> found)</h2>

            <?php if ($total_houses > 0): ?>
                <div class="house-grid">
                    <?php while ($house = mysqli_fetch_assoc($result)): ?>
                        <div class="house-card">
                            <img src="<?php echo !empty($house['image']) ? 'uploads/house-images/' . $house['image'] : 'https://via.placeholder.com/300x200?text=No+Image'; ?>" 
                                 alt="<?php echo htmlspecialchars($house['title']); ?>">
                            
                            <div class="house-info">
                                <h3><?php echo htmlspecialchars($house['title']); ?></h3>
                                <p>📍 <?php echo htmlspecialchars($house['location']); ?></p>
                                <p class="price">৳ <?php echo number_format($house['rent'], 2); ?>/month</p>
                                
                                <div class="house-meta">
                                    <span>🛏️ <?php echo $house['rooms']; ?> Rooms</span>
                                    <span>🚿 <?php echo $house['bathrooms']; ?> Baths</span>
                                </div>

                                <a href="house-details.php?id=<?php echo $house['id']; ?>" class="btn-view">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <p style="font-size: 18px;">😔 No houses found matching your criteria.</p>
                    <p>Try adjusting your search filters.</p>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 House Rent Search. All rights reserved.</p>
    </footer>
</body>
</html>

<?php mysqli_close($conn); ?>