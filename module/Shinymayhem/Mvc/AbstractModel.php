<?php

namespace Shinymayhem\Mvc;

class AbstractModel
{
	protected $_mapper;
	protected $_id;
	protected $_properties = array();

	public function __construct($options = array())
	{
		if (!is_array($options))
		{
			throw new \DomainException('$options must be an array');
		}	
		$this->_properties = array_merge($this->_properties, $options);
	}


	//magic methods 
	//get and set any values in the _properties array
	//pass any unfound methods on to mapper
	public function __call($name, $args)
	{
		$property = lcfirst(substr($name, 3));
		if (substr($name, 0, 3) == "get") 
		{
			if (!isset($this->_properties[$property]))
			{
				throw new \Exception("Property '$property' not found");
			}
			return $this->_properties[$property];
		}
		elseif (substr($name, 0, 3) == "set")
		{
			$this->_properties[$property] = $args[0];
			return $this;
		}
		else
		{ 
			//call mapper method, e.g. find($this, $arg1, $arg2);
			if (is_object($this->getMapper()) 
				&& is_callable(array($this->getMapper(), $name)))
			{
				array_unshift($args, $this); //add model to args
				return call_user_func_array(array(
					$this->getMapper(), 
					$name
				), $args);
			}
			else
			{
				//echo "object:" . is_object($this->getMapper());
				throw new \Exception("Method '$name' not found");
				//TODO
				//echo "; method:" . $name;
			}
		}
	}

	public function getMapper()
	{
		return $this->_mapper;
	}

	public function setOptions($options = array())
	{
		$this->_properties = array_merge($this->_properties, $options);
	}
}
