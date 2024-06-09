<?php
// Include the database connection file
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $edit_id = $_GET["id"];

    $select_stmt = $conn->prepare("SELECT * FROM n2blanketingdata WHERE id = ?");
    $select_stmt->bind_param("i", $edit_id);
    $select_stmt->execute();
    $result = $select_stmt->get_result();

    if ($result->num_rows > 0) {
        $edit_row = $result->fetch_assoc();
    } else {
        // Handle record not found error
        echo "Record not found.";
        exit;
    }

    $select_stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
    $edit_id = $_POST["edit_id"];
    $edit_date = $_POST["edit_date"];
    $edit_tank = $_POST["edit_tank"];
    $edit_customer = $_POST["edit_customer"];
    $edit_product = $_POST["edit_product"];
    $edit_tank_top = $_POST["edit_tank_top"];
    $edit_n2_percentage = $_POST["edit_n2_percentage"];
    $edit_reading = $_POST["edit_reading"];
    $edit_remarks = $_POST["edit_remarks"];

    $update_stmt = $conn->prepare("UPDATE n2blanketingdata SET date=?, tank=?, customer=?, product=?, tank_top=?, n2_percentage=?, reading=?, remarks=? WHERE id=?");
    $update_stmt->bind_param("ssssssssi", $edit_date, $edit_tank, $edit_customer, $edit_product, $edit_tank_top, $edit_n2_percentage, $edit_reading, $edit_remarks, $edit_id);

    if ($update_stmt->execute()) {
        header("Location: index.php"); // Redirect to the main page after a successful update
        exit;
    } else {
        // Handle update error
        echo "Error updating record.";
    }

    $update_stmt->close();
}

mysqli_close($conn);
?>













<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>
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
            <input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>">
            <table>
                <tr>
                    <th>Date</th>
                    <td><input type="date" name="edit_date" value="<?php echo $edit_row['date']; ?>"></td>
                </tr>
                <tr>
                    <th>Tank</th>
                    <td>
                        <select name="edit_tank" class="select2">
                            <?php
                            // Include the database connection file for retrieving tank data
                            include("connection.php");
                            $tankQuery = "SELECT t_id FROM tank";
                            $tankResult = $conn->query($tankQuery);
                            while ($tankRow = $tankResult->fetch_assoc()):
                            ?>
                            <option value="<?php echo $tankRow['t_id']; ?>" <?php if ($edit_row['tank'] == $tankRow['t_id']) echo 'selected'; ?>>
                                <?php echo $tankRow['t_id']; ?>
                            </option>
                            <?php endwhile;
                            ?>
                        </select>
                    </td>
                </tr>

                <th>Customer</th>
                    <td>
                    <select name="edit_customer" class="select2" style="width: 100%;">
                        <?php
                        // Include the database connection file for retrieving customer data
                        include("connection.php");
                        $customerQuery = "SELECT c_code FROM customer";
                        $customerResult = $conn->query($customerQuery);
                        while ($customerRow = $customerResult->fetch_assoc()):
                        ?>
                        <option value="<?php echo $customerRow['c_code']; ?>" <?php if ($edit_row['customer'] == $customerRow['c_code']) echo 'selected'; ?>>
                            <?php echo $customerRow['c_code']; ?>
                        </option>
                        <?php endwhile;
                        ?>
                    </select>
                    </td>
                </tr>
               
                <th>Product</th>
                    <td>
                    <select name="edit_product" class="select2" style="width: 100%;">
                        <?php
                        // Include the database connection file for retrieving product data
                        include("connection.php");
                        $productQuery = "SELECT p_code FROM product";
                        $productResult = $conn->query($productQuery);
                        while ($productRow = $productResult->fetch_assoc()):
                        ?>
                        <option value="<?php echo $productRow['p_code']; ?>" <?php if ($edit_row['product'] == $productRow['p_code']) echo 'selected'; ?>>
                            <?php echo $productRow['p_code']; ?>
                        </option>
                        <?php endwhile;
                        ?>
                    </select>
                    </td>
                </tr>

                <th>Tank Top</th>
                <td>
                    <select name="edit_tank_top" style="width: 100%;">
                        <option value="ON" <?php if ($edit_row['tank_top'] == 'ON') echo 'selected'; ?>>ON</option>
                        <option value="OFF" <?php if ($edit_row['tank_top'] == 'OFF') echo 'selected'; ?>>OFF</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>N2 (%)</th>
                <td><input type="text" name="edit_n2_percentage" value="<?php echo $edit_row['n2_percentage']; ?>"></td>
            </tr>
            <tr>
                <th>Reading (%)</th>
                <td><input type="text" name="edit_reading" value="<?php echo $edit_row['reading']; ?>"></td>
            </tr>
            <tr>
                <th>Remarks</th>
                <td><input type="text" name="edit_remarks" value="<?php echo $edit_row['remarks']; ?>"></td>
            </tr>

                <tr>
    <td colspan="2">
        <input type="submit" value="Save" name="edit">
        <a href="index.php" style="display: block; text-align: center; margin-top: 10px; text-decoration: none; color: #fff; background-color: #A9A9A9; padding: 10px 15px; border-radius: 4px;">Back</a>
    </td>
</tr>
            </table>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'classic', // Choose a theme that matches your styling
            });
        });
    </script>
</body>
</html>
