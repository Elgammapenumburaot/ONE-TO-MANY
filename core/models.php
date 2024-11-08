<?php 

require_once 'dbConfig.php';


function seeAllSellers($pdo) {

    $sql = "SELECT * FROM sellers";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();


    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertNewSeller($pdo, $firstName, $lastName, $companyName, $email, $productCategory, $dateAdded) {
   
    $sql = "INSERT INTO sellers (first_name, last_name, company_name, email, product_category, date_added) 
            VALUES (?, ?, ?, ?, ?, ?)";

  
    $stmt = $pdo->prepare($sql);

    
    $executeQuery = $stmt->execute([$firstName, $lastName, $companyName, $email, $productCategory, $dateAdded]);

    
    if ($executeQuery) {
        return true; 
        return false; /
    }
}

function getSellerById($pdo, $seller_id) {
 
    $sql = "SELECT * FROM sellers WHERE seller_id = ?";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([$seller_id]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}




function updateSeller($pdo, $seller_id, $firstName, $lastName, $companyName, $email, $productCategory, $dateAdded) {
    $sql = "UPDATE sellers 
            SET first_name = ?, last_name = ?, company_name = ?, email = ?, product_category = ?, date_added = ?
            WHERE seller_id = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$firstName, $lastName, $companyName, $email, $productCategory, $dateAdded, $seller_id]);

    return $stmt->rowCount() > 0;
}


function getCustomersBySeller($pdo, $seller_id) {
 
    $sql = "SELECT * FROM customers WHERE seller_id = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$seller_id]);
    
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $customers;
}

function insertNewCustomer($pdo, $firstName, $lastName, $email, $seller_id) {
  
    $sql = "INSERT INTO customers (first_name, last_name, email, seller_id) 
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([$firstName, $lastName, $email, $seller_id]);

    return $stmt->rowCount() > 0;
}

function getCustomerById($pdo, $customer_id) {
    $sql = "SELECT * FROM customers WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$customer_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC); 
}

function updateCustomer($pdo, $customer_id, $firstName, $lastName, $email) {
    $sql = "UPDATE customers SET first_name = ?, last_name = ?, email = ? WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([$firstName, $lastName, $email, $customer_id]);

    return $stmt->rowCount() > 0;
}

function deleteCustomer($pdo, $customer_id) {

    $sql = "DELETE FROM customers WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    

    $stmt->execute([$customer_id]);

    return $stmt->rowCount() > 0;
}
