<?php
  // Create a database connection
  $dbhost = "localhost";
  $dbuser = "root"; // please place the user name here
  $dbpass = "Sj890905"; // please place the password here
  $dbname = "client_report";
  $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  // Test if connection succeeded
  if(mysqli_connect_errno()) {
    die("Database connection failed: " . 
         mysqli_connect_error() . 
         " (" . mysqli_connect_errno() . ")"
    );
  } else {
  	echo("Customer transaction report:");
  }
?>
<?php
	//Perform database query
	$query  = "SELECT t.tran_date, c.name, COUNT(*) AS 'total_trans' ";
	$query .= "FROM client_report.transaction t ";
	$query .= "JOIN client_report.client c ON c.id = t.client_id ";
	$query .= "GROuP BY t.tran_date, t.client_id ";
	$query .= "ORDER BY t.tran_date DESC";
	$result = mysqli_query($connection, $query);
	// Test if there was a query error
	if (!$result) {
		die("Database query failed.");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
	<head>
		<title>Databases</title>
	</head>
	<body>
		
		<ul>
		<?php
			$date = null;
			//Use returned data (if any)
			while($subject = mysqli_fetch_assoc($result)) {
				$recordDate = $subject["tran_date"];			
				if(null != $recordDate && ($date == null || $date != $recordDate)) {				
					$date = $recordDate;
		?>
				<li><?php echo $recordDate ?></li>
		<?php
				}
				$totalTrans = $subject["total_trans"];
				$totalAmountDue = 0;
				if(null != $totalTrans) {
					if($totalTrans > 50) {
						$totalAmountDue = 0.75*($totalTrans - 50) + 0.50*50;
					} else {
						$totalAmountDue = 0.50*$totalTrans;
					}
				}	
		?>
				<li><?php echo "Client ". $subject["name"] . ": " . $totalAmountDue ?></li>
	  	<?php
			}
		?>
		</ul>
		
		<?php
		  // Release returned data
		  mysqli_free_result($result);
		?>
	</body>
</html>

<?php
  // Close database connection
  mysqli_close($connection);
?>