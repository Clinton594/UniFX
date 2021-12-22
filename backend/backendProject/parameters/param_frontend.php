<?php
$user_id = empty($_SESSION['user_id']) ? 0 : $_SESSION['user_id'];
$front = [
	"user-profile" => [
		"table" => "users",
		"primary_key" => "id",
		"page_title" => "your profile",
		"pre_submit_function" => "verify_token",
		"retrive_filter" => "id=$user_id",
		"form" => [
			"sections" => [
				[
					"position" => "center",
					"section_title" => "",
					"section_elements" => [
						[
							"column" => "picture_ref",
							"type" => "hidden",
							"class" => "col s12"
						], [
							"column" => "first_name",
							"description" => "First Name",
							"type" => "text",
							"class" => "col s6"
						], [
							"column" => "last_name",
							"description" => "Last Name",
							"type" => "text",
							"class" => "col s6"
						], [
							"column" => "phone",
							"description" => "Phone Number",
							"type" => "number",
							"class" => "col s12"
						], [
							"column" => "dob",
							"description" => "Date Of Birth",
							"type" => "date",
							"class" => "col s6"
						], [
							"column" => "gender",
							"description" => "Gender",
							"type" => "select",
							"source" => "gender",
							"class" => "col s6"
						]
					]
				]
			]
		]
	],

	"kyc-submission" => [
		"table" => "users",
		"primary_key" => "id",
		"page_title" => "your profile",
		"post_submit_function" => "notify_admin",
	],

	"loginMembers" => [ //Signin Parameters
		"table" 			=> "users",
		"primary_key"	=> "id",
		"username_col" => "username",
		"password_col" => "password",
		"name_col"  	=> "first_name",
		"email_col" 	=> "email",
		"image_col"		=> "picture_ref",
		"phone_col"		=> "phone",
		"password_hash" => "password_hash",
		"unique_key" 	=> "email",
		"fixed_values" 	=> "type=2",
		"pre_submit_function" => "prepare_new_member",
		"post_submit_function" => "welcome",
		"callback" 		=> "site_login",
	],

];
