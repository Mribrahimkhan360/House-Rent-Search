<?php
session_start();
include '../db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

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

// Delete house image if exists
if (!empty($house['image']) && file_exists('../uploads/house-images/' . $house['image'])) {
    unlink('../uploads/house-images/' . $house['image']);
}

// Delete from database
$delete_sql = "DELETE FROM houses WHERE id = $house_id";

if (mysqli_query($conn, $delete_sql)) {
    $_SESSION['delete_success'] = 'House deleted successfully!';
} else {
    $_SESSION['delete_error'] = 'Failed to delete house: ' . mysqli_error($conn);
}

mysqli_close($conn);
header("Location: dashboard.php");
exit();
?>