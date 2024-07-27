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

		if (!isset($data['items']) || !is_array($data['items'])) {
			$errors[] = 'Items must be provided as an array.';
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
			$errors[] = 'Phone must be numeric, start with 880 and be exactly 13 digits long (including 880).';
		}

		if (!is_numeric($data['entry_by'])) {
			$errors[] = 'Entry By must be a number.';
		}

		// If there are errors, return them
		if (!empty($errors)) {
			return ['status' => 'errors', 'errors' => $errors];
		}

		$ipAddress    = $_SERVER['REMOTE_ADDR'];
		$entryAt      = date('Y-m-d');
		$salt         = bin2hex(random_bytes(16)); // Generate a random salt : 16 bytes= 32 characters
		$hashKey      = $this->generateHashKey($data['receipt_id'], $salt); // Generate hash key
		$endocedItems = json_encode(array_filter($data['items'], 'strlen')); // items are encoded for json type data

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
				'$data[amount]',
				'$data[buyer]',
				'$data[receipt_id]',
				'$endocedItems',
				'$data[buyer_email]',
				'$ipAddress',
				'$data[note]',
				'$data[city]',
				'$data[phone]',
				'$entryAt',
				'$data[entry_by]',
				'$hashKey'
			)";

			if (mysqli_query($this->db_connect, $sql)) {
				return ['status' => 'success', 'message' => 'Buyer saved successfully'];
			} else {
				throw new Exception("Error: " . mysqli_error($this->db_connect, $sql));
			}
		} catch (Exception $e) {
			http_response_code(500);
			return ['status' => 'error', 'message' => $e->getMessage()];
		}
	}
}
