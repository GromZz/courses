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
				'name' => 'type',
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
				'name' => 'goal',
				'source' => 'p',
				'pattern' => '',
				'required' => true
            ],
            [
				'name' => 'mark',
				'source' => 'p',
				'pattern' => '',
				'required' => true
            ],
            [
				'name' => 'week',
				'source' => 'p',
				'pattern' => '',
				'required' => true
            ],
            [
				'name' => 'criteria',
				'source' => 'p',
				'pattern' => '',
				'required' => true
            ]
		]		
	],
	'delete' => [
		'params' => [
			[
				'name' => 'id',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			]
		]
	],
	'get' => [
		'params' => [
			[
				'name' => 'discipline',
				'source' => 'p',
				'pattern' => '',
				'required' => false,
                'default' => 0
            ],
			[
				'name' => 'type',
				'source' => 'p',
				'pattern' => '',
				'required' => false,
                'default' => ''
            ],
            [
				'name' => 'week',
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