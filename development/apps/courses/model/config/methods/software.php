<?php
$methods = [
	'add' => [
		'params' => [
			[
				'name' => 'discipline',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'title',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'system',
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
				'name' => 'system',
				'source' => 'p',
				'pattern' => '',
				'required' => false,
				'default' => ''
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