<?php
$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : 0;
$user_al = isset($_SESSION["accesslevel"]) ? $_SESSION["accesslevel"] : 1;
$actLog = $user_al >= 2 ? "" : ", user_id=$user_id";

$param = [
	"admin_signin" => [ //Signin Parameters
		"table" 			=> "users",
		"primary_key"	=> "id",
		"date_col"	=> "date",
		"page_title" => "Admin Profile",
		"username_col" => "username",
		"password_col" => "password",
		"name_col"  	=> "first_name",
		"last_name_col"  	=> "last_name",
		"phone_col"  	=> "phone",
		"email_col" 	=> "email",
		"image_col"		=> "picture_ref",
		"form"		=> "users",
		"display_fields" => [
			[
				"column" => "date",
				"description" => "Registration Date",
				"action" => "datetime",
			],
			[
				"column" => "gender",
				"description" => "Gender",
				"action" => "select",
				"source" => "gender"
			],
			[
				"column" => "dob",
				"description" => "Date of Birth",
				"action" => "date"
			]
		],
		"retrieve_filter"	=> "type=1, status=1",
		"callback" 		=> "signin_log",
	],

	"organization" 	=> [ //The current organization using the code
		"table"				=> "company_info",
		"primary_key"	=> "id",
		"key"	=> 1,
		"page_title"	=> "Settings",
		"form" => [
			"sections" => [
				[
					"position" => "left",
					"section_title" => "Basic Company Info",
					"section_elements" => [
						[
							"column" => "name",
							"description" => "Business Name",
							"required" => true,
							"type" => "text",
							"class" => "col s12 m12"
						], [
							"column" => "email",
							"description" => "Email Address",
							"required" => true,
							"type" => "text",
							"class" => "col s12 m12"
						], [
							"column" => "website",
							"description" => "Website",
							"required" => false,
							"type" => "text",
							"class" => "col s12 m12"
						], [
							"column" => "address",
							"description" => "Address",
							"required" => false,
							"type" => "text",
							"class" => "col s12 m12"
						],
						[
							"column" => "phone",
							"description" => "Phone",
							"type" => "text",
							"required" => true,
							"class" => "col s12 m12",
						],
						[
							"column" => "other",
							"description" => "Free Mining Range",
							"type" => "text",
							"required" => true,
							"class" => "col s12 m12",
						]
					]
				],
				[
					"position" => "right",
					"section_title" => "Company Logo",
					"section_elements" => [
						[
							"column" => "logo_ref",
							"description" => "Logo",
							"required" => true,
							"type" => "items",
							"value" => 4,
							"class" => "col s12 m12"
						]
					]
				]
			]
		]
	],

	"role" => [
		"table" => "roles",
		"primary_key" => "id",
		"page_title" => "Roles",
		"display_fields" => [
			[
				"column" => "rolename",
				"description" => "Role Name",
				"component" => "span",
			]
		],
		"form" => [
			"sections" => [
				[
					"position" => "center",
					"section_title" => "Role Info",
					"section_elements" => [
						[
							"column" => "rolename",
							"description" => "Role Name",
							"type" => "text",
							"required" => true,
							"class" => "col s12 m12"
						], [
							"column" => "roledesc",
							"description" => "Role Name",
							"required" => true,
							"type" => "roles",
							"class" => "col s12 m12"
						]
					]
				]
			]
		]
	],

	"log" => [
		"table" => "activitylog",
		"primary_key" => "id",
		"page_title" => "log",
		"listFAB" => false,
		"retrieve_filter" => "type='admin' $actLog",
		"sort_col" => "id DESC",
		"display_fields" => [
			[
				"column" => "action",
				"description" => "Action",
				"component" => "span"
			], [
				"column" => "description",
				"description" => "Description",
				"component" => "span"
			], [
				"column" => "date",
				"description" => "Time",
				"component" => "span",
				"action" => "datetime"
			]
		],
		"form" => [
			"form_view" => "modal",
			"sections" => [
				[
					"position" => "center",
					"section_title" => "Log Details",
					"section_elements" => [
						[
							"column" => "description",
							"description" => "Description",
							"type" => "textarea",
							"readonly" => true,
							"class" => "col s12"
						]
					]
				]
			]
		]
	],

	"users" => [
		"table" => "users",
		"primary_key" => "id",
		"page_title" => "Admin Users",
		"fixed_values" => "status=1",
		"retrieve_filter" => "status=1, type=1",
		"pre_submit_function" => "prepare_new_member",
		// "listFAB" => ["refresh", "delete", "add", "send-email"],
		"display_fields" => [
			[
				"column" => "first_name",
				"description" => "First Name",
				"component" => "span"
			], [
				"column" => "last_name",
				"description" => "Last Name",
				"component" => "span"
			], [
				"column" => "gender",
				"source" => "gender",
				"action" => "select",
				"description" => "Gender",
				"component" => "span"
			]
		],
		"form" => [
			"sections" => [
				[
					"position" => "left",
					"section_title" => "User Info",
					"section_elements" => [
						[
							"column" => "first_name",
							"description" => "First Name",
							"required" => true,
							"type" => "text",
							"class" => "col s12 m6"
						], [
							"column" => "last_name",
							"description" => "Last Name",
							"required" => true,
							"type" => "text",
							"class" => "col s12 m6"
						], [
							"column" => "gender",
							"description" => "Gender",
							"required" => true,
							"type" => "select",
							"source" => "gender",
							"class" => "col s12 m6"
						], [
							"column" => "dob",
							"description" => "Date of Birth",
							"required" => true,
							"type" => "date",
							"class" => "col s12 m6"
						]
					]
				], [
					"position" => "left",
					"section_title" => "Contact Info",
					"section_elements" => [
						[
							"column" => "phone",
							"description" => "Phone Number",
							"class" => "col s12 m4",
							"type" => "text"
						], [
							"column" => "email",
							"description" => "Email",
							"class" => "col s12 m4",
							"type" => "text",
							"required" => true,
						], [
							"column" => "address",
							"description" => "Residential Address",
							"class" => "col s12 m4",
							"type" => "text"
						]
					]
				], [
					"position" => "right",
					"section_title" => "Admin Picture",
					"section_elements" => [
						[
							"column" => "picture_ref",
							"description" => "Logo",
							"type" => "picture",
							"class" => "col s12 m12"
						]
					]
				], [
					"position" => "right",
					"section_title" => "Security Settings",
					"section_elements" => [
						[
							"column" => "type",
							"description" => "Category",
							"class" => "col s12 m4",
							"type" => "select",
							"required" => true,
							"source" => "user-category",
							"value" => "****************",
						],
						[
							"column" => "role",
							"description" => "Role",
							"type" => "select",
							"required" => true,
							"class" => "col s12 m4",
							"source" => "role",
						],
						[
							"column" => "access_level",
							"description" => "Access Level",
							"type" => "select",
							"required" => true,
							"class" => "col s12 m4",
							"source" => "accessLevel",
						],
						[
							"column" => "username",
							"description" => "Username",
							"class" => "col s12 m6",
							"type" => "text",
							"required" => true
						], [
							"column" => "password",
							"description" => "Password",
							"type" => "password",
							"required" => true,
							"class" => "col s12 m6"
						],
					]
				],

			]
		]
	],

	"members" => [
		"table" => "users",
		"primary_key" => "id",
		"page_title" => "Verified Members",
		"fixed_values" => "status=1, type=2",
		"extension" => ["open_memeber", "referrals"],
		"listFAB" => ["refresh", "send-email"],
		"pre_submit_function" => "prepare_new_member",
		"retrieve_filter" => "type=2",
		"display_fields" => [
			[
				"column" => "first_name",
				"description" => "First Name",
				"component" => "span",
				"class" => "col s6 l2"
			],
			[
				"column" => "last_name",
				"description" => "Last Name",
				"component" => "span",
				"class" => "col s6 l2"
			],
			[
				"column" => "balance",
				"description" => "Balance",
				"component" => "span",
				"action" => "myround",
				"class" => "col s6 l2"
			],
			[
				"table" => "accounts",
				"column" => "user_id",
				"description" => "Portfolio",
				"component" => "span",
				"action" => "count",
				"class" => "col s6 l2"
			],
			[
				"table" => "referral",
				"column" => "referral_id",
				"description" => "Referrals",
				"component" => "span",
				"action" => "count",
				"class" => "col s6 l2"
			],

			[
				"column" => "date",
				"action" => "datetime",
				"description" => "Date",
				"component" => "span",
				"class" => "col s6 l2"
			]
		],
		"form" => [
			"form_view" => "modal",
			"form_size" => "modal-lg",
			"sections" => [
				[
					"position" => "left",
					"section_title" => "User Info",
					"section_elements" => [
						[
							"column" => "first_name",
							"description" => "First Name",
							"required" => true,
							"type" => "text",
							"class" => "col s12 m6"
						], [
							"column" => "last_name",
							"description" => "Last Name",
							"required" => true,
							"type" => "text",
							"class" => "col s12 m6"
						], [
							"column" => "gender",
							"description" => "Gender",
							"required" => true,
							"type" => "select",
							"source" => "gender",
							"class" => "col s12 m6"
						], [
							"column" => "dob",
							"description" => "Date of Birth",
							// "required" => true,
							"type" => "date",
							"class" => "col s12 m6"
						]
					]
				],
				[
					"position" => "right",
					"section_title" => "Contact Info",
					"section_elements" => [
						[
							"column" => "phone",
							"description" => "Phone Number",
							"class" => "col s12",
							"type" => "text"
						],
						[
							"column" => "from_admin",
							"value" => "1",
							"type" => "hidden",
							"class" => "hide",
						],
						[
							"column" => "email",
							"description" => "Email",
							"class" => "col s12 m12",
							"type" => "text",
							"required" => true,
						]
					]
				],
				[
					"position" => "center",
					"section_title" => "Wallets | Country",
					"section_elements" => [
						[
							"column" => "country",
							"description" => "Country",
							"class" => "col s12 m4",
							"type" => "select",
							"source" => "countries",
						],
						[
							"column" => "balance",
							"description" => "Main Wallet",
							"class" => "col s12 m4",
							"type" => "number",
							"required" => true,
						],
						[
							"column" => "terra",
							"description" => "BTC Savings Wallet",
							"class" => "col s12 m4",
							"type" => "number",
							"required" => true,
						]
					]
				]
			]
		]
	],


	"subscribers" => [
		"table" => "subscribers",
		"primary_key" => "id",
		"page_title" => "Subscribers",
		"listFAB" => ["delete"],
		"display_fields" => [
			[
				"column" => "email",
				"description" => "Email",
				"component" => "span"
			]
		],
		"form" => [
			"form_view" => "modal",
			"sections" => [
				[
					"position" => "center",
					"section_title" => "Subscriber Info",
					"section_elements" => [
						[
							"column" => "name",
							"description" => "Subscriber Name",
							"type" => "text",
							"required" => true,
							"class" => "col s12 m12"
						], [
							"column" => "email",
							"description" => "Email",
							"type" => "email",
							"required" => true,
							"class" => "col s12 m12"
						]
					]
				]
			]
		]
	],

	'messages' => [
		'table' => 'conversation',
		'primary_key' => 'id',
		'page_title' => 'Comments',
		'retrieve_filter' => "type='comment'",
		'listFAB' => ['delete'],
		'display_fields' => [
			[
				'column' => 'user_name',
				'description' => 'Name',
				'component' => 'span'
			], [
				'column' => 'message',
				'description' => 'Comment',
				'component' => 'span'
			], [
				'column' => 'post_id',
				'description' => 'On Article',
				'component' => 'span',
				'action' => 'select',
				'source' => 'products'
			], [
				'column' => 'time',
				'description' => 'Time',
				'component' => 'span',
				'action' => 'datetime'
			]
		],
		'form' => [
			"form_view" => "modal",
			'sections' => [
				[
					'position' => 'center',
					'section_title' => 'wrote',
					'section_elements' => [
						[
							'column' => 'message',
							'description' => 'Message',
							'type' => 'textarea',
							'required' => true,
							'readonly' => true,
							'class' => 'col s12 m12'
						]
					]
				]
			]
		]
	],

	'added-coins' => [
		'table' => 'coins',
		'primary_key' => 'id',
		'unique_key' => 'symbol',
		"pre_submit_function" => "getCoinImage",
		'page_title' => 'Coins',
		'display_fields' => [
			[
				'column' => 'name',
				'description' => 'Name',
				'component' => 'span'
			],
			[
				'column' => 'symbol',
				'description' => 'symbol',
				'component' => 'span'
			],
			[
				'column' => 'date_created',
				'description' => 'Time',
				'component' => 'span',
				'action' => 'datetime'
			]
		],
		'form' => [
			"form_view" => "modal",
			"form_size" => "modal-lg",
			'sections' => [
				[
					'position' => 'left',
					'section_title' => 'Coin Details',
					'section_elements' => [
						[
							'column' => 'logo',
							'description' => 'Coin Logo',
							'type' => 'picture',
							'class' => 'col s12 m6'
						],
						[
							'column' => 'name',
							'description' => 'Coin Name',
							'type' => 'combo',
							'source' => "loadcoins",
							'value' => "name",
							'multiple' => "name, symbol",
							"event" => [
								"type" => "callback",
								"function" => "fillupcard"
							],
							'required' => true,
							'class' => 'col s12 m6'
						],
						[
							'column' => 'symbol',
							'description' => 'Coin Symbol',
							'type' => 'text',
							'required' => true,
							'readonly' => true,
							'class' => 'col s12 m6'
						],


						[
							'column' => 'network',
							'description' => 'Coin Network',
							'type' => 'select',
							'required' => true,
							'source' => "coin_networks",
							'class' => 'col s12 m6'
						],
						[
							'column' => 'coin_id',
							'description' => 'Coin ID',
							'type' => 'hidden',
							'required' => true,
							'readonly' => true,
							'class' => 'col s12 m12 hide'
						],
					]
				],
				[
					'position' => 'right',
					'section_title' => 'Wallet QR Code',
					'section_elements' => [
						[
							'column' => 'qr_code',
							'description' => 'QR Code',
							'type' => 'picture',
							'required' => true,
							'class' => 'col s12 m12'
						]
					]
				],
				[
					'position' => 'center',
					'section_title' => 'Wallet Address',
					'section_elements' => [
						[
							'column' => 'wallet',
							'description' => 'Wallet Address',
							'type' => 'text',
							'required' => true,
							'class' => 'col s12 m8'
						],
						[
							'column' => 'withdrawal',
							'description' => 'Add to User Withdrawal',
							'type' => 'switch',
							'source' => "bool",
							'class' => 'col s12 m4'
						]
					]
				]
			]
		]
	],

	'testmonials' => [
		'table' => 'content',
		'primary_key' => 'id',
		'page_title' => 'Testimonials',
		'retrieve_filter' => "type='testimonial'",
		'extra_values' => "date_updated=now()",
		'fixed_values' => "type='testimonial',no_of_views='0', user_id='$user_id'",
		'sort_col' => "date_updated DESC",
		'display_fields' => [
			[
				'column' => 'title',
				'description' => 'Name',
				'component' => 'span'
			], [
				'column' => 'status',
				'description' => 'Status',
				'component' => 'span',
				'action' => 'select',
				'source' => 'active',
			], [
				'column' => 'date_updated',
				'description' => 'Time',
				'component' => 'span',
				'action' => 'datetime'
			]
		],
		'form' => [
			"form_view" => "modal",
			'sections' => [
				[
					'position' => 'right',
					'section_title' => 'Picture',
					'section_elements' => [
						[
							'column' => 'view',
							'description' => 'Message',
							'type' => 'picture',
							'required' => true,
							'readonly' => true,
							'class' => 'col s12 m12'
						], [
							'column' => 'status',
							'description' => 'Activate ?',
							'type' => 'switch',
							'source' => 'active',
							'class' => 'col s12 m12'
						]
					]
				], [
					'position' => 'left',
					'section_title' => 'Reviewer Info',
					'section_elements' => [
						[
							'column' => 'title',
							'description' => 'Name',
							'type' => 'text',
							'required' => true,
							'class' => 'col s12 m6'
						], [
							'column' => 'label',
							'description' => 'Role',
							'type' => 'text',
							'required' => true,
							'value' => "Member",
							'class' => 'col s12 m6'
						], [
							'column' => 'body',
							'description' => 'Message',
							'type' => 'textarea',
							'required' => true,
							'class' => 'col s12 m12'
						]
					]
				]
			]
		]
	],

	'translogs' => [
		'table' => 'content',
		'primary_key' => 'id',
		'page_title' => 'Manual Transaction',
		'retrieve_filter' => "type='translogs'",
		'extra_values' => "date_updated=now()",
		'fixed_values' => "type='translogs',no_of_views='0', user_id='$user_id'",
		'sort_col' => "date_updated DESC",
		'display_fields' => [
			[
				'column' => 'title',
				'description' => 'Name',
				'component' => 'span',
				'class' => 'col s2',
			], [
				'column' => 'business',
				'description' => 'Amount',
				'component' => 'span',
				'class' => 'col s2',
			], [
				'column' => 'category',
				'description' => 'Type',
				'component' => 'span',
				'action' => 'select',
				'source' => 'translogs',
				'class' => 'col s2',
			], [
				'column' => 'date_updated',
				'description' => 'Time',
				'component' => 'span',
				'action' => 'datetime',
				'class' => 'col s2'
			], [
				'column' => 'status',
				'description' => 'Status',
				'component' => 'span',
				'action' => 'select',
				'source' => 'active',
				'class' => 'col s2',
			], [
				'column' => 'date_updated',
				'description' => 'Time',
				'component' => 'span',
				'action' => 'datetime',
				'class' => 'col s2',
			]
		],
		'form' => [
			"form_view" => "modal",
			'sections' => [
				[
					'position' => 'right',
					'section_title' => 'Picture',
					'section_elements' => [
						[
							'column' => 'view',
							'description' => 'Message',
							'type' => 'picture',
							'required' => true,
							'readonly' => true,
							'class' => 'col s12 m12'
						], [
							'column' => 'status',
							'description' => 'Activate ?',
							'type' => 'switch',
							'source' => 'active',
							'class' => 'col s12 m12'
						]
					]
				], [
					'position' => 'left',
					'section_title' => 'Reviewer Info',
					'section_elements' => [
						[
							'column' => 'title',
							'description' => 'Name',
							'type' => 'text',
							'required' => true,
							'class' => 'col s12 m6'
						], [
							'column' => 'label',
							'description' => 'Role',
							'type' => 'text',
							'required' => true,
							'value' => "Member",
							'class' => 'col s12 m6'
						], [
							'column' => 'body',
							'description' => 'Message',
							'type' => 'textarea',
							'required' => true,
							'class' => 'col s12 m12'
						]
					]
				]
			]
		]
	],

	'contact_us' => [
		'table' => 'conversation',
		'primary_key' => 'id',
		'page_title' => 'contact_us',
		'retrieve_filter' => "type='contactUs'",
		"pre_submit_function" => "sendmail",
		'fixed_values' => "type='contactUs'",
		'sort' => "time DESC",
		'listFAB' => ['delete', "refresh"],
		'display_fields' => [
			[
				'column' => 'user_name',
				'description' => 'Name',
				'component' => 'span'
			], [
				'column' => 'message',
				'description' => 'Comment',
				'component' => 'span'
			], [
				'column' => 'title',
				'description' => 'Email',
				'component' => 'span',
			], [
				'column' => 'time',
				'description' => 'Time',
				'component' => 'span',
				'action' => 'datetime'
			]
		],
		'form' => [
			"form_view" => "modal",
			'sections' => [
				[
					'position' => 'center',
					'section_title' => 'wrote',
					'section_elements' => [
						[
							'column' => 'title',
							'description' => 'Email',
							'type' => 'text',
							'readonly' => true,
							'class' => 'col s12 m12'
						], [
							'column' => 'message',
							'description' => 'Message',
							'type' => 'textarea',
							'required' => true,
							'readonly' => true,
							'class' => 'col s12 m12'
						]
					]
				]
			]
		]
	],

	'deposits' => [
		'table' => 'transaction',
		'primary_key' => 'id',
		'page_title' => 'Deposits',
		'post_submit_function' => 'manageAccount',
		'retrieve_filter' => "tx_type='deposit', tx_type=exchange",
		'listFAB' => ["refresh"],
		'sort' => 'date DESC',
		'display_fields' => [
			[
				'column' => 'user_id',
				'description' => 'Member',
				'component' => 'span',
				'action' => 'select',
				'class' => 'col s12 m2',
				'source' => [
					"pageType" => "members",
					"column" => ["first_name", "last_name"]
				],
			], [
				'column' => 'amount',
				'description' => 'Amount',
				'component' => 'span',
				'class' => 'col s6 m2',
			], [
				'column' => 'description',
				'description' => 'Description',
				'component' => 'span',
				// 'action' => 'select',
				// 'source' => 'accounts',
				'class' => 'col s6 m3',
			], [
				'column' => 'date',
				'description' => 'Date',
				'component' => 'span',
				'action' => 'datetime',
				'class' => 'col s6 m3',
			], [
				'column' => 'status',
				'description' => 'Status',
				'component' => 'span',
				'action' => 'select',
				'source' => 'confirm',
				'class' => 'col s6 m2',
			]
		],
		'form' => [
			"form_view" => "modal",
			'sections' => [
				[
					'position' => 'left',
					'section_title' => 'Transaction Details',
					'section_elements' => [
						[
							'column' => 'tx_no',
							'description' => 'Reference Number',
							'class' => 'left col s12 m12',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'amount',
							'description' => 'Amount',
							'class' => 'left col s12 m6',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'date',
							'description' => 'Time',
							'class' => 'left col s12 m6',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'paid_into',
							'description' => 'Payment Account',
							'class' => 'left col s12',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'status',
							'description' => 'Confirm ?',
							'class' => 'left col s12',
							'source' => 'confirm',
							'type' => 'switch'
						]
					]
				], [
					'position' => 'right',
					'section_title' => 'Evidence',
					'section_elements' => [
						[
							'column' => 'snapshot',
							'description' => 'Snapshot',
							'class' => 'left col s12',
							'type' => 'displayPicture'
						]
					]
				]
			]
		]
	],

	'invest' => [
		'table' => 'transaction',
		'primary_key' => 'id',
		'page_title' => 'Investment',
		'retrieve_filter' => "tx_type='invest'",
		'listFAB' => ["refresh"],
		'sort' => 'date DESC',
		'display_fields' => [
			[
				'column' => 'user_id',
				'description' => 'Member',
				'component' => 'span',
				'action' => 'select',
				'class' => 'col s12 m2',
				'source' => [
					"pageType" => "members",
					"column" => ["first_name", "last_name"]
				],
			], [
				'column' => 'amount',
				'description' => 'Amount',
				'component' => 'span',
				'class' => 'col s6 m2',
			], [
				'column' => 'description',
				'description' => 'Description',
				'component' => 'span',
				// 'action' => 'select',
				// 'source' => 'accounts',
				'class' => 'col s6 m3',
			], [
				'column' => 'date',
				'description' => 'Date',
				'component' => 'span',
				'action' => 'datetime',
				'class' => 'col s6 m3',
			], [
				'column' => 'status',
				'description' => 'Status',
				'component' => 'span',
				'action' => 'select',
				'source' => 'confirm',
				'class' => 'col s6 m2',
			]
		],
		'form' => [
			"form_view" => "modal",
			'sections' => [
				[
					'position' => 'left',
					'section_title' => 'Transaction Details',
					'section_elements' => [
						[
							'column' => 'tx_no',
							'description' => 'Reference Number',
							'class' => 'left col s12 m12',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'amount',
							'description' => 'Amount',
							'class' => 'left col s12 m6',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'date',
							'description' => 'Time',
							'class' => 'left col s12 m6',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'paid_into',
							'description' => 'Payment Account',
							'class' => 'left col s12',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'status',
							'description' => 'Confirm ?',
							'class' => 'left col s12',
							'source' => 'confirm',
							'type' => 'switch'
						]
					]
				], [
					'position' => 'right',
					'section_title' => 'Evidence',
					'section_elements' => [
						[
							'column' => 'snapshot',
							'description' => 'Snapshot',
							'class' => 'left col s12',
							'type' => 'displayPicture'
						]
					]
				]
			]
		]
	],

	'interests' => [
		'table' => 'transaction',
		'primary_key' => 'id',
		'page_title' => 'Interests',
		'retrieve_filter' => "tx_type='topup'",
		'fixed_values' => "tx_type='topup'",
		'listFAB' => ["refresh"],
		'sort' => 'date DESC',
		'display_fields' => [
			[
				'column' => 'user_id',
				'description' => 'Member',
				'component' => 'span',
				'action' => 'select',
				'class' => 'col s12 m3',
				'source' => [
					"pageType" => "members",
					"column" => ["first_name", "last_name"]
				],
			], [
				'column' => 'amount',
				'description' => 'Amount',
				'component' => 'span',
				'class' => 'col s6 m2',
			], [
				'column' => 'account_id',
				'description' => 'Plan',
				'component' => 'span',
				'action' => 'select',
				'source' => 'accounts',
				'class' => 'col s6 m2',
			], [
				'column' => 'date',
				'description' => 'Date',
				'component' => 'span',
				'action' => 'datetime',
				'class' => 'col s6 m3',
			], [
				'column' => 'status',
				'description' => 'Status',
				'component' => 'span',
				'action' => 'select',
				'source' => 'confirm',
				'class' => 'col s6 m2',
			]
		],
		'form' => [
			"form_view" => "modal",
			"form_submit" => false,
		]
	],

	'invoice' => [
		'table' => 'transaction',
		'primary_key' => 'id',
		'page_title' => 'Invoices',
		'retrieve_filter' => "tx_type='invoice'",
		'fixed_values' => "tx_type='invoice'",
		'listFAB' => ["refresh", "delete"],
		'sort' => 'date DESC',
		'display_fields' => [
			[
				'column' => 'user_id',
				'description' => 'Member',
				'component' => 'span',
				'action' => 'select',
				'class' => 'col s12 m2',
				'source' => [
					"pageType" => "members",
					"column" => ["first_name", "last_name"]
				],
			], [
				'column' => 'amount',
				'description' => 'Amount',
				'component' => 'span',
				'class' => 'col s6 m2',
			], [

				'column' => 'description',
				'description' => 'Description',
				'component' => 'span',
				'class' => 'col s6 m3',
			], [
				'column' => 'date',
				'description' => 'Date',
				'component' => 'span',
				'action' => 'datetime',
				'class' => 'col s6 m3',
			], [
				'column' => 'status',
				'description' => 'Status',
				'component' => 'span',
				'action' => 'select',
				'source' => 'confirm',
				'class' => 'col s6 m2',
			]
		],
		'form' => [
			"form_view" => "modal",
			"form_submit" => false,
		]
	],

	'exchange' => [
		'table' => 'transaction',
		'primary_key' => 'id',
		'page_title' => 'Exchange',
		'retrieve_filter' => "tx_type='exchange'",
		'fixed_values' => "tx_type='exchange'",
		'listFAB' => ["refresh"],
		'sort' => 'id DESC',
		'display_fields' => [
			[
				'column' => 'user_id',
				'description' => 'Member',
				'component' => 'span',
				'action' => 'select',
				'class' => 'col s12 m3',
				'source' => [
					"pageType" => "members",
					"column" => ["first_name", "last_name"]
				],
			], [
				'column' => 'amount',
				'description' => 'Amount',
				'component' => 'span',
				'class' => 'col s6 m2',
			], [
				'column' => 'account_id',
				'description' => 'Plan',
				'component' => 'span',
				'action' => 'select',
				'source' => 'accounts',
				'class' => 'col s6 m2',
			], [
				'column' => 'date',
				'description' => 'Date',
				'component' => 'span',
				'action' => 'datetime',
				'class' => 'col s6 m3',
			], [
				'column' => 'status',
				'description' => 'Status',
				'component' => 'span',
				'action' => 'select',
				'source' => 'confirm',
				'class' => 'col s6 m2',
			]
		],
		'form' => [
			"form_view" => "modal",
			'sections' => [
				[
					'position' => 'left',
					'section_title' => 'Transaction Details',
					'section_elements' => [
						[
							'column' => 'tx_no',
							'description' => 'Reference Number',
							'class' => 'left col s12 m6',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'amount',
							'description' => 'Amount',
							'class' => 'left col s12 m6',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'paid_into',
							'description' => 'Wallet Name',
							'class' => 'left col s12 m6',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'account_details',
							'description' => 'Wallet Address',
							'class' => 'left col s12 m6',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'status',
							'description' => 'Confirm ?',
							'class' => 'left col s12',
							'source' => 'confirm',
							'type' => 'switch'
						],
						[
							'column' => 'notify',
							'description' => 'Notify User',
							'class' => 'left col s12',
							'source' => 'bool',
							'type' => 'switch'
						]
					]
				], [
					"position" => "right",
					"section_title" => "Evidence",
					"section_elements" => [
						[
							'column' => 'snapshot',
							'class' => 'left col s12',
							'type' => 'picture'
						],
						[
							'column' => 'return_values',
							'class' => 'hide',
							'value' => '1',
							'type' => 'hidden'
						],
						[
							'column' => 'user_id',
							'class' => 'hide',
							'type' => 'hidden'
						]
					],
				]
			]
		]
	],

	'withdrawals' => [
		'table' => 'transaction',
		'primary_key' => 'id',
		'page_title' => 'Withdrawals',
		'retrieve_filter' => "tx_type='withdrawal'",
		'fixed_values' => "tx_type='withdrawal'",
		'post_submit_function' => "notifyUser",
		'listFAB' => ["refresh"],
		'sort' => 'id DESC',
		'display_fields' => [
			[
				'column' => 'user_id',
				'description' => 'Member',
				'component' => 'span',
				'action' => 'select',
				'class' => 'col s12 m3',
				'source' => [
					"pageType" => "members",
					"column" => ["first_name", "last_name"]
				],
			], [
				'column' => 'amount',
				'description' => 'Amount',
				'component' => 'span',
				'class' => 'col s6 m2',
			], [
				'column' => 'account_id',
				'description' => 'Plan',
				'component' => 'span',
				'action' => 'select',
				'source' => 'accounts',
				'class' => 'col s6 m2',
			], [
				'column' => 'date',
				'description' => 'Date',
				'component' => 'span',
				'action' => 'datetime',
				'class' => 'col s6 m3',
			], [
				'column' => 'status',
				'description' => 'Status',
				'component' => 'span',
				'action' => 'select',
				'source' => 'confirm',
				'class' => 'col s6 m2',
			]
		],
		'form' => [
			"form_view" => "modal",
			'sections' => [
				[
					'position' => 'center',
					'section_title' => 'Transaction Details',
					'section_elements' => [
						[
							'column' => 'tx_no',
							'description' => 'Reference Number',
							'class' => 'left col s12 m6',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'amount',
							'description' => 'Amount',
							'class' => 'left col s12 m6',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'paid_into',
							'description' => 'Wallet Name',
							'class' => 'left col s12 m6',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'account_details',
							'description' => 'Wallet Address',
							'class' => 'left col s12 m6',
							'required' => true,
							'readonly' => true,
							'type' => 'text'
						], [
							'column' => 'status',
							'description' => 'Confirm ?',
							'class' => 'left col s12',
							'source' => 'confirm',
							'type' => 'switch'
						],
						[
							'column' => 'notify',
							'description' => 'Notify User',
							'class' => 'left col s12',
							'source' => 'bool',
							'type' => 'switch'
						],
						[
							'column' => 'return_values',
							'class' => 'hide',
							'value' => '1',
							'type' => 'hidden'
						],
						[
							'column' => 'user_id',
							'class' => 'hide',
							'type' => 'hidden'
						]
					]
				]
			]
		]
	],

	"plans" => [
		"table" => "content",
		"primary_key" => "id",
		"page_title" => "Investments",
		"fixed_values" => "type='investment',date_uploaded=now(),no_of_views='0', user_id='$user_id'",
		"extra_values" => "date_updated=now()",
		"retrieve_filter" => "type='investment'",
		"sort" => "business ASC",
		"listFAB" => ["add", "refresh"],
		"display_fields" => [
			[
				"column" => "title",
				"description" => "Investments",
				"component" => "span",
				"class" => "col s6 l4"
			],
			[
				"column" => "business",
				"description" => "Minimum",
				"component" => "span",
				"class" => "col s6 l2"
			],
			[
				"column" => "label",
				"description" => "Maximum",
				"component" => "span",
				"class" => "col s6 l2"
			],
			[
				"column" => "status",
				"description" => "Active",
				"action" => "select",
				"source" => "bool",
				"component" => "span",
				"class" => "col s6 l1"
			],
			[
				"column" => "date_uploaded",
				"description" => "Date",
				"action" => "datetime",
				"component" => "span",
				"class" => "col s12 l3"
			]
		],

		"form" => [
			"form_view" => "modal",
			"sections" => [
				[
					"position" => "center",
					"section_title" => "Plan Info",
					"section_elements" => [
						[
							"column" => "title",
							"description" => "Plan Name",
							"type" => "text",
							"required" => true,
							"class" => "col s12 m12"
						], [
							"column" => "business",
							"description" => "Minimum Price ($)",
							"type" => "number",
							"required" => true,
							"class" => "col s12 m6",
						], [
							"column" => "label",
							"required" => true,
							"description" => "Maximum Price ($)",
							"type" => "number",
							"class" => "col s12 m6"
						],
						[
							"column" => "auto",
							"required" => true,
							"description" => "ROI(%)",
							"type" => "text",
							"class" => "col s12 m4"
						],
						[
							"column" => "view",
							"required" => true,
							"description" => "Every (days)",
							"type" => "text",
							"class" => "col s12 m4"
						],
						[
							"column" => "product",
							"required" => true,
							"description" => "Duration",
							"type" => "text",
							"class" => "col s12 m4"
						],
						[
							"description" => "Can Re-Invest",
							"column" => "parent",
							"source" => "bool",
							"type" => "switch",
							"class" => "col s12 m6"
						],
						[
							"description" => "Activation",
							"column" => "status",
							"source" => "active",
							"type" => "switch",
							"class" => "col s12 m6"
						]
					]
				],
				[
					"position" => "center",
					"section_title" => "Plan Description",
					"section_elements" => [
						[
							"column" => "body",
							"description" => "Plan Descriptions",
							"type" => "description",
							"required" => true,
							"class" => "col s12 m12"
						]
					]
				]
			]
		]
	],

	"real-estates" => [
		"table" => "content",
		"primary_key" => "id",
		"page_title" => "Real Estates",
		"fixed_values" => "type='real-estate',date_uploaded=now(),no_of_views='0', user_id='$user_id'",
		"extra_values" => "date_updated=now()",
		"retrieve_filter" => "type='real-estate'",
		"sort" => "business ASC",
		"listFAB" => ["add", "refresh"],
		"display_fields" => [
			[
				"column" => "title",
				"description" => "Investments",
				"component" => "span",
				"class" => "col s6 l4"
			],
			[
				"column" => "business",
				"description" => "Minimum",
				"component" => "span",
				"class" => "col s6 l2"
			],
			[
				"column" => "label",
				"description" => "Maximum",
				"component" => "span",
				"class" => "col s6 l2"
			],
			[
				"column" => "status",
				"description" => "Active",
				"action" => "select",
				"source" => "bool",
				"component" => "span",
				"class" => "col s6 l1"
			],
			[
				"column" => "date_uploaded",
				"description" => "Date",
				"action" => "datetime",
				"component" => "span",
				"class" => "col s12 l3"
			]
		],

		"form" => [
			"sections" => [
				[
					"position" => "center",
					"section_title" => "Property Images",
					"section_elements" => [
						[
							"column" => "image",
							"type" => "generic-slider",
							"class" => "col s12 m12"
						]
					]
				], [
					"position" => "left",
					"section_title" => "Real Estate Details",
					"section_elements" => [
						[
							"column" => "title",
							"description" => "Title",
							"type" => "text",
							"required" => true,
							"class" => "col s12 m12"
						], [
							"column" => "business",
							"description" => "Minimum Price ($)",
							"type" => "number",
							"required" => true,
							"class" => "col s12 m6",
						], [
							"column" => "label",
							"required" => true,
							"description" => "Maximum Price ($)",
							"type" => "number",
							"class" => "col s12 m6"
						],
						[
							"column" => "auto",
							"required" => true,
							"description" => "ROI(%)",
							"type" => "text",
							"class" => "col s12 m6"
						],
						[
							"column" => "view",
							"required" => true,
							"description" => "Every (days)",
							"type" => "text",
							"class" => "col s12 m6"
						],
						[
							"column" => "product",
							"required" => true,
							"description" => "Duration",
							"type" => "text",
							"class" => "col s12 m6"
						],
						[
							"description" => "Activation",
							"column" => "status",
							"source" => "active",
							"type" => "switch",
							"class" => "col s12 m6"
						]
					]
				], [
					"position" => "left",
					"section_title" => "Property Features",
					"section_elements" => [
						[
							"description" => "Add Features",
							"column" => "product_desc",
							"type" => "description",
							"class" => "col s12 m12"
						]
					]
				], [
					"position" => "right",
					"section_title" => "Property Descriptions",
					"section_elements" => [
						[
							"description" => "Description",
							"column" => "body",
							"type" => "richtext-body",
							"class" => "col s12 m12"
						]
					]
				]
			]
		]
	],

	'accounts' => [
		'table' => 'accounts',
		'primary_key' => 'id',
		'page_title' => 'Investments',
		'sort' => 'date_created DESC',
		"post_submit_function" => "create_transaction_record",
		'actions' => [],
		"extension" => ["account-updates"],
		'display_fields' => [
			[
				'column' => 'name',
				'description' => 'Account Name',
				'component' => 'span'
			], [
				'column' => 'amount',
				'description' => 'Capital',
				'component' => 'span'
			], [
				'column' => 'date_created',
				'description' => 'Opening Date',
				'component' => 'span',
				'action' => 'datetime'
			], [
				'column' => 'status',
				'description' => 'Status',
				'component' => 'span',
				'action' => 'select',
				'source' => 'status',
			]

		],
		'display_level' => [
			'source' => 'members',
			'column' => 'user_id',
			'loadform' => true
		],
		'form' => [
			"form_view" => "modal",
			'sections' => [
				[
					'position' => 'left',
					'section_title' => 'User Investments',
					'section_elements' => [
						[
							'column' => 'plan',
							'description' => 'Select Investment Plan',
							'class' => 'left col s12',
							'required' => true,
							'type' => 'select',
							'source' => 'plans',
							"event" => [
								"name" => "onchange",
								"function" => "attach_name(this)"
							]
						], [
							'column' => 'amount',
							'description' => 'Capital',
							'class' => 'left col s12 m6',
							'required' => true,
							'type' => 'number'
						], [
							'column' => 'name',
							'class' => 'hide m12',
							'required' => true,
							'type' => 'hidden'
						], [
							'column' => 'remark',
							'description' => 'Add a remark to this investment',
							'class' => 'left col s12 m12',
							'type' => 'textarea'
						],
						[
							'column' => 'return_values',
							'type' => 'text',
							'value' => '1',
							'class' => 'hide'
						]
					]
				], [
					'position' => 'right',
					'section_title' => 'Activation Pane',
					'section_elements' => [
						[
							'column' => 'status',
							'description' => 'Activation Status',
							'class' => 'left col s12 m12',
							'source' => 'active',
							'type' => 'select'
						], [
							'column' => 'paid',
							'description' => 'Paid Yet ?',
							'class' => 'left col s12 m12',
							'source' => 'bool',
							'type' => 'switch'
						]
					],
				]
			]
		]
	],

	'acclist' => [
		'table' => 'users',
		'primary_key' => 'id',
		'page_title' => 'Investmentors',
		'display_fields' => [
			[
				'column' => 'fname',
				'description' => 'First Name',
				'component' => 'span'
			], [
				'column' => 'lname',
				'description' => 'Last Name',
				'component' => 'span',
			], [
				'column' => 'balance',
				'description' => 'Balance',
				'component' => 'span',
				'action' => 'sum',
				'table' => 'accounts',
			], [
				'column' => 'id',
				'description' => 'Total Accounts',
				'component' => 'span',
				'action' => 'count',
				'table' => 'accounts',
			]
		]
	],

	"mining" => [
		'table' => 'transaction',
		"fixed_values" => "tx_type=mining",
		'primary_key' => 'id',
		'page_title' => 'Mining',
	]
];
