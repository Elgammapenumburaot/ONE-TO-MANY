<?php 

require_once 'dbConfig.php'; 
require_once 'models.php';  

// Handling seller insertion
if (isset($_POST['insertNewSellerBtn'])) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $companyName = trim($_POST['companyName']);
    $email = trim($_POST['email']);
    $productCategory = trim($_POST['productCategory']);
    $dateAdded = date('Y-m-d H:i:s'); // Set current date and time

    // Check that required fields are not empty
    if (!empty($firstName) && !empty($lastName) && !empty($companyName) && !empty($email) && !empty($productCategory)) {
        $query = insertNewSeller($pdo, $firstName, $lastName, $companyName, $email, $productCategory, $dateAdded);

        if ($query) {
            header("Location: ../index.php?success=Seller added");
            exit();
        } else {
            echo "Failed to insert seller.";
        }
    } else {
        echo "Make sure that no fields are empty.";
    }
}

// Handling seller update
if (isset($_POST['editSellerBtn'])) {
    $seller_id = $_POST['seller_id'];
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $companyName = trim($_POST['companyName']);
    $email = trim($_POST['email']);
    $productCategory = trim($_POST['productCategory']);
    $dateAdded = trim($_POST['dateAdded']);

    // Check that required fields are not empty
    if (!empty($seller_id) && !empty($firstName) && !empty($lastName) && !empty($companyName) && !empty($email) && !empty($productCategory)) {
        $query = updateSeller($pdo, $seller_id, $firstName, $lastName, $companyName, $email, $productCategory, $dateAdded);

        if ($query) {
            header("Location: ../index.php?success=Seller updated");
            exit();
        } else {
            echo "Failed to update seller.";
        }
    } else {
        echo "Make sure that no fields are empty.";
    }
}

// Handling seller deletion
if (isset($_POST['deleteSellerBtn']) && isset($_POST['seller_id'])) {
    $seller_id = $_POST['seller_id'];

    if (!empty($seller_id)) {
        if (deleteSeller($pdo, $seller_id)) {
            header("Location: ../index.php?success=Seller deleted");
            exit();
        } else {
            echo "Failed to delete seller.";
        }
    } else {
        echo "Seller ID is required to delete a seller.";
    }
}

// Insert a new customer
if (isset($_POST['insertNewCustomerBtn'])) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $dateAdded = date('Y-m-d H:i:s'); // Capture the current date and time
    
    if (!empty($firstName) && !empty($lastName) && !empty($email)) {
        $insertSuccess = insertNewCustomer($pdo, $firstName, $lastName, $email, $dateAdded);
        
        if ($insertSuccess) {
            // Redirect to the customer list page
            header("Location: viewCustomers.php?success=Customer added successfully");
            exit();
        } else {
            echo "Error adding customer.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}
// Update an existing customer
if (isset($_POST['updateCustomerBtn'])) {
    $customer_id = $_POST['customer_id'];
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $companyName = trim($_POST['companyName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $productCategory = trim($_POST['productCategory'] ?? '');
    $sellerId = $_POST['seller_id'] ?? null;

    // Check that required fields are not empty
    if (!empty($customer_id) && !empty($firstName) && !empty($lastName)) {
        $query = updateCustomer($pdo, $firstName, $lastName, $companyName, $email, $productCategory, $sellerId, $customer_id);

        if ($query) {
            header("Location: ../viewCustomers.php?success=Customer updated");
            exit();
        } else {
            echo "Failed to update customer.";
        }
    } else {
        echo "Please fill in all required fields (customer ID, first name, and last name).";
    }
}

// Check if the 'deleteCustomerBtn' is pressed
if (isset($_POST['deleteCustomerBtn']) && isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];  // Get the customer ID from the URL

    // Call the delete function from models.php
    $deleteSuccess = deleteCustomer($pdo, $customer_id); // Ensure deleteCustomer function is defined

    // Check if deletion was successful
    if ($deleteSuccess) {
        // Redirect to another page after successful deletion (e.g., customer list page)
        header("Location: customersList.php");  // Replace with your list page
        exit(); // Make sure to stop further script execution
    } else {
        echo "Error deleting customer. Please try again.";
    }
}

