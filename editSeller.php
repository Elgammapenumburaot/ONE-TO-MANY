<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

// Check if the seller_id is set in the URL
if (isset($_GET['seller_id'])) {
    $seller_id = $_GET['seller_id'];
    
    // Fetch the seller details from the database
    $seller = getSellerById($pdo, $seller_id);
    
    if (!$seller) {
        die('Seller not found.');
    }
} else {
    die('Seller ID not provided.');
}

// Handle the form submission and update the seller
if (isset($_POST['updateSellerBtn'])) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $companyName = trim($_POST['companyName']);
    $email = trim($_POST['email']);
    $productCategory = trim($_POST['productCategory']);
    $dateAdded = trim($_POST['dateAdded']);

    // Check if all required fields are filled
    if (!empty($firstName) && !empty($lastName) && !empty($companyName) && !empty($email) && !empty($productCategory) && !empty($dateAdded)) {
        
        // Update seller in the database
        $updateQuery = updateSeller($pdo, $seller_id, $firstName, $lastName, $companyName, $email, $productCategory, $dateAdded);
        
        // Redirect after successful update
        if ($updateQuery) {
            header("Location: index.php");
            exit;
        } else {
            echo "Update failed. Please try again.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Seller</title>
    <style>
        body {
            font-family: "Arial";
        }
        input {
            font-size: 1.5em;
            height: 50px;
            width: 200px;
        }
    </style>
</head>
<body>
    <h3>Edit Seller Details</h3>
    <form action="" method="POST">
        <p><label for="firstName">First Name</label> 
           <input type="text" name="firstName" value="<?php echo htmlspecialchars($seller['first_name']); ?>" required></p>
        <p><label for="lastName">Last Name</label> 
           <input type="text" name="lastName" value="<?php echo htmlspecialchars($seller['last_name']); ?>" required></p>
        <p><label for="companyName">Company Name</label> 
           <input type="text" name="companyName" value="<?php echo htmlspecialchars($seller['company_name']); ?>" required></p>
        <p><label for="email">Email</label> 
           <input type="email" name="email" value="<?php echo htmlspecialchars($seller['email']); ?>" required></p>
        <p><label for="productCategory">Product Category</label> 
           <input type="text" name="productCategory" value="<?php echo htmlspecialchars($seller['product_category']); ?>" required></p>
        <p><label for="dateAdded">Registration Date</label> 
           <input type="datetime-local" name="dateAdded" value="<?php echo date('Y-m-d\TH:i', strtotime($seller['date_added'])); ?>" required></p>
        <input type="submit" name="updateSellerBtn" value="Update Seller">
    </form>
</body>
</html>
