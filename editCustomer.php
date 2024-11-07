<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if the customer_id is provided in the URL
if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];

    // Fetch the customer details from the database
    $customer = getCustomerById($pdo, $customer_id);
    
    // If the customer is not found, show an error message
    if (!$customer) {
        echo "Customer not found.";
        exit();
    }
} else {
    echo "Customer ID is missing.";
    exit();
}

// Handle the form submission for updating the customer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateCustomerBtn'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];

    // Call the function to update the customer details
    $updateSuccess = updateCustomer($pdo, $customer_id, $firstName, $lastName, $email);

    if ($updateSuccess) {
        header("Location: viewCustomers.php?seller_id=" . $customer['seller_id']);
        exit();
    } else {
        $errorMessage = "Error updating customer. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .form-container input {
            padding: 10px;
            margin: 5px;
            font-size: 1em;
            width: 250px;
        }
        .form-container input[type="submit"] {
            width: auto;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h3>Edit Customer Information</h3>
    
    <a href="viewCustomers.php?seller_id=<?php echo htmlspecialchars($customer['seller_id']); ?>">Back to Customers</a>
    
    <!-- Edit Customer Form -->
    <div class="form-container">
        <h4>Update Information for Customer ID: <?php echo htmlspecialchars($customer['customer_id']); ?></h4>
        <?php if (isset($errorMessage)): ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <form action="editCustomer.php?customer_id=<?php echo $customer_id; ?>" method="POST">
            <p>
                <label for="firstName">First Name</label>
                <input type="text" name="firstName" value="<?php echo htmlspecialchars($customer['first_name']); ?>" required>
            </p>
            <p>
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" value="<?php echo htmlspecialchars($customer['last_name']); ?>" required>
            </p>
            <p>
                <label for="email">Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required>
            </p>
            <p>
                <input type="submit" name="updateCustomerBtn" value="Update Customer">
            </p>
        </form>
    </div>
</body>
</html>
