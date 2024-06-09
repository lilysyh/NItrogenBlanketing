<?php
// Include the database connection file
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
    $edit_p_code = $_POST["edit_p_code"];

    // Update data in the database
    $update_stmt = $conn->prepare("UPDATE product SET p_code = ? WHERE p_code = ?");
    $update_stmt->bind_param("ss", $edit_p_code, $_POST['original_p_code']); // Adjust the parameter types as needed

    if ($update_stmt->execute()) {
        header("Location: product.php"); // Redirect to the main page after a successful update
        exit;
    } else {
        // Handle update error
        echo "Error updating record.";
    }

    $update_stmt->close();
}

// Retrieve the tank data for editing
if (isset($_GET['id'])) {
    $edit_id = $_GET['id'];

    // Fetch the tank data based on the provided ID
    $fetch_stmt = $conn->prepare("SELECT p_code FROM product WHERE p_code = ?");
    $fetch_stmt->bind_param("s", $edit_id);
    $fetch_stmt->execute();
    $result = $fetch_stmt->get_result();
    $row = $result->fetch_assoc();

    // Store the existing data in a variable
    $existing_p_code = $row['p_code'];

    $fetch_stmt->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        input[type="date"], select, input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="" method="post">
            <!-- Include the original data as a hidden input field for reference during the update -->
            <input type="hidden" name="original_p_code" value="<?php echo $existing_p_code; ?>">
            
            
            <table>
                <tr>
                    <th>Product Name</th>
              
                <td><input type="text" name="edit_p_code" id="edit_p_code" value="<?php echo $existing_p_code; ?>"></td>
                <tr>
           
           <td colspan="2">
       <input type="submit" value="Save" name="edit">
       <a href="product.php" style="display: block; text-align: center; margin-top: 10px; text-decoration: none; color: #fff; background-color: #A9A9A9; padding: 10px 15px; border-radius: 4px;">Back</a>
   </td>
           </tr>
   </table>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'classic', // Choose a theme that matches your styling
            });
        });
    </script>
</body>
</html>
