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
				$this->view('animals/details', ['animal' => $animal, 'nutrition' => $nutrition, 'food' => $food, 'veterinary' => $veterinary, 'diagnosis' => $diagnosis, 'medicine' => $medicine, 'token' => $securityModel->generateToken()]);
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
				if($_POST["date"] != null && $_POST["food"] != null && $_POST["amount"] != null && $_POST["animalid"] != null)
				{
					$animalModel = $this->model('AnimalModel');
					$animalModel->addAnimalFood($_POST["animalid"], $_POST["food"], $_POST["amount"], $_POST["date"]);
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
					$animalModel->deleteAnimalFood($_POST["From"], $_POST["Food"], intval($_POST["Quantity"]), $_POST["animalid"]);
					$this->redirect('animals/details/' . $_POST["animalid"]);
				}
			}
		}
		
		public function addveterinary()
		{
			if($this->validateToken())
			{
				if($_POST["diagnosis"] != null || $_POST["medicine"] != null && $_POST["startdate"] != null && $_POST["enddate"] != null)
				{	
					$animalModel = $this->model('AnimalModel');
					if($_POST["medicine"] == 0){
						$medicine = null;
					} else {
						$medicine = $_POST["medicine"];
					}
					$animalModel->addVeterinary($_POST["animalid"], $_POST["diagnosis"], $medicine, $_POST["startdate"], $_POST["enddate"], $_POST["notes"], $_SESSION["user"]->EMPLOYEEID);
					$this->redirect('animals/details/' . $_POST["animalid"]);
				}
				
			}
		}
		
		public function removeveterinary()
		{
			if($this->validateToken())
			{
				if(isset($_POST["prescriptionid"]) && isset($_POST["animalid"]) && isset($_POST["Date"]))
				{
					echo $_POST["prescriptionid"];
					echo $_POST["animalid"];
					echo $_POST["Date"];
					$animalModel = $this->model('AnimalModel');
					//$animalModel->removeVeterinary($_POST["animalid"], $_POST["Date"], $_POST["prescriptionid"]);
					//$this->redirect('animals/details/' . $_POST["animalid"]);
				}
				
			}
		}
	}
