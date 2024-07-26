<?php
ob_start();
session_start();
require_once('DB_Connection.php');

class Application extends DB_Connection{
	public function __construct(){
		parent::__construct();
	}

	public function allPublishCategories(){
		$sql = "SELECT * FROM tbl_category WHERE status='1'";
		if(mysqli_query($this->db_connect,$sql)){
			return mysqli_query($this->db_connect,$sql);
		}
	}

	public function getProductsByCategoryId($categoryId){
		$sql = "SELECT * FROM tbl_product WHERE category_id='$categoryId'";
		if(mysqli_query($this->db_connect,$sql)){
			return mysqli_query($this->db_connect,$sql);
		}
	}

	public function getAllPublishedManufacturers(){
		$sql = "SELECT * FROM tbl_manufacturer WHERE publication_status='1'";
		if(mysqli_query($this->db_connect,$sql)){
			return mysqli_query($this->db_connect,$sql);
		}
	}

	public function getAllPublishedCategories(){
		$sql = "SELECT * FROM tbl_category WHERE status='1'";
		if(mysqli_query($this->db_connect,$sql)){
			return mysqli_query($this->db_connect,$sql);
		}
	}

	public function getProductDetailsById($productId){
		$sql = "SELECT tbl_product.*, tbl_manufacturer.manufacturer_name FROM tbl_product left join tbl_manufacturer on tbl_manufacturer.manufacturer_id=tbl_product.manufacturer_id WHERE product_id='$productId'";
		$query = mysqli_query($this->db_connect,$sql);
		return mysqli_fetch_assoc($query);
	}
	public function getRecommandedProducts($order){
		if($order == 'ASC'){
			$sql = "SELECT * FROM tbl_product ORDER BY product_id ASC LIMIT 3";
		}else{
			$sql = "SELECT * FROM tbl_product ORDER BY product_id DESC LIMIT 3";
		}

		if(mysqli_query($this->db_connect,$sql)){
			return mysqli_query($this->db_connect,$sql);
		}
	}

	public function addToCart($data){
		$productId = $data['product_id'];
		$sql = "SELECT * FROM tbl_product WHERE product_id='$productId'";
		$query = mysqli_query($this->db_connect,$sql);
		$product = mysqli_fetch_assoc($query);
		$sessionId = session_id();

		$sql = "SELECT * FROM tbl_temp_cart WHERE session_id='$sessionId' AND product_id = '$productId'";
		$query = mysqli_query($this->db_connect,$sql);
		$countExistProduct = mysqli_num_rows($query);

		if($countExistProduct>0){
			$sql = "UPDATE tbl_temp_cart SET quantity='$data[quantity] '  WHERE session_id='$sessionId' AND product_id = '$productId'";
		}else{
			$sql = "INSERT INTO tbl_temp_cart(session_id,product_id,product_name,product_price,product_image,quantity) VALUES('$sessionId','$productId','$product[product_name]','$product[product_price]','$product[product_image]','$data[quantity]')";
		}

		if(mysqli_query($this->db_connect,$sql)){
			header('Location:add_cart.php
				');
		}
	}

	public function getCartProductsBySessionId($sessionId){
		$sql = "SELECT * FROM tbl_temp_cart WHERE session_id='$sessionId'";
		if(mysqli_query($this->db_connect,$sql)){
			return mysqli_query($this->db_connect,$sql);
		}
	}

	public function removeProductFromCartById($cartId){
		$sql = "DELETE FROM tbl_temp_cart WHERE cart_id='$cartId'";
		if(mysqli_query($this->db_connect,$sql)){
			header('Location:add_cart.php
				');
		}

	}

	public function updateProductQuantityByCartId($data){
		$cartId = $data['cart_id'];
		$sql = "UPDATE tbl_temp_cart SET quantity='$data[quantity]' WHERE cart_id = '$cartId'";
		if(mysqli_query($this->db_connect,$sql)){
			header('Location:add_cart.php
				');
		}
	}

	public function getAllProducts(){
		$sql = "SELECT * FROM tbl_product WHERE product_status=1";
		if(mysqli_query($this->db_connect,$sql)){
			return mysqli_query($this->db_connect,$sql);
		}
	}


	public function signupCustomer($data){
		$customerEmail = $data['customer_email'];
		$sql = "SELECT * FROM tbl_customer WHERE customer_email = '$customerEmail'";
		$query = mysqli_query($this->db_connect,$sql);
		$emailExist = mysqli_num_rows($query);
		if($emailExist>0){
			return "Email already exist, please try with another email";
		}

		$customerPassword = md5($data['password']);

		$sql = "INSERT INTO tbl_customer(customer_name,customer_phone,customer_email,password,customer_district,customer_address) VALUES('$data[customer_name]','$data[customer_phone]','$data[customer_email]','$customerPassword','$data[customer_district]','$data[customer_address]')";

		if(mysqli_query($this->db_connect,$sql)){
			$lastInsertedId = mysqli_insert_id($this->db_connect);
			$_SESSION['customer_id'] = $lastInsertedId;
			$_SESSION['customer_name'] = $data['customer_name'];
			header('Location:shipping.php?customer_id='.$lastInsertedId);
		}
	}

	public function customerLogin($data){
		$customerEmail = $data['customer_email'];
		$customerPassword = md5($data['password']);
		$sql = "SELECT * FROM tbl_customer WHERE customer_email='$customerEmail' AND password='$customerPassword'";
		$query = mysqli_query($this->db_connect,$sql);
		$customerExist = mysqli_num_rows($query);
		if($customerExist>0){
			$customer = mysqli_fetch_assoc($query);

			$_SESSION['customer_id'] = $customer['customer_id'];
			$_SESSION['customer_name'] = $customer['customer_name'];
			header('Location:shipping.php?customer_id='.$customer['customer_id']);
		}else{
			return "Invalid credentials";
		}
	}

	public function customerLogout(){
		unset($_SESSION['customer_id']);
		unset($_SESSION['customer_name']);
		header('Location:index.php');
	}

	public function getCustomerInformationById($customerId){
		$sql = "SELECT * FROM tbl_customer WHERE customer_id='$customerId'";
		if(mysqli_query($this->db_connect,$sql)){
			$query = mysqli_query($this->db_connect,$sql);
			return mysqli_fetch_assoc($query);
		}
	}


	public function saveShippingAddress($data){
		// $message = [];
		// if($data['customer_name'] == ''){
		// 	$message['customer_name'] = "customer name is empty";
		// }elseif($data['customer_phone'] == ''){
		// 	$message['customer_phone'] = "customer phone is empty";
		// }

		// if(count($message)>0){
		// 	return $message;
		// }


		$sql = "INSERT INTO tbl_shipping(customer_name,customer_phone,customer_email,customer_district,customer_address) VALUES('$data[customer_name]','$data[customer_phone]','$data[customer_email]','$data[customer_district]','$data[customer_address]')";

		if(mysqli_query($this->db_connect,$sql)){
			$lastInsertedId = mysqli_insert_id($this->db_connect);
			$_SESSION['shipping_id'] = $lastInsertedId;
			header('Location:payment.php');
		}
	}


	public function completeOrder($data){
		$paymentType = $data['payment_type'];
		$orderTotal = $_SESSION['order_total'];
		$customerId = $_SESSION['customer_id'];
		$shippingId = $_SESSION['shipping_id'];
		$sessionId = session_id();

		if($paymentType == 'cash_on_delivery'){
			$sql = "INSERT INTO tbl_order(customer_id,shipping_id,order_total) VALUES('$customerId','$shippingId','$orderTotal')";
			if(mysqli_query($this->db_connect,$sql)){
				$orderId = mysqli_insert_id($this->db_connect);
				$sql = "INSERT INTO tbl_payment(order_id,payment_type) VALUES('$orderId','$paymentType')";
				if(mysqli_query($this->db_connect,$sql)){
					$sql = "SELECT * FROM tbl_temp_cart WHERE session_id='$sessionId'";
					if(mysqli_query($this->db_connect,$sql)){
						$query = mysqli_query($this->db_connect,$sql);
						while ($cart = mysqli_fetch_assoc($query)) {
							$sql = "INSERT INTO tbl_order_details(order_id,product_id,product_name,product_price,product_quantity,product_image) VALUES('$orderId','$cart[product_id]','$cart[product_name]','$cart[product_price]','$cart[quantity]','$cart[product_image]')";
							mysqli_query($this->db_connect,$sql);
						}
						$sql = "DELETE FROM tbl_temp_cart WHERE session_id='$sessionId'";
						if(mysqli_query($this->db_connect,$sql)){
							header('Location:order_complete.php');
						}
					}
				}


			}
		}
	}




}



?>