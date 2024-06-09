<?php
// Include the database connection file
include("connection.php");

    // Prepare and execute the delete statement
    $delete_stmt = $conn->prepare("DELETE FROM n2blanketingdata WHERE id = ?");
    $delete_stmt->bind_param("i", $delete_id);

    if ($delete_stmt->execute()) {
        // Record deleted successfully
        header("Location: index.php"); // Redirect back to the main page
        exit();
    } else {
        // Error deleting record
        echo "Error deleting record: " . $conn->error;
    }

    $delete_stmt->close();
    $conn->close();

?>
