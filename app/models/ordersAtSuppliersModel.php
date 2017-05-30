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
						INNER JOIN SUPPLIER S ON O.SUPPLIERID = S.SUPPLIERID";
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
			$query = "	SELECT O.ORDERID, F.FOODID, F.FOODNAME, O.AMOUNTORDERED, F.UNIT
						FROM ORDERROW O
							INNER JOIN FOOD F ON O.FOODID = F.FOODID
						WHERE ORDERID = ?";
			return $this->database->executeQuery($query, [$id])->fetchAll(PDO::FETCH_OBJ);
		}

	}

?>