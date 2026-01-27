<?php
// Database credentials
$host = 'localhost';
$dbname = 'uibs';
$username = 'root';
$password = '';

//$client_id = 1012; // Replace with the specific client ID
$client_id = $_POST['client_id']; // Replace with the specific client ID

try {
        // Create a new PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to calculate total spending and income adjustments
        $query = "
            SELECT 
                c.id,
                c.salary,
                SUM(CASE 
                    WHEN t.type IN ('withdraw', 'transfer', 'loan_repayment') 
                        AND t.account_id = a.id THEN t.amount
                    ELSE 0 
                END) AS total_spending,
                SUM(CASE 
                    WHEN t.type IN ('deposit') 
                          OR (t.type = 'transfer' AND t.related_account_id = a.id) THEN t.amount
                    ELSE 0 
                END) AS total_income_adjustments
            FROM 
                client c
            JOIN 
                account a ON c.id = a.client_id
            JOIN 
                transaction t ON a.id = t.account_id
            WHERE 
                c.id = :client_id
            GROUP BY 
                c.id;
        ";
            // Prepare and execute the query  WHEN t.type IN ('deposit', 'loan_disbursement') 
        $stmt = $pdo->prepare($query);
        $stmt->execute(['client_id' => $client_id]);

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {

            $total_spending = $result['total_spending'];
            $total_income_adjustments = $result['total_income_adjustments'];
            // get income value (c from another source)
            $income = $result['salary']; + $total_income_adjustments; // Adjust income by adding income adjustments
                $data = array(
                        "income" => $income,
                        "total_spending" => $total_spending
                );
                // Define the API endpoint URL
                $url = 'http://127.0.0.1:8000/predict/';

                // Prepare data to send (example)
/*                $data = array(
                    "income" => 5000000,
                    "total_spending" => 4000
                );*/

                // Encode the data into JSON format
                $json_data = json_encode($data);

                // Initialize cURL session
                $ch = curl_init($url);

                // Set cURL options
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($json_data)
                ));

                // Execute the cURL request and get the response
                $response = curl_exec($ch);

                // Check for errors in cURL request
                if ($response === false) {
                    echo json_encode(["error" => curl_error($ch)]);
                }

                // Close cURL session
                curl_close($ch);
                echo $response;
        }

} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}

?>
