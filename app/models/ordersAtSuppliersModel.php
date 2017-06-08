<?php
	class ordersAtSuppliersModel extends model {

		public function __construct()
		{
			parent::__construct();
		}
		
		public function register()
		{
			
		}

		public function getOrdersAtSuppliers() {
			$query = "	SELECT O.ORDERID, O.SUPPLIERID, S.SUPPLIERNAME, O.DELIVERYDATE, O.STATUS FROM [ORDER] O
						INNER JOIN SUPPLIER S ON O.SUPPLIERID = S.SUPPLIERID
						ORDER BY O.DELIVERYDATE DESC";
			return $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		}

		public function getOrderDetails($id) {
			$query = "	SELECT O.ORDERID, O.SUPPLIERID, O.ORDERDATE, O.DELIVERYDATE, O.STATUS, S.SUPPLIERNAME, S.ZIPCODE, S.HOUSENR, S.TELEPHONENR
						FROM [ORDER] O
							INNER JOIN SUPPLIER S ON O.SUPPLIERID = S.SUPPLIERID
						WHERE ORDERID = ?";
			return $this->database->executeQuery($query, [$id])->fetchAll(PDO::FETCH_OBJ);
		}

		public function getOrderRows($id) {
			$query = "	SELECT O.ORDERID, F.FOODID, F.FOODNAME, O.AMOUNTORDERED, O.AMOUNTDELIVERED, O.UNIT
						FROM ORDERROW O
							INNER JOIN FOOD F ON O.FOODID = F.FOODID
						WHERE ORDERID = ?";
			return $this->database->executeQuery($query, [$id])->fetchAll(PDO::FETCH_OBJ);
		}

		public function markAsReceived($orderID, $permission) {
			$query = $permission . "	UPDATE [ORDER]
						SET STATUS = 'Received', DELIVERYDATE = GETDATE()
						WHERE ORDERID = ?";
			$this->database->executeQuery($query, [$orderID]);
		}

		public function markAsPayed($orderID, $permission) {
			$query = $permission . "	UPDATE [ORDER]
						SET STATUS = 'Payed'
						WHERE ORDERID = ?";
			$this->database->executeQuery($query, [$orderID]);
		}

		public function insertDeliveredSupplies($supplies, $permission) {
			$this->markAsReceived($supplies[0][0]);

			for ($i=0; $i < count($supplies); $i++) { 
				$query = $permission . "	UPDATE ORDERROW
							SET AMOUNTDELIVERED = (SELECT AMOUNTDELIVERED FROM ORDERROW WHERE ORDERID = ? AND FOODID = ?) + ?
							WHERE ORDERID = ? AND FOODID = ?";
				$this->database->executeQuery($query, [ $supplies[$i][0], $supplies[$i][1], $supplies[$i][2], $supplies[$i][0], $supplies[$i][1] ]);
			}

			$sp = "EXEC CheckGoods ?";
			$this->database->executeQuery($sp, [ $supplies[0][0] ]);
		}

		public function setNewDeliveryDate($orderID, $deliveryDate, $permission) {
			$query = $permission . "	UPDATE [ORDER]
						SET DELIVERYDATE = ?, STATUS = 'Awaiting delivery'
						WHERE ORDERID = ?";
			$this->database->executeQuery($query, [$deliveryDate, $orderID]);
		}

		public function createNewOrder($orderID, $employeeID, $name, $permission) {
			$query = $permission . "	EXEC CombineIncompleteGoods ?, ?, ?";
			$this->database->executeQuery($query, [$orderID, $employeeID, $name]);

			$query = $permission . "EXEC DeleteIncompleteGoods ?";
			$this->database->executeQuery($query, [$orderID]);
		}

	}

?>