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
		$query = 'SELECT A.*, AR.AREANAME FROM ANIMAL A INNER JOIN ANIMALENCLOSURE AC ON A.ANIMALID=AC.ANIMALID INNER JOIN AREA AR ON AC.AREAID=AR.AREAID WHERE AREANAME=?';
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
		$query = 'SELECT A.*, AR.AREANAME FROM ANIMAL A INNER JOIN ANIMALENCLOSURE AC ON A.ANIMALID=AC.ANIMALID INNER JOIN AREA AR ON AC.AREAID=AR.AREAID WHERE A.ANIMALID=?';
		$result = $this->database->executeQuery($query, [ $animalId ])->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}
}