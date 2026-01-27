<?php
// auth.php

// Database connection
$host = "localhost";
$user = "snatbur1_user";
$pass = "Snatburial2025!";
$dbname = "snatbur1_db";
//$dbname = "snatburial";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fullname = "";
$message = "";
$need_mtn = false;  
$record_id = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // STEP 2: SAVE NEW MTN NUMBER
    if (isset($_POST['new_mtn']) && isset($_POST['record_id'])) {

        $new_mtn = trim($_POST['new_mtn']);
        $record_id = intval($_POST['record_id']);

        // validation
        // clean input: remove any non-digit characters (spaces, +, etc.)
        $new_mtn = preg_replace('/\D/', '', trim($_POST['new_mtn']));

        // validation: must be exactly 11 digits and start with 26876 or 26878
        if (!preg_match('/^268(76|78)[0-9]{6}$/', $new_mtn)) {
            $message = "Invalid MTN number! Must start with 26876 or 26878 and be 11 digits (e.g. 268761234567).";
            $need_mtn = true;
        } else {

            // check if exists
            $chk_sql = "SELECT id FROM attendance WHERE momo = '$new_mtn' LIMIT 1";
            $chk = $conn->query($chk_sql);

            if (!$chk) {
                die("SQL ERROR: " . $conn->error . " | QUERY: " . $chk_sql);
            }

            if ($chk->num_rows > 0) {
                $message = "This number already exists!";
                $need_mtn = true;
            } else {
                // update record
                $update_sql = "UPDATE attendance SET momo='$new_mtn', status=1 WHERE id=$record_id";
                if (!$conn->query($update_sql)) {
                    die("SQL ERROR: " . $conn->error . " | QUERY: " . $update_sql);
                }
                $message = "Number updated and authentication successful!";
            }
        }

    } else {

        // STEP 1: OTP CHECK
        $otp = trim($_POST['otp']);
        $otp = $conn->real_escape_string($otp);

        $sql = "SELECT id, fullname, status, momo FROM attendance WHERE otp = '$otp' LIMIT 1";
        $result = $conn->query($sql);

        if (!$result) {
            die("SQL ERROR: " . $conn->error . " | QUERY: " . $sql);
        }

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            $fullname = $row['fullname'];
            $record_id = $row['id'];
            $cell = $row['momo'];

            if (preg_match('/^26879/', $cell)) {
                $message = "Your SWAZI MOBILE number is not allowed. Please enter an MTN MOMO number";
                $need_mtn = true;
            }
            else {
                if ($row['status'] == 1) {
                    $message = "Member already authenticated!";
                } else {
                    $update_sql = "UPDATE attendance SET status=1 WHERE id=$record_id";
                    if (!$conn->query($update_sql)) {
                        die("SQL ERROR: " . $conn->error . " | QUERY: " . $update_sql);
                    }
                    $message = "Authentication successful!";
                }
            }

        } else {
            $message = "OTP not found!";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Member Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Member Authentication</h4>
                </div>
                <div class="card-body">

                    <?php if ($message): ?>
                        <div class="alert alert-warning"><?php echo $message; ?></div>
                    <?php endif; ?>

                    <?php if ($fullname): ?>
                        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($fullname); ?></p>
                    <?php endif; ?>

                    <?php if ($need_mtn): ?>
                        <!-- FORM TO COLLECT MTN NUMBER -->
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Enter MTN Cell Number (26876 / 26878)</label>
                        <input type="text"
                               class="form-control"
                               name="new_mtn"
                               maxlength="11"
                               minlength="11"
                               pattern="268[0-9]{8}"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                               placeholder="268XXXXXXXX"
                               title="Eswatini number must start with 268 and be 11 digits (e.g., 26876123456)"
                               required>
                            </div>
                            <input type="hidden" name="record_id" value="<?php echo $record_id; ?>">
                            <button type="submit" class="btn btn-warning w-100">
                                Update Number & Authenticate
                            </button>
                        </form>

                    <?php else: ?>
                        <!-- NORMAL OTP FORM -->
                        <form method="post">
                            <div class="mb-3">
                                <label for="otp" class="form-label">Enter OTP</label>
                                <input type="text" class="form-control" id="otp" name="otp" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Authenticate</button>
                        </form>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
