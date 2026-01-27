<?php
// Database connection
$host = "localhost";
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "uibs"; // Database name
try {
    // Connect to the database
    $mysqli = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }

    // Start a transaction
    $mysqli->begin_transaction();

    // Input values
     $accountA = $_POST['senderAcc'];
     $accountB = $_POST['recieverAcc'];
     $amount = $_POST['amount'];
   // $accountA = 11111103; // Sender's account ID
   // $accountB = 11111104; // Receiver's account ID
   // $amount = 6; // Amount to transfer

    // Check if Account A has sufficient balance
    $query = "SELECT balance FROM account WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $accountA);
    $stmt->execute();
    $stmt->bind_result($balance);
    $stmt->fetch();
    $stmt->close();

    if ($balance < $amount) {
    	echo json_encode(["status" => "error", "message" => "Insufficient funds in Account"]);
        throw new Exception("Insufficient funds in Account A.");
    }

    // Deduct the amount from Account A
    $query = "UPDATE account SET balance = balance - ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("di", $amount, $accountA);
    $stmt->execute();
    $stmt->close();

    // Add the amount to Account B
    $query = "UPDATE account SET balance = balance + ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("di", $amount, $accountB);
    $stmt->execute();
    $stmt->close();

    $createdate = date("Y-m-d");
	$type = "trasnfer";	
	$user = 1;	
    $location = "";
                // Call the IP-API service for location
            $apiUrl = "http://ip-api.com/json/";
            $response = file_get_contents($apiUrl);
            if ($response !== false) {
                $data = json_decode($response, true);

                // Output the town/city
                if (isset($data['city'])) {
                     $location=$data['city'].",".$data['country'];
                } else {
                     $location= "Could not determine the location.";
                }
            } else {
                 $location= "Failed to retrieve data from the geolocation API.";
            }

    // Insert transaction record
    $query = "INSERT INTO transaction (account_id, related_account_id, amount, type, createdate,user,location) VALUES (?, ?, ?, ?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("iidssis", $accountA, $accountB, $amount,$type,$createdate,$user,$city);
    $stmt->execute();
    $stmt->close();

    // Commit the transaction
    $mysqli->commit();

    echo json_encode(["status" => "success", "message" => "Successful Transaction"]);
} catch (Exception $e) {
    // Rollback the transaction in case of an error
    $mysqli->rollback();
    echo "Transaction failed: " . $e->getMessage();
} finally {
    // Close the connection
    $mysqli->close();
}
?>
