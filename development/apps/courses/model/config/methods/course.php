<?php
$methods = [
	'add' => [
		'params' => [
			[
				'name' => 'title',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'goal',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'control',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'teacher',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'department',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'retake',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'ects',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'semester',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'hours',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'competency',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'policy',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'res',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'map',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			]
		]		
	],
	'delete' => [
		'params' => [
			[
				'name' => 'title',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			]
		]
	],
	'get' => [
		'params' => [
			[
				'name' => 'title',
				'source' => 'p',
				'pattern' => '',
				'required' => false,
				'default' => ''
			],
			[
				'name' => 'teacher',
				'source' => 'p',
				'pattern' => '',
				'required' => false,
				'default' => ''
			],
			[
				'name' => 'control',
				'source' => 'p',
				'pattern' => '',
				'required' => false,
				'default' => ''
			],
			[
				'name' => 'semester',
				'source' => 'p',
				'pattern' => '',
				'required' => false,
				'default' => 0
			]
		]
	],
	'edit' => [
		'params' => [
			[
				'name' => 'id',
				'source' => 'p',
				'pattern' => '',
				'required' => true				
			],
			[
				'name' => 'data',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			]
		]
	],
			
];