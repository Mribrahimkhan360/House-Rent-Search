<?php
session_start();
include '../db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Get statistics
$total_houses_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM houses");
$total_houses = mysqli_fetch_assoc($total_houses_result)['total'];

$total_rent_result = mysqli_query($conn, "SELECT SUM(rent) as total FROM houses");
$total_rent = mysqli_fetch_assoc($total_rent_result)['total'];

$avg_rent_result = mysqli_query($conn, "SELECT AVG(rent) as avg FROM houses");
$avg_rent = mysqli_fetch_assoc($avg_rent_result)['avg'];

// Get all houses
$houses_result = mysqli_query($conn, "SELECT * FROM houses ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - House Rent Search</title>
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
        <h2 style="margin-bottom: 20px;">Welcome, <?php echo htmlspecialchars($_SESSION['admin_email']); ?>!</h2>

        <?php if (isset($_SESSION['delete_success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['delete_success']; unset($_SESSION['delete_success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['delete_error'])): ?>
            <div class="alert alert-error"><?php echo $_SESSION['delete_error']; unset($_SESSION['delete_error']); ?></div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="dashboard-stats">
            <div class="stat-card">
                <h3><?php echo $total_houses; ?></h3>
                <p>Total Houses</p>
            </div>

            <div class="stat-card">
                <h3>৳ <?php echo number_format($total_rent, 0); ?></h3>
                <p>Total Rent Value</p>
            </div>

            <div class="stat-card">
                <h3>৳ <?php echo number_format($avg_rent, 0); ?></h3>
                <p>Average Rent</p>
            </div>
        </div>

        <!-- Houses Table -->
        <div class="admin-table">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>All Houses</h2>
                <a href="add-house.php" class="btn btn-success">+ Add New House</a>
            </div>

            <?php if (mysqli_num_rows($houses_result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Rent</th>
                            <th>Rooms</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($house = mysqli_fetch_assoc($houses_result)): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo !empty($house['image']) ? '../uploads/house-images/' . $house['image'] : 'https://via.placeholder.com/60'; ?>" 
                                         alt="House">
                                </td>
                                <td><?php echo htmlspecialchars($house['title']); ?></td>
                                <td><?php echo htmlspecialchars($house['location']); ?></td>
                                <td>৳ <?php echo number_format($house['rent'], 2); ?></td>
                                <td><?php echo $house['rooms']; ?></td>
                                <td><?php echo htmlspecialchars($house['contact_number']); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="../house-details.php?id=<?php echo $house['id']; ?>" 
                                           class="btn btn-primary" 
                                           style="text-decoration: none;" 
                                           target="_blank">View</a>
                                        <a href="edit-house.php?id=<?php echo $house['id']; ?>" 
                                           class="btn btn-success" 
                                           style="text-decoration: none;">Edit</a>
                                        <a href="delete-house.php?id=<?php echo $house['id']; ?>" 
                                           class="btn btn-danger" 
                                           style="text-decoration: none;"
                                           onclick="return confirm('Are you sure you want to delete this house?');">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-results">
                    <p>No houses added yet.</p>
                    <a href="add-house.php" class="btn btn-success">Add Your First House</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 House Rent Search. All rights reserved.</p>
    </footer>
</body>
</html>

<?php mysqli_close($conn); ?>