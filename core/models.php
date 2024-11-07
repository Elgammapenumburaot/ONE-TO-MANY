<?php 
// Include the DB configuration file to establish a database connection
require_once 'dbConfig.php';


function seeAllSellers($pdo) {
    // Prepare the SQL query to select all sellers
    $sql = "SELECT * FROM sellers";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch all results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertNewSeller($pdo, $firstName, $lastName, $companyName, $email, $productCategory, $dateAdded) {
    // Prepare the SQL query to insert the new seller into the database
    $sql = "INSERT INTO sellers (first_name, last_name, company_name, email, product_category, date_added) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $pdo->prepare($sql);

    // Execute the query with the provided values
    $executeQuery = $stmt->execute([$firstName, $lastName, $companyName, $email, $productCategory, $dateAdded]);

    // Check if the query executed successfully and return the result
    if ($executeQuery) {
        return true; // Return true if the insertion was successful
    } else {
        return false; // Return false if there was an error
    }
}

function getSellerById($pdo, $seller_id) {
    // SQL query to fetch seller by their ID
    $sql = "SELECT * FROM sellers WHERE seller_id = ?";
    
    // Prepare the statement
    $stmt = $pdo->prepare($sql);
    
    // Execute the query
    $stmt->execute([$seller_id]);
    
    // Fetch and return the result
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// models.php

// Function to update seller information
function updateSeller($pdo, $seller_id, $firstName, $lastName, $companyName, $email, $productCategory, $dateAdded) {
    $sql = "UPDATE sellers 
            SET first_name = ?, last_name = ?, company_name = ?, email = ?, product_category = ?, date_added = ?
            WHERE seller_id = ?";
    
    // Prepare and execute the update query
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$firstName, $lastName, $companyName, $email, $productCategory, $dateAdded, $seller_id]);
    
    // Return true if the update was successful, false otherwise
    return $stmt->rowCount() > 0;
}


function getCustomersBySeller($pdo, $seller_id) {
    // SQL query to get customers for a given seller_id
    $sql = "SELECT * FROM customers WHERE seller_id = ?";
    
    // Prepare and execute the query
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$seller_id]);
    
    // Fetch all customers for this seller
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $customers;
}

function insertNewCustomer($pdo, $firstName, $lastName, $email, $seller_id) {
    // Prepare SQL query to insert the customer with seller_id
    $sql = "INSERT INTO customers (first_name, last_name, email, seller_id) 
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Execute the query with the provided customer data
    $stmt->execute([$firstName, $lastName, $email, $seller_id]);

    // Return true if insertion was successful
    return $stmt->rowCount() > 0;
}

function getCustomerById($pdo, $customer_id) {
    $sql = "SELECT * FROM customers WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$customer_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);  // Return the customer's data or false if not found
}

function updateCustomer($pdo, $customer_id, $firstName, $lastName, $email) {
    $sql = "UPDATE customers SET first_name = ?, last_name = ?, email = ? WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);

    // Execute the query with the provided customer data
    $stmt->execute([$firstName, $lastName, $email, $customer_id]);

    // Return true if the update was successful, otherwise false
    return $stmt->rowCount() > 0;
}

function deleteCustomer($pdo, $customer_id) {
    // SQL query to delete the customer from the database
    $sql = "DELETE FROM customers WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    
    // Execute the query
    $stmt->execute([$customer_id]);

    // Return true if the deletion was successful, otherwise false
    return $stmt->rowCount() > 0;
}