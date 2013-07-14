<?php
namespace Food\Model;

use \Shinymayhem\Mvc\AbstractModel;

class Recipe extends AbstractModel
{

	public function __construct($mapper, $options = array())
	{
		$this->_mapper = $mapper;
		if (!is_array($options))
		{
			throw new \DomainException('$options must be an array');
		}	
		$this->_properties = array_merge($this->_properties, $options);
	}

}
