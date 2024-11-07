<?php
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

// Check if seller_id is set in the URL
if (isset($_GET['seller_id'])) {
    $seller_id = $_GET['seller_id'];
    
    // Fetch seller details to confirm deletion
    $seller = getSellerById($pdo, $seller_id);
    
    // If seller is found, delete them
    if ($seller) {
        // Delete seller
        $sql = "DELETE FROM sellers WHERE seller_id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$seller_id])) {
            header("Location: index.php"); // Redirect after successful deletion
            exit;
        } else {
            echo "Error deleting seller.";
        }
    } else {
        echo "Seller not found.";
    }
} else {
    echo "Seller ID not provided.";
}
?>
