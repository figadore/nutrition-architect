<?php
namespace Food;

class Module
{
    public function onBootstrap(\Zend\Mvc\MvcEvent $e)
    {
        #$eventManager        = $e->getApplication()->getEventManager();
        #$moduleRouteListener = new ModuleRouteListener();
        #$moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

	public function getServiceConfig()
	{
		return array('factories'=>array(
				'ViewFactory'=>function($sm)
				{
					$viewFactory = new Model\Factory\View();
					$view = $sm->get('ViewClass');
					$class = get_class($view);
					$viewFactory->setInvokableClass('ViewModel', $class);
					return $viewFactory;
				},
				'Model\Recipe'=>function($sm)
				{
					$mapper = $sm->get('Mapper\Recipe');	
					$recipeModel = new Model\Recipe($mapper);
					return $recipeModel;
				},
				'Mapper\Recipe'=>function($sm)
				{
					$mapper = new Model\Mapper\Recipe();
					return $mapper;
				},
				'Factory\Recipe'=>function($sm)
				{
					$recipeModelFactory = new Model\Factory\Model();
					$recipeModelFactory->setShareByDefault(false);
					$recipeModelFactory->setFactory('Recipe', 
							'\Food\Model\Factory\Recipe');
					return $recipeModelFactory;
				},

			),
			'shared'=>array(
				'Model\Recipe'=>false,
			),
			'invokables'=>array(
				'Zend\ViewModel'=>'Zend\View\Model\ViewModel',
			),
			'aliases'=>array(
				'ViewClass'=>'Zend\ViewModel',
			),
		);
	}

	public function getControllerConfig()
	{
		return array('factories'=>array(
			'Food\Controller\Food'=> function($sm)
			{
				$recipeFactory = $sm->getServiceLocator()->get('Factory\Recipe');
				$viewModel = $sm->getServiceLocator()->get('ViewFactory');
				$controller = new Controller\FoodController($recipeFactory, 
					$viewModel);
				return $controller;
			}
		));
	}

	public function getViewHelperConfig()
	{
		return array(
			'factories' => array(
				'pie'=> function($sm)
				{
					$radius = 15;
					$padding = 2;
					$helper = new View\Helper\PieHelper($radius, $padding);
					return $helper;
				}
			),
		);
	}


    public function getAutoloaderConfig()
    {
        return array(
            #'Zend\Loader\ClassMapAutoloader' => array(
            #        __DIR__ . 'autoload_classmap.php',
            #    ),
            #),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
