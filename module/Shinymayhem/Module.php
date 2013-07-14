<?php
namespace Shinymayhem;

class Module
{
    public function getAutoloaderConfig()
    {
        $array = array(
            #'Zend\Loader\ClassMapAutoloader' => array(
            #    __DIR__ . '/autoload_classmap.php',
            #),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ ,
                ),
            ),
        );
		return $array;
    }

}
