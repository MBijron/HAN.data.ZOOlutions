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
	
	public function getVeterinaryRecord($animalid)
	{
		$query = 'SELECT V.RECORDDATE, V.NOTES, E.FIRSTNAME, E.LASTNAME, D.DIAGNOSIS, M.MEDICINENAME, P.STARTPRESCRIPTION, P.ENDPRESCRIPTION, P.PRESCRIPTIONID FROM VETERINARYRECORD V INNER JOIN EMPLOYEE E ON V.EMPLOYEEID=E.EMPLOYEEID LEFT JOIN DIAGNOSIS D ON V.DIAGNOSISID=D.DIAGNOSISID LEFT JOIN VETERINARYPRESCRIPTION VP ON V.ANIMALID=VP.ANIMALID AND V.RECORDDATE=VP.RECORDDATE LEFT JOIN PRESCRIPTION P ON VP.PRESCRIPTIONID=P.PRESCRIPTIONID LEFT JOIN MEDICINE M ON P.MEDICINEID=M.MEDICINEID WHERE V.ANIMALID=?';
		$result = $this->database->executeQuery($query, [$animalid])->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}
	
	public function getAllDiagnosis()
	{
		$query = 'SELECT * FROM DIAGNOSIS';
		$result = $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}
	
	public function getAllMedicine()
	{
		$query = 'SELECT * FROM MEDICINE';
		$result = $this->database->executeQuery($query)->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}
	
	public function addVeterinary($animalid, $diagnosis, $medicine, $startdate, $enddate, $notes, $employee)
	{
		$query = 'EXEC SP_InsertVeterinaryRecords ?, ?, ?, ?, ?, ?, ?';
		$this->database->executeQuery($query, [$animalid, $diagnosis, $medicine, $startdate, $enddate, $notes, $employee]);
	}
	
	public function removeVeterinary($animalid, $recorddate, $prescriptionid)
	{
		$query = 'EXEC SP_DeleteVeterinaryRecord ?, ?, ?';
		$this->database->executeQuery($query, [$prescriptionid, $animalid, $recorddate]);
	}
}