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
