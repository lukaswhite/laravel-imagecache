<?php

return array(

	'presets' => array(
		'thumbnail' => array(
			'actions' => array(
				'resize' => array(
					'width' 	=> 80,
					'height' 	=> 80,
					'ratio'		=> true,
				),
			),			
		),
		'tiny' => array(
			'actions' => array(
				'resize' => array(
					'width' 	=> 32,
					'height' 	=> 32,
					'ratio'		=> true,
				),
			),			
		),
		'small' => array(
			'actions' => array(
				'crop' => array(
					'width' 	=> 300,
					'height' 	=> 125,
				),
			),			
		),
		'large' => array(
			'actions' => array(
				'resize' => array(
					'width' 	=> 800,					
				),
			),			
		),
		'exlarge' => array(
			'actions' => array(
				'resize' => array(
					'width' 	=> 1000,					
				),
			),			
		),
		'crest_medium' => array(
			'actions' => array(
				'resize' => array(
					'width' 	=> 150,
					'height' 	=> 170,
					'ratio'		=> true,
				),
			),			
		),
		'slider' => array(
			'actions' => array(
				'crop' => array(
					'width' 	=> 600,
					'height' 	=> 300,
				),
			),			
		),
		'screenshot_medium' => array(
			'actions' => array(
				'scale_crop' => array(
					'width' 	=> 300,					
					'height' 	=> 200,					
				),
			),			
		),
		'screenshot_small' => array(
			'actions' => array(
				'scale_crop' => array(
					'width' 	=> 200,					
					'height' 	=> 150,					
				),
			),			
		),
		'screenshot_tiny' => array(
			'actions' => array(
				'scale_crop' => array(
					'width' 	=> 150,					
					'height' 	=> 112,					
				),
			),			
		),
		'medium' => array(
			'actions' => array(
				'resize' => array(
					'width' 	=> 250,
					'ratio' 	=> true,
				),
				'flip' => array(
					'mode'		=> 'vertical',
				),
			),			
		),
	),
	'picturefill' => array(
		'default' => 'small',
		'presets' => array(
			'medium'	=>	'(min-width: 400px)',
			'large'	=>	'(min-width: 800px)',
			'exlarge'	=>	'(min-width: 1000px)',
		),		
	),

);