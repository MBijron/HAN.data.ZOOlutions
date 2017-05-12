<?PHP
	class formModel extends model
	{
		private $baseTable;
		private $baseDatabase;
		
		public function register($table)
		{
			$this->baseTable = $table;
			$this->baseDatabase = Database::Get('database');
		}
	
		public function getTableContents($selectFields)
		{
			$columns = $this->generate($this->baseTable, $this->baseDatabase, $selectFields);
			$foreignKeys = $this->getForeignKeys($this->baseTable, $this->baseDatabase);
			$primaryKeys = $this->getPrimaryKeys($this->baseTable, $this->baseDatabase);
			$tables = $this->getTables($this->baseTable, $columns, $primaryKeys, $foreignKeys, $selectFields);
			$sql = $this->getTableContentsQuery($this->baseTable, $tables);
			$result = $this->database->executeQuery($sql);
			$items = $result->fetchALL(PDO::FETCH_OBJ);
			return $items;
		}
		
		private function getTableContentsQuery($table, $tables)
		{
			$letter = ord('a');
			$i = 0;
			$dictionary = [];
			
			$statements = '';
			$joins = '';
			$where = '';
			
			foreach($tables->FOREIGN_KEYS as $key)
			{
				if(isset($dictionary[$key->COLUMN_NAME.'.'.$key->TABLE_NAME]))
				{
					$temp = chr($letter + $i);
				}
				else
				{
					$temp = chr($letter + $i);
					$dictionary[$key->COLUMN_NAME.'.'.$key->REFERENCED_TABLE_NAME] = $temp;
					$i++;
				}
				if($key->IS_NULLABLE != 'YES')
				{
					$joins .= 'INNER JOIN ' . $key->REFERENCED_TABLE_NAME . ' AS ' . $temp . ' ON `' . $key->TABLE_NAME . '`.`' . $key->COLUMN_NAME . '`=`' . $temp . '`.`' . $key->REFERENCED_COLUMN_NAME . '` ';
				}
			}
			
			$selectors =  $this->getStatements($tables->SELECTORS, $dictionary, $table);
			$statements = 'SELECT ' . $selectors . ' FROM ' . $tables->TABLE_NAME . ' ';
			return $statements . $joins . $where;
		}
		
		private function getStatements($selectors, $dictionary, $table)
		{
			$string = '';
			foreach($selectors as $selector)
			{
				if($selector->SENDER)
				{
					$string .= '`'.$dictionary[$selector->SENDER.'.'.$selector->TABLE_NAME].'`.`'.$selector->COLUMN_NAME.'`, ';
				}
				else
				{
					$string .= '`'.$table.'`.`'.$selector->COLUMN_NAME.'`, ';
				}
			}
			return substr($string, 0, strlen($string) - 2);
		}
		
		private function getTables($table, $columns, $primaryKeys, $foreignKeys, $selectFields)
		{
			$object = new stdClass();
			$object->TABLE_NAME = $table;
			$object->IS_SELECT = false;
			$object->FOREIGN_KEYS = [];
			$object->SELECTORS = [];
			
			foreach($columns->inputs as $column)
			{
				$foreignKey = $this->getForeignKey($column, $foreignKeys);
				$primaryKey = $this->getPrimaryKey($column, $primaryKeys);
								
				if($foreignKey != null)
				{
					array_push($object->FOREIGN_KEYS, $foreignKey);
				}
				if($column->IN_FORM)
				{
					array_push($object->SELECTORS, $column);
				}
			}
			return $object;
		}
		
		private function generate($table, $database, $selectFields = [], $selectIndex = -1, $processedTables = [], $sender = null)
		{
			$columns = new stdClass();
			$columns->inputs = [];
			$columns->selects = [];
			$foreignKeys = $this->getForeignKeys($table, $database);
			$primaryKeys = $this->getPrimaryKeys($table, $database);
			$items = array_merge($foreignKeys, $primaryKeys);
			$items = $this->getColumns($table, $database, $items);
			
			if($selectIndex != -1)
				$columns->selects[$selectFields[$selectIndex]->name] = $this->getSelectItems($table, $items, $primaryKeys, $foreignKeys, $sender);
			else
				$this->addToArray($columns->inputs, $this->getColumnItems($items, $primaryKeys, $foreignKeys, $sender));
			
			array_push($processedTables, $sender.'.'.$table);
			
			if($selectIndex == -1)
			{
				foreach($foreignKeys as $key)
				{
					if(!in_array($key->COLUMN_NAME.'.'.$key->REFERENCED_TABLE_NAME, $processedTables))
					{
						$index = $this->isSelectBox($table, $key->COLUMN_NAME, $selectFields);
						if($index != -1)
						{
							$refKeys = $this->generate($key->REFERENCED_TABLE_NAME, $database, $selectFields, $index, $processedTables, $key->COLUMN_NAME);
							$this->addToArray($columns->selects, $refKeys->selects);
						}
						else
						{
							$refKeys = $this->generate($key->REFERENCED_TABLE_NAME, $database, $selectFields, $index, $processedTables, $key->COLUMN_NAME);
							$this->addToArray($columns->inputs, $refKeys->inputs);
						}
					}
				}
			}
			return $columns;
		}
		
		private function getColumnItems($columns, $primaryKeys, $foreignKeys, $sender)
		{
			$editedColumns = [];
			foreach($columns as $column)
			{
				$column->IS_PRIMARY_KEY = false;
				$column->IS_FOREIGN_KEY = false;
				$column->SENDER = $sender;
				$primaryKey = $this->getPrimaryKey($column, $primaryKeys);
				$foreignKey = $this->getForeignKey($column, $foreignKeys);
				if($primaryKey != null)
				{
					$column->IS_PRIMARY_KEY = true;
				}
				if($foreignKey != null)
				{
					$column->IS_FOREIGN_KEY = true;
					$column->CONSTRAINT_NAME = $foreignKey->CONSTRAINT_NAME;
					$column->REFERENCED_TABLE_SCHEMA = $foreignKey->REFERENCED_TABLE_SCHEMA;
					$column->REFERENCED_TABLE_NAME = $foreignKey->REFERENCED_TABLE_NAME;
					$column->REFERENCED_COLUMN_NAME = $foreignKey->REFERENCED_COLUMN_NAME;
				}
				array_push($editedColumns, $column);
			}
			return $editedColumns;
		}
		
		private function getPrimaryKey($column, $primaryKeys)
		{
			foreach($primaryKeys as $key)
			{
				if($column->TABLE_NAME == $key->TABLE_NAME && $column->COLUMN_NAME == $key->COLUMN_NAME)
				{
					return $key;
				}
			}
			return null;
		}
		
		private function getForeignKey($column, $foreignKeys)
		{
			foreach($foreignKeys as $key)
			{
				if($column->TABLE_NAME == $key->TABLE_NAME && $column->COLUMN_NAME == $key->COLUMN_NAME)
				{
					$key->IS_NULLABLE = $column->IS_NULLABLE;
					return $key;
				}
			}
			return null;
		}
		
		private function getSelectItems($table, $items, $primaryKeys, $foreignKeys, $sender)
		{
			$object = new stdClass();
			$object->columns = $this->getColumnItems($items, $primaryKeys, $foreignKeys, $sender);
			$object->contents = [];
			$query = 'SELECT * FROM `'.$table.'`';
			$result = $this->database->executeQuery($query);
			$contents = $result->fetchAll(PDO::FETCH_ASSOC);
			foreach($contents as $content)
			{
				$contentsObject = new stdClass();
				foreach($content as $key => $value)
				{
					$contentsObject->$key = $value;
				}
				array_push($object->contents, $contentsObject);
			}
			return $object;
		}
		
		private function isSelectBox($table, $column, $selectFields)
		{
			for($i = 0; $i < count($selectFields); $i++)
			{
				if($table == $selectFields[$i]->table && $column == $selectFields[$i]->column)
				{
					return $i;
				}
			}
			return -1;
		}
		
		private function addToArray(&$array, $items)
		{
			foreach($items as $key => $value)
			{
				//array_push($array, $item);
				if(isset($array[$key]))
				{
					array_push($array, $value);
				}
				else
				{
					$array[$key] = $value;
				}
			}
		}
		
		private function getForeignKeys($table, $database)
		{
			$query = 'SELECT * FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME IS NOT NULL AND TABLE_NAME = ? AND TABLE_SCHEMA = ?';
			$result = $this->database->executeQuery($query, [ $table, $database ]);
			$keys = $result->fetchAll(PDO::FETCH_OBJ);
			return $keys;
		}
		
		private function getPrimaryKeys($table, $database)
		{
			$query = 'SELECT * FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k USING(constraint_name,table_schema,table_name) WHERE t.constraint_type=\'PRIMARY KEY\' AND t.table_name=? AND t.table_schema = ?';
			$result = $this->database->executeQuery($query, [ $table, $database ]);
			$keys = $result->fetchAll(PDO::FETCH_OBJ);
			return $keys;
		}
		
		private function getColumns($table, $database, $exceptions)
		{
			$query = 'select * from information_schema.columns t WHERE t.table_name=? AND t.table_schema = ?';
			$result = $this->database->executeQuery($query, [ $table, $database ]);
			$keys = $result->fetchAll(PDO::FETCH_OBJ);
			$filteredKeys = [];
			foreach($keys as $key)
			{
				$inForm = true;
				foreach($exceptions as $column)
				{
					if($key->COLUMN_NAME == $column->COLUMN_NAME)
					{
						$inForm = false;
					}
				}
				if($inForm) 
				{
					$key->IN_FORM = true;
				}
				else
				{
					$key->IN_FORM = false;
				}
					
				array_push($filteredKeys, $key);
			}
			return array_values($filteredKeys);
		}
		
		public function newFormException($table, $column, $name)
		{
			$object = new stdClass();
			$object->table = $table;
			$object->column = $column;
			$object->name = $name;
			return $object;
		}
	}