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

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['username'];
    $password = sha1($_POST["password"]);

    // Fetch client details
    $sql = "SELECT fullname,lastname, contact, id, email FROM client WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Fetch associated accounts
        $client_id = $user['id'];
        $accounts_query = "SELECT id, type,balance FROM account WHERE client_id = ?";
        $stmt2 = $conn->prepare($accounts_query);
        $stmt2->bind_param("i", $client_id);
        $stmt2->execute();
        $accounts_result = $stmt2->get_result();

        $accounts = array();
        while ($row = $accounts_result->fetch_assoc()) {
            $accounts[] = $row;
        }

        // Return JSON response
        echo json_encode([
            "status" => "success",
            "user" => $user,
            "accounts" => $accounts
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid login credentials."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
