<?PHP
	class Animals extends Controller
	{	
		public function index($area)
		{
			if (!isset($_SESSION['user'])) {
				header("Location: /login?logout=false");
			}

			$animalModel = $this->model('AnimalModel');

			if($animalModel->areaExists($area))
			{
				$animals = $animalModel->getAnimalsOfArea($area);
				$menuModel = $this->model('MenuModel');
				$this->view('general/menu', ['menu_items' => $menuModel->items, 'userInfo' => $_SESSION['user']]);
				$this->view('general/backtotop');
				$this->view('animals/index', ['area' => $area, 'animals' => $animals]);
				$this->view('general/footer');
				$this->view('general/copyright', ['end_date' => date('Y') + 1]);
			}
			else
			{
				$this->renderNotFound();
			}
		}
		
		public function details($animalId)
		{
			if (!isset($_SESSION['user'])) {
				header("Location: /login?logout=false");
			}

			$makeOrderModel = $this->model('makeOrderModel');
			$units = $makeOrderModel->getUnits();
			
			$animalModel = $this->model('AnimalModel');

			if($animalModel->animalExists($animalId))
			{
				$securityModel = $this->model('SecurityModel');
				$animal = $animalModel->getAnimal($animalId);
				$nutrition = $animalModel->getAnimalNutrition($animalId);
				$food = $animalModel->getAllAnimalFood();
				$veterinary = $animalModel->getVeterinaryRecord($animalId);
				$diagnosis = $animalModel->getAllDiagnosis();
				$medicine = $animalModel->getAllMedicine();
				$menuModel = $this->model('MenuModel');
				$this->view('general/menu', ['menu_items' => $menuModel->items, 'userInfo' => $_SESSION['user']]);
				$this->view('general/backtotop');
				$this->view('animals/details', ['animal' => $animal, 'nutrition' => $nutrition, 'food' => $food, 'veterinary' => $veterinary, 'diagnosis' => $diagnosis, 'medicine' => $medicine, 'token' => $securityModel->generateToken(), 'units' => $units ]);
				$this->view('general/footer');
				$this->view('general/copyright', ['end_date' => date('Y') + 1]);
			}
			else
			{
				$this->renderNotFound();
			}
		}
		
		public function addfood()
		{
			if($this->validateToken())
			{
				if($_POST["date"] != null && $_POST["food"] != null && $_POST["amount"] != null && $_POST["animalid"] != null && $_POST["unit"])
				{
					$animalModel = $this->model('AnimalModel');
					$animalModel->addAnimalFood($_POST["animalid"], $_POST["food"], $_POST["amount"], $_POST["date"], $_POST["unit"]);
					$this->redirect('animals/details/' . $_POST["animalid"]);
				}
				
			}
		}
		
		public function removeFood()
		{
			if($this->validateToken())
			{
				if(isset($_POST["From"]) && isset($_POST["Food"]) && isset($_POST["Quantity"]) && isset($_POST["animalid"]))
				{
					$animalModel = $this->model('AnimalModel');
					$animalModel->deleteAnimalFood($_POST["From"], $_POST["Food"], floatval($_POST["Quantity"]), $_POST["animalid"]);
					$this->redirect('animals/details/' . $_POST["animalid"]);
				}
			}
		}
		
		public function addveterinary()
		{
			if($this->validateToken())
			{
				$diagnose = '';
				$enddates = $_POST['enddate'];

				if ($_POST["diagnosis"] == '0') {
					$diagnose = null;
				} else {
					$diagnose = $_POST['diagnosis'];
				}

				for ($i=0; $i < count($enddates); $i++) {
					if (empty($enddates[$i])) {
						$enddates[$i] = null;
					}
				}

				if ($_POST['buttonChanger'] == 0) {
					$animalModel = $this->model('AnimalModel');
					$animalModel->updateVeterinary( $_POST['veterinaryrecordID'], $_POST['prescriptionId'], $diagnose, $_POST['medicineId'], 
													$_POST["startdate"], $enddates, $_POST['notes'], $_SESSION["user"]->EMPLOYEEID );
				} else {
					$animalModel = $this->model('AnimalModel');
					$animalModel->addVeterinary($_POST["animalid"], $diagnose, $_POST['medicineId'], 
												$_POST["startdate"], $enddates, $_POST['notes'], $_SESSION["user"]->EMPLOYEEID);
				}

				$this->redirect('animals/details/' . $_POST["animalid"]);
			}
		}
		
		public function removeveterinary($recordIdAndAnimalId)
		{
			$recordIdAndAnimalId = explode(":", $recordIdAndAnimalId);
			$recordId = $recordIdAndAnimalId[0];
			$animalId = $recordIdAndAnimalId[1];
			$prescriptionId = $recordIdAndAnimalId[2];

			$animalModel = $this->model('AnimalModel');
			$animalModel->removeVeterinary($recordId, $prescriptionId);
			$this->redirect('animals/details/' . $animalId);
		}
	}
