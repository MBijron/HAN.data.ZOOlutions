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
			$query = "SELECT * FROM [ORDER]";
			return $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		}

	}

?>