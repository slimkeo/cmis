<?php
// Get the client's IP address

// Replace 'YOUR_IP' with the actual IP for testing if running locally

function getUserIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // IP from shared internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
        echo $ip;
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // IP passed from a proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
         echo $ip;
    } else {
        // Default IP from remote address
        $ip = $_SERVER['REMOTE_ADDR'];
         echo $ip;
    }
    return $ip;
}


function returnLocation() {
              //  $ip= getUserIpAddr();
            //$ip = "147.135.37.178";


            // Call the IP-API service
            $apiUrl = "http://ip-api.com/json/";
            $response = file_get_contents($apiUrl);

            // Check if the API call was successful
            if ($response !== false) {
                $data = json_decode($response, true);

                // Output the town/city
                if (isset($data['city'])) {
                    echo "The town/city of IP address is: " . $data['city'].",".$data['country'];
                } else {
                    echo "Could not determine the location.";
                }
            } else {
                echo "Failed to retrieve data from the geolocation API.";
            }
   // return $ip;
}
returnLocation();

?>
