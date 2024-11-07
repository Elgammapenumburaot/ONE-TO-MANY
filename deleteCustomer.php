<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if the customer_id is provided in the URL
if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];

    // Call the function to delete the customer record
    $deleteSuccess = deleteCustomer($pdo, $customer_id);

    if ($deleteSuccess) {
        // Redirect back to the customer list page after successful deletion
        header("Location: viewCustomers.php?seller_id=" . $_GET['seller_id']);
        exit();
    } else {
        echo "Error deleting the customer.";
    }
} else {
    echo "Customer ID is missing.";
    exit();
}
?>
