<?PHP
class OrderCombinedModel extends model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function register()
	{
		
	}
	
	public function RemoveFoodFromOrderRequest($itemArray, $permission)
	{
		$food = $this->getFoodList($itemArray);
		foreach($food as $foodName => $quantity)
		{
			$query = 'EXEC dbo.RemoveFromOrderRequests ?, ?';
			$result = $this->database->executeQuery($query, [ $foodName, $quantity ]);
		}
	}
	
	public function createOrder($supplierName, $items, $permission)
	{
		$query = 'INSERT INTO [ORDER] (SUPPLIERID, ORDERDATE, DELIVERYDATE, [STATUS])
					OUTPUT inserted.ORDERID
					VALUES ((SELECT SUPPLIERID FROM SUPPLIER WHERE SUPPLIERNAME = ?), ?, ?, ?)';
		$stm = $this->database->executeQuery($query, [ $supplierName, date('Y-m-d', strtotime(date('Y-m-d'))), $items[0]->Date, 'Awaiting delivery' ]);
		$result = $stm->fetch(PDO::FETCH_NUM)[0];

		foreach($items as $item)
		{
			$subquery = 'INSERT INTO ORDERROW (ORDERID, FOODID, UNIT, AMOUNTORDERED, AMOUNTDELIVERED)
						VALUES (?, (SELECT FOODID FROM FOOD WHERE FOODNAME = ?), ?, ?, 0)';
			$this->database->executeQuery($subquery, [ $result, $item->Foodname, 'kg', $item->Quantity ]);
		}
	}
	
	private function getFoodList($itemArray)
	{
		$combinedArray = [];
		foreach($itemArray as $superKey => $superValue)
		{
			foreach($superValue as $key => $value)
			{
				if(!array_key_exists($value->Foodname, $combinedArray))
				{
					$combinedArray[$value->Foodname] = $value->Quantity;
				}
				else
				{
					$combinedArray[$value->Foodname] += $value->Quantity;
				}
			}
		}
		return $combinedArray;
	}
	
	public function getSupplierList($itemArray)
	{
		$orderArray = [];
		foreach($itemArray as $superKey => $superValue)
		{
			foreach($superValue as $key => $value)
			{
				if(!array_key_exists($value->Supplier, $orderArray))
				{
					$orderArray[$value->Supplier] = [];
				}
				array_push($orderArray[$value->Supplier], $value);
			}
		}
		return $orderArray;
	}
	
	public function sortPostData()
	{
		$itemArray = [];
		foreach($_POST as $key => $value)
		{
			$splittedKey = explode('_', $key);
			$name = $splittedKey[0];
			$type = $splittedKey[1];
			$index = $splittedKey[2];
			if(count($splittedKey) == 3)
			{
				if(!array_key_exists($name, $itemArray))
				{
					$itemArray[$name] = [];
				}
				if(!array_key_exists($index, $itemArray[$name]))
				{
					$itemArray[$name][$index] = new stdClass();
				}
				$itemArray[$name][$index]->{$type} = $value;
			}
		}
		return $this->combineSortedData($this->filterSortedData($itemArray));
	}
	
	private function filterSortedData($itemArray)
	{
		foreach($itemArray as $superKey => $superValue)
		{
			foreach($superValue as $key => $value)
			{
				$properties = ['Foodname', 'Quantity', 'Supplier', 'Date'];
				foreach($properties as $property)
				{
					if(!isset($value->{$property}))
					{
						unset($itemArray[$superKey][$key]);
						continue;
					}
					if($value->Quantity == '' || $value->Quantity == 0)
					{
						unset($itemArray[$superKey][$key]);
						continue;
					}
				}
			}
		}
		return $itemArray;
	}
	
	private function combineSortedData($itemArray)
	{
		foreach($itemArray as $superKey => $superValue)
		{
			foreach($superValue as $key => $value)
			{
				foreach($superValue as $key2 => $value2)
				{
					if($value->Supplier == $value2->Supplier && $value->Foodname == $value2->Foodname && $value->Date == $value2->Date && $key != $key2 && $key > $key2)
					{
						$value->Quantity += $value2->Quantity;
						unset($itemArray[$superKey][$key2]);
					}
				}
			}
			$itemArray[$superKey] = array_values($itemArray[$superKey]);
		}
		return $itemArray;
	}
}
