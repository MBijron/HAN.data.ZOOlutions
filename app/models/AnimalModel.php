<?PHP
class AnimalModel extends model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function register()
	{
		
	}
	
	public function areaExists($areaName)
	{
		$query = 'SELECT COUNT(*) FROM AREA WHERE AREANAME=?';
		$result = $this->database->executeQuery($query, [ $areaName ])->fetch(PDO::FETCH_NUM);
		return $result[0] == 1;
	}
	
	public function getAnimalsOfArea($areaName)
	{
		$query = '	SELECT A.*, AR.AREANAME, S.SPECIESEN
					FROM ANIMAL A 
						INNER JOIN (SELECT * FROM ANIMALENCLOSURE A 
									WHERE A.STARTDATE = (	SELECT MAX(STARTDATE) FROM ANIMALENCLOSURE A2 
															WHERE A2.ANIMALID=A.ANIMALID)) AC 
								ON A.ANIMALID=AC.ANIMALID 
						INNER JOIN AREA AR ON AC.AREAID=AR.AREAID
						INNER JOIN SPECIES S ON A.SPECIESID = S.SPECIESID
					WHERE AREANAME = ?';
		$result = $this->database->executeQuery($query, [ $areaName ])->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}
	
	public function animalExists($animalId)
	{
		$query = 'SELECT COUNT(*) FROM ANIMAL WHERE ANIMALID=?';
		$result = $this->database->executeQuery($query, [ $animalId ])->fetch(PDO::FETCH_NUM);
		return $result[0] == 1;
	}
	
	public function getAnimal($animalId)
	{
		$query = '	SELECT A.*, AR.AREANAME, S.SPECIESEN
					FROM ANIMAL A 
						INNER JOIN ANIMALENCLOSURE AC ON A.ANIMALID = AC.ANIMALID 
						INNER JOIN AREA AR ON AC.AREAID = AR.AREAID 
						INNER JOIN SPECIES S ON A.SPECIESID = S.SPECIESID
					WHERE A.ANIMALID=?';
		$result = $this->database->executeQuery($query, [ $animalId ])->fetchObject();
		return $result;
	}
	
	public function getAnimalNutrition($animalId)
	{
		$query = 'SELECT D.DIETSTART, D.AMOUNT, F.FOODNAME, F.UNIT, (IIF((SELECT MAX(DIETSTART) FROM DIET WHERE ANIMALID=D.ANIMALID)=D.DIETSTART, 1, 0)) AS currentDiet FROM DIET D INNER JOIN FOOD F ON D.FOODID=F.FOODID INNER JOIN ANIMAL A ON D.ANIMALID=A.ANIMALID WHERE A.ANIMALID=? ORDER BY D.DIETSTART DESC';
		$result = $this->database->executeQuery($query, [ $animalId ])->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}
	
	public function getAllAnimalFood()
	{
		$query = 'SELECT * FROM FOOD';
		$result = $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}
	
	public function addAnimalFood($animalId, $foodid, $foodamount, $startdate)
	{
		$query = 'INSERT INTO DIET (ANIMALID, FOODID, DIETSTART, AMOUNT) VALUES (?, ?, ?, ?)';
		$this->database->executeQuery($query, [$animalId, $foodid, $startdate, $foodamount]);
	}
	
	public function deleteAnimalFood($dietstart, $foodname, $amount, $animalid)
	{
		$query = 'DELETE FROM DIET WHERE DIETSTART=? AND FOODID=(SELECT FOODID FROM FOOD WHERE FOODNAME=?) AND AMOUNT=? AND ANIMALID=?';
		$this->database->executeQuery($query, [$dietstart, $foodname, $amount, $animalid]);
	}
}