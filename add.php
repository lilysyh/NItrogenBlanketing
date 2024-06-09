<?php
// Include the database connection file
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    // Handle data insertion
    $date = $_POST["date"];
    $tank = $_POST["tank"];
    $customer = $_POST["customer"];
    $product = $_POST["product"];
    $tank_top = $_POST["tank_top"];
    $n2_percentage = $_POST["n2_percentage"];
    $reading = $_POST["reading"];
    $remarks = $_POST["remarks"];

    // Prepare the SQL statement for insertion
    $insert_stmt = $conn->prepare("INSERT INTO n2blanketingdata (date, tank, customer, product, tank_top, n2_percentage, reading, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("ssssssss", $date, $tank, $customer, $product, $tank_top, $n2_percentage, $reading, $remarks);

    // Execute the insert statement
    if ($insert_stmt->execute()) {
        // Data added successfully
        header("Location: index.php"); // Redirect to the main page after adding data
        exit();
    } else {
        // Error adding data
        echo "Error: " . $conn->error;
    }

    // Close the statement
    $insert_stmt->close();
}

mysqli_close($conn);
?>
