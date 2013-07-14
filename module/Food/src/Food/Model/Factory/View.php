<?php
namespace Food\Model\Factory;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\View\Model\ViewModel;

class View extends AbstractPluginManager
{
	public function validatePlugin($plugin)
	{
		if ($plugin instanceof ViewModel) 
		{
			return;
		}
		throw new \Zend\ServiceManager\Exception\RuntimeException('Invalid 
			ViewModel Implementation');
	}

}
