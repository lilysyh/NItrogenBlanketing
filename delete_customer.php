<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $delete_id = $_GET['id'];

    // Delete data from the database
    $delete_stmt = $conn->prepare("DELETE FROM customer WHERE c_code = ?");
    $delete_stmt->bind_param("s", $delete_id);

    if ($delete_stmt->execute()) {
        // Deletion successful
        header("Location: customer.php"); // Redirect to the customer listing page after successful deletion
        exit;
    } else {
        // Handle deletion error
        echo "Error deleting record.";
    }

    $delete_stmt->close();
}

mysqli_close($conn);
?>
