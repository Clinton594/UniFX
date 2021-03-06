<?php

$sources = [
	// "countries" => get_param_countries($uri),
	"active" => [
		"Inactive",	"Active", "Completed"
	],

	"increment" => [
		"-" => "Deduct",	"+" => "Add Interest"
	],
	"coin_networks" => [
		"BEP20" => "BEP20",
		"ERC20" => "ERC20",
		"TRC20" => "TRC20",
		"Main Network" => "Main Network",
	],

	"lock_duration" => "7 days",
	"countDown" => "10 Minutes",

	"currency" => "$",

	"publish" => [
		"Draft", "Publish"
	],

	"confirm" => [
		"Pending", "Confirmed"
	],

	"condition" => [
		"Poor", "Fair", "Good", "Excellent"
	],
	"tx_type" => [
		"deposit" => "Change to Deposit", "invoice" => "Leave as Invoice", "cancelled" => "Has Timed Out"
	],
	"approval" => [
		"Unapproved", "Approved", "Pending Approval", "Rejected", "Cancelled"
	],

	"status" => [
		"Pending", "Running",  "Completed", "Cancelled",
	],

	"bool" => [
		"No", "Yes"
	],

	"accessLevel" => [
		"View Access", "Creation Access", "Modification Access", "Full Access"
	],
	"mailto" => [
		"all" => "All Members", "selected" => "Selected Members"
	],

	"datatypes" => [
		'picture' => ['gif', 'jpg', 'bmp', 'jpeg', 'png', 'svg', 'webp'],
		'audio' => ['mp3', 'wma', 'm4a', 'ogg'],
		'document' => ['doc', 'docx', 'txt', 'pdf', 'xls', 'xlsx'],
		'video' => ['mp4', 'avi', '3pg', 'mkv', 'wmv'],
		'pdf' => ['pdf'],
		'archive' => ['zip', '7z', 'rar', 'exe']
	],

	"gender" => [
		"m" => "Male", "f" => "Female"
	],

	"mode_of_payment" => [
		"cash" => "Cash", "cheque" => "Cheque", "card" => "Card Payment", "transfer" => "Mobile Transfer"
	],

	"user-category" => [
		1 => "Admin User",
		2 => "Regular Member",
	],
	"loadcoins" => loadcoins($generic),
	"banks" => [
		"063" => "Access Bank Plc (Diamond)",
		"050" => "Ecobank Nigeria",
		"084" => "Enterprise Bank Plc",
		"070" => "Fidelity Bank Plc",
		"011" => "First Bank of Nigeria Plc",
		"214" => "First City Monument Bank",
		"058" => "Guaranty Trust Bank Plc",
		"030" => "Heritage Bank",
		"301" => "Jaiz Bank",
		"082" => "Keystone Bank Ltd",
		"014" => "Mainstreet Bank Plc",
		"076" => "Polaris Bank",
		"039" => "Stanbic IBTC Plc",
		"232" => "Sterling Bank Plc",
		"032" => "Union Bank Nigeria Plc",
		"033" => "United Bank for Africa Plc",
		"215" => "Unity Bank Plc",
		"035" => "WEMA Bank Plc",
		"057" => "Zenith Bank International",
	],
	"states" => [
		"abia" => "Abia State",
		"adamawa" => "Adamawa State",
		"akwa-ibom" => "Akwa Ibom State",
		"anambra" => "Anambra State",
		"bauchi" => "Bauchi State",
		"bayelsa" => "Bayelsa State",
		"benue" => "Benue State",
		"borno" => "Borno State",
		"cross-river" => "Cross River State",
		"delta" => "Delta State",
		"ebonyi" => "Ebonyi State",
		"edo" => "Edo State",
		"ekiti" => "Ekiti State",
		"enugu" => "Enugu State",
		"fct-abuja" => "FCT - Abuja",
		"gombe" => "Gombe State",
		"imo" => "Imo State",
		"jigawa" => "Jigawa State",
		"kano" => "Kano State",
		"katsina" => "Katsina State",
		"kebbi" => "Kebbi State",
		"kogi" => "Kogi State",
		"kwara" => "Kwara State",
		"lagos" => "Lagos State",
		"nasarawa" => "Nasarawa State",
		"niger" => "Niger State",
		"ogun" => "Ogun State",
		"ondo" => "Ondo State",
		"osun" => "Osun State",
		"oyo" => "Oyo State",
		"plateau" => "Plateau State",
		"rivers" => "Rivers State",
		"sokoto" => "Sokoto State",
		"taraba" => "Taraba State",
		"yobe" => "Yobe State",
		"zamfara" => "Zamfara State"
	],
];
