<?php

require_once('DB_Connection.php');

class Application extends DB_Connection
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getAllBuyers()
	{
		$sql = "SELECT * FROM buyers";
		if (mysqli_query($this->db_connect, $sql)) {
			return mysqli_query($this->db_connect, $sql);
		}
	}

	public function generateHashKey($receiptId, $salt)
	{
		return hash('sha512', $receiptId . $salt);
	}

	public function saveBuyer($data)
	{
		// Fetch and sanitize POST data
		$amount     = isset($data['amount']) ? intval($data['amount']) : '';
		$buyer      = isset($data['buyer']) ? trim($data['buyer']) : '';
		$receiptId  = isset($data['receipt_id']) ? trim($data['receipt_id']) : '';
		$items      = isset($data['items']) ? $data['items'] : [];
		$buyerEmail = isset($data['buyer_email']) ? trim($data['buyer_email']) : '';
		$note       = isset($data['note']) ? trim($data['note']) : '';
		$city       = isset($data['city']) ? trim($data['city']) : '';
		$phone      = isset($data['phone']) ? trim($data['phone']) : '';
		$entryBy    = isset($data['entry_by']) ? intval($data['entry_by']) : '';
		$ipAddress  = $_SERVER['REMOTE_ADDR'];
		$entryAt    = date('Y-m-d');

		// Validation
		if (!is_numeric($amount) || $amount <= 0) {
			$errors[] = 'Amount must be a positive number.';
		}

		if (strlen($buyer) > 20 || !preg_match('/^[\p{L}\p{M}\s\d]+$/u', $buyer)) {
			$errors[] = 'Buyer must be text, spaces, and numbers, not more than 20 characters.';
		}

		if (empty($receiptId)) {
			$errors[] = 'Receipt ID is required.';
		}

		if (!is_array($items) || empty($items)) {
			$errors[] = 'Items must be a non-empty array.';
		}

		if (!filter_var($buyerEmail, FILTER_VALIDATE_EMAIL)) {
			$errors[] = 'Invalid email address.';
		}

		if (str_word_count($note) > 30) {
			$errors[] = 'Note cannot exceed 30 words.';
		}

		if (strlen($city) > 20 || !preg_match('/^[\p{L}\p{M}\s]+$/u', $city)) {
			$errors[] = 'City must be text and spaces, not more than 20 characters.';
		}

		if (!preg_match('/^880\d+$/', $phone)) {
			$errors[] = 'Phone must be numeric and start with 880.';
		}

		if (!is_numeric($entryBy)) {
			$errors[] = 'Entry By must be a number.';
		}

		// If there are errors, return them
		if (!empty($errors)) {
			http_response_code(400);
			return json_encode(['status' => 'error', 'errors' => $errors]);
		}

		$salt         = bin2hex(random_bytes(16)); // Generate a random salt : 16 bytes= 32 characters
		$hashKey      = $this->generateHashKey($receiptId, $salt); // Generate hash key
		$endocedItems = json_encode($items); // items are encoded for json type data

		try {

			$sql = "INSERT INTO 
			buyers(
				amount,
				buyer,	
				receipt_id,	
				items,	
				buyer_email,	
				buyer_ip,
				note,	
				city,
				phone,	
				entry_at,	
				entry_by,
				hash_key

			) VALUES(
				'$amount',
				'$buyer',
				'$receiptId',
				'$endocedItems',
				'$buyerEmail',
				'$ipAddress',
				'$note',
				'$city',
				'$phone',
				'$entryAt',
				'$entryBy',
				'$hashKey'
			)";

			if (mysqli_query($this->db_connect, $sql)) {
				return json_encode(['status' => 'success', 'message' => 'Buyer saved successfully']);
			} else {
				throw new Exception("Error: " . mysqli_error($this->db_connect, $sql));
			}
		} catch (Exception $e) {
			http_response_code(500);
			return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
		}
	}
}
