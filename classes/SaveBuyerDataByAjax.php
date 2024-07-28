<?php
require_once('./DB_Connection.php');
$dbConnection = new DB_Connection();

if (isset($_POST['save_buyer'])) {
    $response = saveBuyer($_POST, $dbConnection->getDbConnect());
    echo json_encode($response); // Output JSON response
}

function generateHashKey($receiptId, $salt) {
    return hash('sha512', $receiptId . $salt);
}

function saveBuyer($data, $db_connect) {
    // Validation
    $errors = [];

    if (!is_numeric($data['amount']) || $data['amount'] <= 0) {
        $errors[] = 'Amount must be a positive number.';
    }

    if (strlen($data['buyer']) > 20 || !preg_match('/^[\p{L}\p{M}\s\d]+$/u', $data['buyer'])) {
        $errors[] = 'Buyer must be text, spaces, and numbers, not more than 20 characters.';
    }

    if (empty($data['receipt_id'])) {
        $errors[] = 'Receipt ID is required.';
    }

    if (!isset($data['items']) || !is_array($data['items']) || count($data['items']) === 0) {
        $errors[] = 'Items must be provided as a non-empty array.';
    } else {
        // Check each item individually
        foreach ($data['items'] as $item) {
            if (empty($item)) {
                $errors[] = 'All items must be filled up.';
                break;
            }
        }
    }

    if (!filter_var($data['buyer_email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    }

    if (str_word_count($data['note']) > 30) {
        $errors[] = 'Note cannot exceed 30 words.';
    }

    if (strlen($data['city']) > 20 || !preg_match('/^[\p{L}\p{M}\s]+$/u', $data['city'])) {
        $errors[] = 'City must be text and spaces, not more than 20 characters.';
    }

    if (!preg_match('/^880\d{10}$/', $data['phone'])) {
        $errors[] = 'Phone must start with 880 and be exactly 13 digits long (including 880).';
    }

    if (!is_numeric($data['entry_by'])) {
        $errors[] = 'Entry By must be a number.';
    }

    if (!empty($errors)) {
        return ['status' => 'errors', 'errors' => $errors, 'statusCode' => 400]; // 400 = bad request
    }

    // Data sanitization and preparation
    $ipAddress    = $_SERVER['REMOTE_ADDR'];
    $entryAt      = date('Y-m-d');
    $salt         = bin2hex(random_bytes(16));
    $hashKey      = generateHashKey($data['receipt_id'], $salt);
    $encodedItems = json_encode(array_filter($data['items'], 'strlen'));

    try {
        // Prepare SQL statement
        $sql = "INSERT INTO buyers 
                (amount, buyer, receipt_id, items, buyer_email, buyer_ip, note, city, phone, entry_at, entry_by, hash_key) 
                VALUES 
                ('$data[amount]', '$data[buyer]', '$data[receipt_id]', '$encodedItems', '$data[buyer_email]', 
                 '$ipAddress', '$data[note]', '$data[city]', '$data[phone]', '$entryAt', '$data[entry_by]', '$hashKey')";

        // Execute SQL query
        if ($db_connect->query($sql)) {
            return ['status' => 'success', 'message' => 'Buyer saved successfully.', 'statusCode' => 200]; //200 = success
        } else {
            throw new Exception("Error: " . $db_connect->error);
        }
    } catch (Exception $e) {
        return ['status' => 'error', 'message' => $e->getMessage(), 'statusCode' => 500]; //500 = server error
    }
}
?>
