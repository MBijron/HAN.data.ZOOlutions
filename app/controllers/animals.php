<?PHP
	class Animals extends Controller
	{	
		public function index($area)
		{
			$animalModel = $this->model('AnimalModel');
			if($animalModel->areaExists($area))
			{
				$animals = $animalModel->getAnimalsOfArea($area);
				$menuModel = $this->model('MenuModel');
				$this->view('general/menu', ['menu_items' => $menuModel->items]);
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
			$animalModel = $this->model('AnimalModel');
			if($animalModel->animalExists($animalId))
			{
				$securityModel = $this->model('SecurityModel');
				$animal = $animalModel->getAnimal($animalId);
				$nutrition = $animalModel->getAnimalNutrition($animalId);
				$food = $animalModel->getAllAnimalFood();
				$menuModel = $this->model('MenuModel');
				$this->view('general/menu', ['menu_items' => $menuModel->items]);
				$this->view('general/backtotop');
				$this->view('animals/details', ['animal' => $animal, 'nutrition' => $nutrition, 'food' => $food, 'token' => $securityModel->generateToken()]);
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
	}
