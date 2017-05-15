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
				$animal = $animalModel->getAnimal($animalId);
				$menuModel = $this->model('MenuModel');
				$this->view('general/menu', ['menu_items' => $menuModel->items]);
				$this->view('general/backtotop');
				$this->view('general/footer');
				$this->view('general/copyright', ['end_date' => date('Y') + 1]);
			}
			else
			{
				$this->renderNotFound();
			}
		}
	}
