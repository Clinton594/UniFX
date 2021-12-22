<?php

function prepare_new_member($post)
{
	global $uri;
	if (empty($post->id)) {
		if (!empty($post->from_admin) || ($post->password == $post->password2)) {
			if (empty($post->password)) $post->password = "DEFAULT";
			$post->password = password_hash($post->password, PASSWORD_DEFAULT);
			$post->username = substr(explode("@", $post->email)[0] . random(3), 0, 10);
			$post->picture_ref = "{$uri->backend}images/c_icon.png";
			$post->return_values = 1;

			// Lower case
			$post->username = ucwords(strtolower($post->username));
			$post->first_name = ucwords(strtolower($post->first_name));
			$post->last_name = ucwords(strtolower($post->last_name));
			$post->email = ucwords(strtolower($post->email));
		} else $post->error = "password does not match";
	}
	return $post;
}

function welcome($user)
{
	$response = site_login($user, "Registration");
	return $response;
}

function site_login($user, $action = 'Login')
{
	global $generic;
	$uri = $generic->getURIdata();
	$response = new stdClass;
	$messenger = new Messenger($generic);
	$company = $generic->company();
	$messenger->pinAction = "login";
	if (!empty($user->primary_key)) $user->id = $user->primary_key;
	if ($action === "Registration") {
		if (!empty($user->referral)) {
			$ref = $generic->getFromTable("users", "username={$user->referral}");
			if (count($ref)) {
				$ref = reset($ref);
				$generic::$mydb->query("INSERT INTO referral SET referred_id='{$user->id}', referral_id='{$ref->id}'") or die($generic::$mydb->error);
			}
		}
		$welcome_mail = (object)[
			"subject" => "Welcome to {$company->name}",
			"body" => "hi",
			"to" => $user->email,
			"from" => $company->email,
			"from_name" => ucwords($company->name),
			"to_name" => "{$user->first_name}",
			"template" => "registeration",
		];
		$response = $messenger->sendMail($welcome_mail);
		$admin_notify = (object)[
			"subject" => "New Registration Alert ({$company->name})",
			"body" => "Hello admin, {$user->first_name} just created an account. Login to guide your client on how to proceed.",
			"to" => $generic->secondary_email,
			"from" => $company->email,
			"from_name" => ucwords($company->name),
			"to_name" => "Admin",
			"template" => "notify",
		];
		$messenger->sendMail($admin_notify);
	} else {
		$_SESSION["mloggedin"] = 1;
	}
	$_SESSION["user_id"] = $user->id;
	$_SESSION["email"] = $user->email;
	$_SESSION["username"] = $user->username;
	$_SESSION["user_name"] = "{$user->first_name}";
	// $response = sendCode($messenger, $user);

	$response->status = 1;
	$desc = ["Login" => "Welcome, {$user->first_name}", "Registration" => "Welcome, your registration was successful."];
	$response->message = $desc[$action];
	$response->id = $user->id;
	return $response;
}

function sendCode($messenger, $user)
{
	global $generic;
	$actions 		= [
		"login" => "login",
		"code" => "reset password",
		"verify-email" => "verify your email",
		"wallet" => "modify your wallet",
		"update-profile" => "update your profile",
		"changeWallet" => "change wallet address",
		"withdrawal" => "authenticate your withdrawal",
	];

	$action 		= $messenger->pinAction;
	$title  		= $actions[$action];
	$company 		= $generic->company();
	if (empty($_SESSION[$action])) {
		$loginCode 	= rand(100000, 999999);
		$_SESSION[$action] = $loginCode;
	} else {
		$loginCode 	=  $_SESSION[$action];
	}
	$mail 			= (object)[
		'subject'		=>	"Token",
		'body'			=>	"Use this token to {$title}. \n $loginCode",
		'from'			=>	$company->email,
		'to'				=>	$user->email,
		'from_name'	=>	$company->name,
		'to_name'		=>	"{$user->first_name}",
		"template"  =>  "token",
		"token"     =>  $loginCode
	];
	$response 	= $messenger->sendMail($mail);
	if (in_array($generic->getServer(), $generic->getLocalServers())) {
		$response->{$action} = $loginCode;
	}
	return $response;
}

function manageAccount($post)
{ //Admin Confirm Payment of user
	global $generic;
	$db = $generic->connect();
	// see($post);
	$sel = 0;
	// Get the existing transaction
	$transaction = $generic->getFromTable("transaction", "id={$post}");
	$transaction = reset($transaction);
	// see($transaction);
	// If the transaction has been confirmed
	if (!empty($transaction->status)) {
		if ($transaction->tx_type == "deposit") {
			$sel
				= $db->query("UPDATE users SET balance=balance+{$transaction->amount} WHERE id='{$transaction->user_id}'");
			//Check for referrals
			$referral = $generic->getFromTable("referral", "referred_id={$transaction->user_id}, status=0");
			if (count($referral)) {
				$referral = reset($referral);
				$fivePercent = get_percent_of(8, $transaction->amount);
				$db->query("UPDATE referral SET status='1', amount='{$fivePercent}' WHERE id='{$referral->id}'");
				// Check if referral has an active account
				$account = $generic->getFromTable("accounts", "user_id={$referral->referral_id}, status=1", 1, 1);
				if (count($account)) {
					$account = reset($account);
					$txn = uniqid($account->user_id);
					$db->query("UPDATE users SET balance=balance+{$fivePercent} WHERE id='{$account->user_id}'");
					$db->query("INSERT INTO transaction SET user_id='{$account->user_id}', tx_no='{$txn}', tx_type='bonus', amount='{$fivePercent}', account_id='{$account->id}', description='Referral Bonus', paid_into='INTEREST WALLET'");
				}
			}
		} else {
			$exchange = new GeckoExchange;
			$_price = $exchange->coinGeckoRates(["bitcoin"]);
			if (count($_price)) {
				$_price = reset($_price);

				$amount = explode(" ", $transaction->description);
				$amount = str_replace("BTC", "", end($amount));
				$sel = $db->query("UPDATE users SET terra=terra+{$amount} WHERE id='{$transaction->user_id}'");
			}
		}
	} else {
		$sel = $db->query("UPDATE accounts SET status='0' WHERE id='{$transaction->account_id}'") or die($db->error);
	}
	return object(["status" => $sel]);
}

function verifyWalletCode($post)
{
	if (empty($_SESSION["changeWallet"]) || ($_SESSION["changeWallet"] != $post->code)) {
		$post->error = "Code incorrect";
	} else {
		$post->id = $_SESSION["user_id"];
		// activity([
		// 	"user_id" => $post->id,
		// 	"action" => "Change Wallet",
		// 	"location" => "users",
		// 	"submitType" => "insert",
		// 	"type" => 1,
		// 	"description" => "{$_SESSION["user_name"]} changed wallet to {$post->bitcoin} Plan"
		// ]);
	}
	return $post;
}

function verifyPassword($post)
{
	if (empty($_SESSION["resetPassword"]) || ($_SESSION["resetPassword"] != $post->code)) {
		$post->error = "Code incorrect";
	} else {
		if ($post->pwd == $post->pwd2) {
			$post->id = $_SESSION["user_id"];
			$post->pwd = password_hash($post->pwd, PASSWORD_DEFAULT);
			// activity([
			// 	"user_id" => $post->id,
			// 	"action" => "Change Password",
			// 	"location" => "users",
			// 	"submitType" => "insert",
			// 	"type" => 1,
			// 	"description" => "{$_SESSION["user_name"]} Changed Password"
			// ]);
		} else {
			$post->error = "Passwords Dont match";
		}
	}
	return $post;
}

function updateProfile($post)
{
	// activity([
	// 	"user_id" => $_SESSION["user_id"],
	// 	"action" => "Profile Update",
	// 	"location" => "users",
	// 	"submitType" => "insert",
	// 	"type" => 1,
	// 	"description" => "{$_SESSION["user_name"]} Upadated Profile"
	// ]);
	return ["status" => 1, "message" => "Successful"];
}

function loadcoins($generic)
{
	$uri = $generic->getURIData();
	require_once(absolute_filepath($uri->backend) . "controllers/GeckoExchange.php");
	$exchange = new GeckoExchange($generic);
	// see($generic);
	$coins = $exchange->coinGeckoList();
	$coins = array_map(function ($coin) {
		$coin->coin_id = $coin->id;
		$coin->symbol = strtoupper($coin->symbol);
		unset($coin->id);
		return $coin;
	}, $coins);
	return $coins;
}

function getCoinImage($coin)
{
	global $generic;
	$uri = $generic->getURIData();
	require_once(absolute_filepath($uri->backend) . "controllers/GeckoExchange.php");
	$exchange = new GeckoExchange();

	if (empty($coin->logo)) {
		$_coin = $exchange->coinGeckoRates([$coin->coin_id], !$generic->islocalhost());
		$_coin = reset($_coin);
		$coin->logo = $_coin->image;
	}

	return $coin;
}

function getCountries($uri = false, $object = true, $createOnly = false)
{
	global $generic;
	if (empty($uri)) global $uri;
	if (!empty($uri)) {
		$dir = absolute_filepath($uri->site) . "cache/";
		$file = "{$dir}countries.json";

		$build = json_decode(_readFile($file));

		if ($object === false) $build = json_encode($build);
		return $build;
	}
}

function get_param_countries($uri)
{
	$data = getCountries($uri);
	$list = [];
	foreach ($data as $key => $value) {
		$list[mb_strtolower($key)] = $value->name;
	}
	return $list;
}

function sendmail($post)
{
	if (gettype($post) == "object") {
		global $generic;
		$company = $generic->company();
		$messenger = new Messenger($generic);
		$post->message = "{$post->message} \r\n sent from : $post->email";
		$notify_mail = (object)[
			"subject" => $post->title,
			"body" => $post->message,
			"to" => $company->email,
			"from" => $company->email,
			"replyTo" => $post->email,
			"from_name" => ucwords($post->user_name),
			"to_name" => $company->name,
			"template" => "notify",
		];
		$response = $messenger->sendMail($notify_mail);
	}
	return $post;
}

function notifyUser($post)
{
	global $generic;

	if (!empty($post->notify)) {
		$user = $generic->getFromTable("users", "id={$post->user_id}");
		$user = reset($user);

		$messenger = new Messenger($generic);
		$company = $generic->company();
		$notify_mail = object([
			"subject" => "Withdrawal Approved",
			"body" => "Hi {$user->first_name}, your withdrawal of $ {$post->amount} into your {$post->paid_into} has been approved.",
			"to" => $user->email,
			"from" => $company->email,
			"from_name" => $company->name,
			"to_name" => $user->first_name,
			"template" => "notify",
		]);
		$post = $messenger->sendMail($notify_mail);
	}
	return $post;
}

function notify_admin($primary_key)
{
	global $generic;

	$user = $generic->getFromTable("users", "id={$primary_key}");
	$user = reset($user);

	$messenger = new Messenger($generic);
	$company = $generic->company();
	$notify_mail = object([
		"subject" => "New KYC Submission",
		"body" => "{$user->first_name} {$user->last_name} has upload a KYC document and is ready for approval.",
		"to" => $generic->secondary_email,
		"from" => $company->email,
		"from_name" => $company->name,
		"to_name" => "Admin",
		"template" => "notify",
	]);
	$post = $messenger->sendMail($notify_mail);
	$post->message = "Document under Review";
	return $post;
}

function get_percent($amount, $total)
{
	return empty($total) ? 0 : ($amount * 100) / $total;
}

function get_percent_of($percent, $amount)
{
	return ($amount * $percent) / 100;
}

function number_abbr__($number)
{
	$abbrevs = [12 => 'T', 9 => 'B', 6 => 'M', 3 => 'k', 0 => ''];

	foreach ($abbrevs as $exponent => $abbrev) {
		if (abs($number) >= pow(10, $exponent)) {
			$display = $number / pow(10, $exponent);
			$decimals = ($exponent >= 3 && round($display) < 100) ? 2 : 0;
			$number = number_format($display, $decimals) . $abbrev;
			break;
		}
	}

	return $number;
}

function myround($number)
{
	$fmn = new NumberFormatter("en", NumberFormatter::DECIMAL);

	return $fmn->format(round($number, 2));
}

function create_transaction_record($post)
{
	if ($post->submitType == "insert") {
		global $generic;
		$db = $generic->connect();
		$company = $generic->company();

		$sql = "INSERT INTO transaction
		(user_id, tx_no, tx_type, amount, description, account_id, paid_into, account_details, status)
		VALUES
		(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$investtr = $db->prepare($sql);
		$company_accounts = $company->branches;
		$company_accounts = $company_accounts[0];
		$post->paid_into 	= $company_accounts->title;
		$post->account_details 	= strip_tags($company_accounts->desc);
		$post->description = "Payment for {$post->name} Investment";
		$account_id = $post->primary_key;
		$post->tx_type = "deposit";
		$txref = uniqid($post->user_id);
		$investtr->bind_param('issisissi', $post->user_id, $txref, $post->tx_type, $post->amount, $post->description, $account_id, $post->paid_into, $post->account_details, $post->status);
		if (!$investtr->execute()) {
			$post->status = 0;
			$post->message = $db->error;
		}
	}
	return $post;
}

function calculate_roi($plan = null)
{
	$now = new DateTime();
	$duration = date("Y-m-d", strtotime("+{$plan->product}", time()));
	$duration_ = new DateTime($duration);
	$reoccurrence = date("Y-m-d", strtotime("+{$plan->view}", time()));
	$reoccurrence_ = new DateTime($reoccurrence);
	$duration = $duration_->diff($now)->days + 1;
	$reoccurrence = $reoccurrence_->diff($now)->days + 1;

	$timeframe = round($duration / $reoccurrence);
	return ($timeframe * $plan->auto);
}

function verify_token($post = null)
{
	if (empty($post->kyc_status)) {
		see($post);
		if (!isset($_SESSION[$post->action]) || $_SESSION[$post->action] != $post->pin) {
			$post->error = "Incorrect Token";
		} else {
			unset($_SESSION[$post->action]);
		}
	}
	return $post;
}
