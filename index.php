<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Seller Registration System</title>
	<style>
		body {
			font-family: "Arial";
		}
		input {
			font-size: 1.5em;
			height: 50px;
			width: 200px;
		}
		table, th, td {
		  border:1px solid black;
		}
	</style>
</head>
<body>
	<h3>Welcome to the Seller Registration System. Input your details here to register as a seller</h3>
	<form action="core/handleForms.php" method="POST">
		<p><label for="firstName">First Name</label> <input type="text" name="firstName" required></p>
		<p><label for="lastName">Last Name</label> <input type="text" name="lastName" required></p>
		<p><label for="companyName">Company Name</label> <input type="text" name="companyName" required></p>
		<p><label for="email">Email</label> <input type="email" name="email" required></p>
		<p><label for="productCategory">Product Category</label> <input type="text" name="productCategory" required></p>
		<p><label for="dateAdded">Registration Date</label> <input type="datetime-local" name="dateAdded" required>
			<input type="submit" name="insertNewSellerBtn" value="Register">
		</p>
	</form>

	<h3>Registered Sellers</h3> <!-- Updated this header -->
	<table style="width:100%; margin-top: 50px;">
	  <tr>
	    <th>Seller ID</th> <!-- Changed "Customer ID" to "Seller ID" -->
	    <th>First Name</th>
	    <th>Last Name</th>
		<th>Company Name</th>
	    <th>Email</th>
	    <th>Product Category</th> <!-- Changed "Interested Category" to "Product Category" -->
	    <th>Date Registered</th>
	    <th>Action</th>
	  </tr>

	  <?php $seeAllSellers = seeAllSellers($pdo); ?> <!-- Updated to reflect sellers -->
	  <?php foreach ($seeAllSellers as $row) { ?>
	  <tr>
	  	<td><?php echo $row['seller_id']; ?></td> <!-- Changed 'customer_id' to 'seller_id' -->
	  	<td><?php echo $row['first_name']; ?></td>
	  	<td><?php echo $row['last_name']; ?></td>
		  <td><?php echo $row['company_name']; ?></td>
	  	<td><?php echo $row['email']; ?></td>
		<td><?php echo $row['product_category']; ?></td> <!-- Changed 'interested_category' to 'product_category' -->
	  	<td><?php echo $row['date_added']; ?></td>
	  	<td>
    		<a href="editseller.php?seller_id=<?php echo htmlspecialchars($row['seller_id']); ?>">Edit</a> <!-- Updated the edit link -->
    		<a href="deleteseller.php?seller_id=<?php echo htmlspecialchars($row['seller_id']); ?>">Delete</a> <!-- Updated the delete link -->
			<a class="button" href="viewCustomers.php?seller_id=<?php echo htmlspecialchars($row['seller_id']); ?>">View Customers</a>
		</td>
	  </tr>
	  <?php } ?>
	</table>
</body>
</html>
