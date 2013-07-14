<?php
namespace Food\Model\Factory;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use \Shinymayhem\Mvc\AbstractModel;


class Recipe implements FactoryInterface 
{

   protected $_options;

   public function __construct($options = array())
   {
	  $this->_options = $options;
   }

	/**
    * Create service
    *
    * @param ServiceLocatorInterface $serviceLocator
    * @return mixed
    */
    public function createService(ServiceLocatorInterface $serviceLocator)
	{
	   $model = $serviceLocator->getServiceLocator()->get('Model\Recipe');
	   $model->setOptions($this->_options);
	   return $model;

	}

}
