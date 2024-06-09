

<?php
// Include the database connection file
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    $add_date = $_POST["add_date"];
    $add_tank = $_POST["add_tank"];
    $add_customer = $_POST["add_customer"];
    $add_product = $_POST["add_product"];
    $add_tank_top = $_POST["add_tank_top"];
    $add_n2_percentage = $_POST["add_n2_percentage"];
    $add_reading = $_POST["add_reading"];
    $add_remarks = $_POST["add_remarks"];

    // Insert data into the database
    $insert_stmt = $conn->prepare("INSERT INTO n2blanketingdata (date, tank, customer, product, tank_top, n2_percentage, reading, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("ssssssss", $add_date, $add_tank, $add_customer, $add_product, $add_tank_top, $add_n2_percentage, $add_reading, $add_remarks);

    if ($insert_stmt->execute()) {
        header("Location: index.php"); // Redirect to the main page after a successful insert
        exit;
    } else {
        // Handle insert error
        echo "Error adding record.";
    }

    $insert_stmt->close();
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html>

<head>
    <title>Add Data</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 40%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px #ccc;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="date"],
        select,
        input[type="text"] {
            width: calc(100% - 16px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        

        .back-button {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #ffffff;
            background-color: #A9A9A9;
            padding: 10px 15px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="" method="post">
            <div class="form-group">
                <label for="add_date">Date:</label>
                <input type="date" name="add_date" id="add_date">
            </div>
            <div class="form-group">
                <label for="add_tank">Tank:</label>
                <select name="add_tank" class="select2">
                <?php
                        // Include the database connection file for retrieving tank data
                        include("connection.php");
                        $tankQuery = "SELECT t_id FROM tank";
                        $tankResult = $conn->query($tankQuery);
                        while ($tankRow = $tankResult->fetch_assoc()):
                        ?>
                        <option value="<?php echo $tankRow['t_id']; ?>">
                            <?php echo $tankRow['t_id']; ?>
                        </option>
                        <?php endwhile;
                        ?>
                </select>
            </div>
            <div class="form-group">
                <label for="add_customer">Customer:</label>
                <select name="add_customer" class="select2">
                <?php
                        // Include the database connection file for retrieving customer data
                        include("connection.php");
                        $customerQuery = "SELECT c_code FROM customer";
                        $customerResult = $conn->query($customerQuery);
                        while ($customerRow = $customerResult->fetch_assoc()):
                        ?>
                        <option value="<?php echo $customerRow['c_code']; ?>">
                            <?php echo $customerRow['c_code']; ?>
                        </option>
                        <?php endwhile;
                        ?>
                </select>
            </div>
            <div class="form-group">
                <label for="add_product">Product:</label>
                <select name="add_product" class="select2">
                <?php
                        // Include the database connection file for retrieving product data
                        include("connection.php");
                        $productQuery = "SELECT p_code FROM product";
                        $productResult = $conn->query($productQuery);
                        while ($productRow = $productResult->fetch_assoc()):
                        ?>
                        <option value="<?php echo $productRow['p_code']; ?>">
                            <?php echo $productRow['p_code']; ?>
                        </option>
                        <?php endwhile;
                        ?>
                </select>
            </div>
            <div class="form-group">
                <label for="add_tank_top">Tank Top:</label>
                <select name="add_tank_top" id="add_tank_top">
                    <option value="ON">ON</option>
                    <option value="OFF">OFF</option>
                </select>
            </div>
            <div class="form-group">
                <label for="add_n2_percentage">N2 (%):</label>
                <input type="text" name="add_n2_percentage" id="add_n2_percentage">
            </div>
            <div class="form-group">
                <label for="add_reading">Reading (%):</label>
                <input type="text" name="add_reading" id="add_reading">
            </div>
            <div class="form-group">
                <label for="add_remarks">Remarks:</label>
                <input type="text" name="add_remarks" id="add_remarks">
            </div>
            <input type="submit" value="Add" name="add">
            <a href="index.php" class="back-button">Back</a>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'classic', // Choose a theme that matches your styling
            });
        });
    </script>
</body>

</html>

