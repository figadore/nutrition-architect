<?php
namespace Food\Model\Factory;

use Zend\ServiceManager\AbstractPluginManager;
use \Shinymayhem\Mvc\AbstractModel;

class Model extends AbstractPluginManager
{
	public function validatePlugin($plugin)
	{
		if ($plugin instanceof AbstractModel) 
		{
			return;
		}
		throw new \Zend\ServiceManager\Exception\RuntimeException('Invalid 
			Model Implementation, must be and instance of 
			Shinymayhem\Mvc\AbstractModel');
	}

}
