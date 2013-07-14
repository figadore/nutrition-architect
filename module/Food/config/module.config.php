<?php
return array(
	#'controllers' => array(
	#	'invokables' => array(
	#		'Food\Controller\Food' => 'Food\Controller\FoodController',
	#	),
	#),
	'router'=>array(
		'routes'=>array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
						'controller'=>'Food\Controller\Food',
						'action'=>'index',
                    ),
                ),
            ),
			'food' => array(
				'type' => 'segment',
				'options'=>array(
					'route' => '/food[/[:action][/:id]]',
					'constraints'=> array(
						'action'=>'[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+',
					),
					'defaults'=>array(
						'controller'=>'Food\Controller\Food',
						'action'=>'index',
					),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack'=>array(
			'food' => __DIR__ . '/../view',
		),
	),
);
