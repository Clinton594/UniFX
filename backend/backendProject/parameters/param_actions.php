<?php
$actions = [
	"barcode" => [
		'table' => 'item',
		'primary_key' => 'tid',
		'page_title' => 'Print Barcode',
		'icon' => 'print_black',
		//'fixed_values'=>"",
		//'extra_values'=>"last_updated=now()",
		//'retrieve_filter'=>"",
		'process_url' => 'process_barcode.php',
		'submit_type' => 'print',
		'actionCol' => 'upc',
		'form' => [
			'sections' => [
				[
					'position' => 'center',
					'section_title' => 'Print Barcode',
					'section_elements' => [
						[
							'column' => 'message',
							'description' => 'Print Barcode of selected products',
							'type' => 'content',
							'class' => 'col s12 m12'
						]
					]
				]
			]
		]
	],
	"print" => [
		"table" => "item",
		"primary_key" => "tid",
		"page_title" => "Print Receipt",
		"icon" => "print_black",
		"form" => [
			"form_view" => "print_Form"
		]
	],
	"open_memeber" => [
		"table" => "user",
		"primary_key" => "id",
		"page_title" => "View Member",
		"icon" => "edit",
		"form" => [
			"form_view" => "open_memeber"
		]
	],
	"referrals" => [
		"table" => "user",
		"primary_key" => "id",
		"page_title" => "Referrals",
		"icon" => "user",
		'form' => [
			"form_view" => "getReferrals",
			"form_submit" => false,
			'sections' => [
				[
					'position' => 'center',
					'section_title' => 'Update User Interest Account',
					'section_elements' => []
				]
			]
		]
	],
	// send-email
	"account-updates" => [
		'table' => 'wallets',
		'primary_key' => 'id',
		'page_title' => 'Wallet Updates',
		'icon' => 'plus-circle',
		'process_url' => "{$uri->backend}process/custom?case=account-updates",
		'form' => [
			"form_view" => "modal",
			'sections' => [
				[
					'position' => 'center',
					'section_title' => 'Update User Interest Account',
					'section_elements' => [
						[
							'column' => 'increment',
							'description' => 'Action',
							'type' => 'select',
							'source' => 'increment',
							'required' => true,
							'class' => 'col s12 m12'
						],
						[
							'column' => 'amount',
							'description' => 'Amount',
							'type' => 'number',
							'required' => true,
							'class' => 'col s12 m12'
						],
						[
							'column' => 'notify',
							'description' => 'Email Notification',
							'type' => 'switch',
							'source' => 'bool',
							'class' => 'col s12 m12'
						]
					]
				]
			]
		]
	],
	"send-email" => [
		'table' => 'wallets',
		'primary_key' => 'id',
		'page_title' => 'Send Emails',
		'icon' => 'envelope',
		'process_url' => "{$uri->backend}process/emails",
		'form' => [
			"form_view" => "modal",
			'sections' => [
				[
					'position' => 'center',
					'section_title' => 'Choose Members',
					'section_elements' => [
						[
							'column' => 'sendto',
							'description' => '',
							'type' => 'radio',
							'source' => 'mailto',
							'required' => true,
							'class' => 'col s12 m12'
						],
					]
				],
				[
					'position' => 'center',
					'section_title' => 'Email Details',
					'section_elements' => [
						[
							'column' => 'title',
							'description' => 'Email Title',
							'type' => 'text',
							'required' => true,
							'class' => 'col s12 m12'
						],
						[
							'column' => 'body',
							'description' => 'Email Body',
							'type' => 'richtext-body',
							'class' => 'col s12 m12'
						]
					]
				]
			]
		]
	],

];
