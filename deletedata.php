<?php
// Include the database connection file
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    // Get the ID of the record to be deleted from the URL parameter
    $delete_id = $_GET["id"];

    // Prepare the SQL statement for deletion
    $delete_stmt = $conn->prepare("DELETE FROM n2blanketingdata WHERE id = ?");
    $delete_stmt->bind_param("i", $delete_id);

    if ($delete_stmt->execute()) {
        // Record deleted successfully
        header("Location: index.php"); // Redirect back to the main page after deletion
        exit();
    } else {
        // Error deleting record
        echo "Error: " . $conn->error;
    }

    $delete_stmt->close();
}

mysqli_close($conn);
?>
