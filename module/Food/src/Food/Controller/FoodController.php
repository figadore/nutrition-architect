<?php
namespace Food\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Food\Model\Factory\View as ViewFactory;
use Food\Model\Factory\Model as ModelFactory;
use Food\Model\Recipe;

class FoodController extends AbstractActionController
{

	protected $_recipeFactory;
	protected $_viewFactory;

	public function __construct(ModelFactory $recipeFactory, 
			ViewFactory $viewFactory)
	{
		$this->_recipeFactory = $recipeFactory;
		$this->_viewFactory = $viewFactory;
	}

	public function getRecipeFactory()
	{
		return $this->_recipeFactory;
	}

	public function getViewFactory()
	{
		return $this->_viewFactory;
	}

	public function indexAction()
	{
		$factory = $this->getRecipeFactory();
		$recipe = $factory->get('Recipe', array());
		$recipe->setName("cookies");
		$recipe->setUserId(5);
		$recipe2 = $factory->get('Recipe', array());
		$recipe2->setName("cake");
		$recipe2->setUserId(6);
		$recipe->say("mapper works");
		return $this->getViewFactory()->get('ViewModel', array(
			'recipe'=>$recipe,
			'recipe2'=>$recipe2,
		));
	}

	public function demoAction()
	{
		$grid = array(
			'shop'=>array(
				array(
					array(
						'name'=>'Salad', 
						'total'=>'1', 
						'remaining'=>'1', 
					),
					array(
						'name'=>'Soup', 
						'total'=>'2', 
						'remaining'=>'2', 
					),
				),
				array(),
				array(),
				array(),
				array(),
				array(),
				array(),
			),
			'prepare'=>array(
				array(
					array(
						'name'=>'Lasagna<br />Prep: 30 min<br />Cook: 60 min', 
						'total'=>'10', 
						'remaining'=>'10', 
					),
				),
				array(
					array(
						'name'=>'Salad<br />Prep: 5 min', 
						'total'=>'1', 
						'remaining'=>'1', 
					),
					array(
						'name'=>'Soup<br />Cook: 3 min', 
						'total'=>'2', 
						'remaining'=>'2', 
					),
				),
				array(),
				array(),
				array(),
				array(),
				array(),
			),
			'available'=>array(
				array(
					array(
						'name'=>'Lasagna', 
						'total'=>'10', 
						'remaining'=>'10', 
					),
				),
				array(
					array(
						'name'=>'Lasagna', 
						'total'=>'10', 
						'remaining'=>'9', 
					),
					array(
						'name'=>'Salad', 
						'total'=>'1', 
						'remaining'=>'1', 
					),
					array(
						'name'=>'Soup', 
						'total'=>'2', 
						'remaining'=>'2', 
					),
				),
				array(
					array(
						'name'=>'Lasagna', 
						'total'=>'10', 
						'remaining'=>'8', 
					),
					array(
						'name'=>'Soup', 
						'total'=>'2', 
						'remaining'=>'1', 
					),
				),
				array(
					array(
						'name'=>'Lasagna', 
						'total'=>'10', 
						'remaining'=>'2', 
					),
				),
				array(),
				array(),
				array(),
			),
			'eat'=>array(
				array(
					array(
						'name'=>'Lasagna', 
						'total'=>'10', 
						'remaining'=>'1', 
					),
				),
				array(
					array(
						'name'=>'Lasagna', 
						'total'=>'10', 
						'remaining'=>'1', 
					),
					array(
						'name'=>'Salad', 
						'total'=>'1', 
						'remaining'=>'1', 
					),
					array(
						'name'=>'Soup', 
						'total'=>'2', 
						'remaining'=>'1', 
					),
				),
				array(
					array(
						'name'=>'Lasagna', 
						'total'=>'10', 
						'remaining'=>'6', 
					),
					array(
						'name'=>'Soup', 
						'total'=>'2', 
						'remaining'=>'1', 
					),
				),
				array(
					array(
						'name'=>'Lasagna', 
						'total'=>'10', 
						'remaining'=>'2', 
					),
				),
				array(),
				array(),
				array(),
			),
		);
		return $this->getViewFactory()->get('ViewModel', array(
			'grid'=>$grid,
		));
	}
}
