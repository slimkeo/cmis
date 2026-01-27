<?php
// Database connection
$host = "localhost";
$user = "root"; // Database username
$password = ""; // Database password
$db_name = "uibs"; // Database name

$conn = new mysqli($host, $user, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    $account = $_POST['account'];
    //$account = 11111104;

    // Fetch client details
    $sql = "SELECT id, type,balance,client_id  FROM account WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $account);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $resultData = $result->fetch_assoc();

        // Fetch associated accounts
        $client_id = $resultData['client_id'];
        $accounts_query = "SELECT id, fullname,lastname FROM client WHERE id = ?";
        $stmt2 = $conn->prepare($accounts_query);
        $stmt2->bind_param("i", $client_id);
        $stmt2->execute();
        $accounts_result = $stmt2->get_result();

        $user = $accounts_result->fetch_assoc();

        // Return JSON response
        echo json_encode([
            "status" => "success",
            "user" => $user
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid QR, Account Doesnt Exist"]);
    }

    $stmt->close();
    $conn->close();
?>
