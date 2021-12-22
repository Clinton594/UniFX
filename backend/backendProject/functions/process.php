<?php
require_once("../controllers/Messenger.php");
// require_once("../controllers/GeckoExchange.php");
// require_once("../controllers/NumberFormatter.php");

$currency = $paramControl->load_sources("currency");
$session = object($_SESSION);
$exclusions = ["account-updates", "getReferrals", "sendLoanRequest"];
if (!in_array($post->case, $exclusions)) {
	if (empty($session->user_id)) die("Access Denied");
}

// $fmn = new NumberFormatter;
$fmn = new NumberFormatter("en", NumberFormatter::DECIMAL);

switch ($post->case) {
	case "resendPin": //Resend Pin
		$messenger = new Messenger($generic);
		$messenger->pinAction = empty($post->pinAction) ? "login" : $post->pinAction;
		$user = $generic->getFromTable("users", "id={$session->user_id}", 1, 0)[0];
		$response = sendCode($messenger, $user);
		break;
	case "confirm-email": //Resend Pin
		// see($session);
		if (!empty($session->{$post->pinAction})) {
			if ($session->{$post->pinAction} == $post->pin) {
				unset($_SESSION[$post->pinAction]);
				$user = $generic->getFromTable("users", "id={$session->user_id}", 1, 0)[0];
				if (empty($user->status)) {
					$db->query("UPDATE users SET status='1' WHERE id='{$session->user_id}'");
				}
				$response->status = 1;
				$_SESSION["mloggedin"] = 1;
			} else $response->message = "Incorrect token";
		} else {
			$response->message = "Please Resend Code";
		}
		break;
	case "getReferrals": //
		$response->status = 1;
		$referals = $generic->getFromTable("referral", "referral_id={$post->id}", 1, 0);
		$users 		= implode(",", array_unique(array_column($referals, "referred_id")));
		$users 		= $generic->getFromTable("users", "id in ({$users})", 1, 0);

		$table = "<table><thead><tr><th>First Name</th><th>Last Name</th><th>Date Reg</th></tr></thead>";
		foreach ($users as $key => $user) {
			$date = new DateTime($user->date);
			$date = $date->format("jS M");
			$table .= "<tr><td>{$user->first_name}</td><td>{$user->last_name}</td><td>{$date}</td></tr>";
		}
		$table .= "</td>";
		$response->data = $table;
		break;
	case "account-updates": //Resend Pin
		$actions = ["-" => "Withdrawn from", "+" => "Deposited into"];
		$subject = ["-" => "Withdrawal Alert", "+" => "Deposit Alert"];
		$_action = ["-" => "withdrawals", "+" => "interests"];
		$wallet = $generic->getFromTable("accounts", "id={$post->id}");
		$wallet = reset($wallet);
		$transaction = (object)[
			"user_id" => $wallet->user_id,
			"tx_no" => random(16),
			"status" => 1,
			"notify" => !empty($post->notify),
			"amount" => $post->amount,
			"paid_into" => "INTEREST WALLET",
			"snapshot" => "NULL",
			"account_details" => "INTEREST WALLET",
			"account_id" => $wallet->id,
			"description" => "{$post->amount} {$wallet->name} {$actions[$post->increment]} your interest wallet."
		];
		$response = $generic->insert($transaction, $_action[$post->increment]);
		$response->status = $db->query("UPDATE users SET balance=balance{$post->increment}{$post->amount} WHERE id='{$wallet->user_id}'");

		if (!empty($response->status) && !empty($post->notify)) {
			$messenger = new Messenger($generic);
			$user = $generic->getFromTable("users", "id={$wallet->user_id}");
			$user = reset($user);
			$response = $messenger->sendMail(object([
				"subject" => "New {$subject[$post->increment]} !!!",
				"body" => "Congratulations, {$currency}{$post->amount} was successfuly {$actions[$post->increment]} your interest wallet.",
				"template" => "success",
				"to" => $user->email,
				"from" => $company->email,
				"from_name" => $company->name,
				"to_name" => $user->first_name,
			]));
		}
		break;
	case "convertCurrency": //Get Converstion Rates of local currencies and BTC against dollars
		require_once(absolute_filepath("{$uri->backend}controllers/GeckoExchange.php"));
		$post->coin = strtoupper($post->coin);
		$exchange = new GeckoExchange;

		$coin  	= $generic->getFromTable("coins", "symbol={$post->coin}");
		$coin 	= reset($coin);

		$usdRate  = $exchange->coinGeckoRates([$coin->coin_id]);
		$usdRate = reset($usdRate);
		$response->data = $fmn->format(round(($post->amount / $usdRate->price), 4));
		$response->status = 1;
		break;
	case "calculator": //Serverside price calculation
		$response = ["value" => round(($post->amount / $post->rate), 2)];
		break;
	case "getCoins": //Serverside get coin prices
		$exchange = new GeckoExchange;
		$coins  = $generic->getFromTable("coins");
		$_price = $GeckoExchange->coinGeckoRates(array_column($coins, "coin_id"));
		$_price = array_remap($_price, array_column($_price, "symbol"));

		$coins  = array_map(function ($coin) use ($_price) {
			$coin->price = $_price[$coin->symbol]->price;
			return $coin;
		}, $coins);
		$response->status = 1;
		$response->data = array_remap($coins, array_column($coins, "symbol"));
		break;
	case "withdrawal": //Serverside price calculation

		if ($post->pin == $session->withdrawal) {
			$user = $generic->getFromTable("users", "id={$session->user_id}");
			$user = reset($user);
			if ($post->amount <= $user->balance) {
				$wallet = json_decode($user->wallet);
				$db->query("UPDATE users SET balance=balance-{$post->amount} WHERE id = {$user->id}");
				$sql =
					"INSERT INTO transaction
					(user_id, tx_no, tx_type, amount, description, account_id, paid_into, snapshot, account_details, status)
					VALUES
					(?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
				$investtr = $db->prepare($sql);

				$zero = 0;
				$amount = $fmn->format($post->amount);
				$post->description = "Withdrawal of {$currency}{$amount}";
				$post->trnx_no = uniqid($user->id);
				$post->tx_type = "withdrawal";

				$investtr->bind_param('issisisss', $user->id, $post->trnx_no, $post->tx_type, $post->amount, $post->description, $zero, $post->coin, $zero, $wallet->{$post->coin});
				if ($investtr->execute()) {
					$response->status = 1;
					$response->data = ["key" => $db->insert_id, "hash_key" => $post->trnx_no];

					// Notify Customer
					$messenger = new Messenger($generic);
					$mail = (object)[
						'subject' => "Withdrawal Alert from {$company->name}",
						'body' => "Hi, {$user->first_name}, a withdrawal request of {$currency}{$amount} has been placed on your account. \n If you did not initiate this, please contact the support immediately. Thank you for choosing {$company->name}.",
						'from' => $company->email,
						'to' => $user->email,
						'from_name' => $company->name,
						'to_name' => $user->first_name,
						'address' => $company->address,
						'user_id' => $user->id
					];
					$responseEmail = $messenger->sendMail($mail);
					$mail->to = $generic->secondary_email;
					$mail->to_name = "Administrator";
					$mail->body = "New Withdrawal request from {$user->first_name}. Login to View transaction details";
					$responseMail2 = $messenger->sendMail($mail);
				}
			} else $response->message = "Insuffient Balance";
			unset($_SESSION["withdraw"]);
		} else $response->message = "Incorrect Token";

		break;
	case 'invest': //Create Invoice
		$duration = $paramControl->load_sources("lock_duration");
		$user_id = $session->user_id;
		$plans = $generic->getFromTable("content", "id={$post->plan_id}, status=1");
		$user = $generic->getFromTable("users", "id={$session->user_id}, status=1")[0];
		if (count($plans)) {
			$thisplan = reset($plans);
			$zero = 0;

			$post->amount = intval($post->amount);
			$thisplan->business = intval($thisplan->business);
			if (($post->amount >= $thisplan->business && $post->amount <= $thisplan->label) || $thisplan->business === $post->amount && $post->amount <= $user->Balance) {
				$db->query("UPDATE users SET balance=balance-{$post->amount} WHERE id='{$user_id}'");

				$next_unlock = date("Y-m-d H:i:s", strtotime("+{$duration}", strtotime(date("Y-m-d H:i:s"))));
				$sql = "INSERT INTO accounts
				(user_id, plan, name, capital, status, date_created, identify, roi, amount, duration, next_unlock, reoccur)
				VALUES
				(?, ?, ?, ?, 1, now(), ?, ?, ?, ?, ?, ?)";
				$invest = $db->prepare($sql);
				$invest->bind_param('iissssssss', $user->id, $thisplan->id, $thisplan->title, $zero, $thisplan->type, $thisplan->auto, $post->amount, $thisplan->product, $next_unlock, $thisplan->view);
				if ($invest->execute()) {
					$sql =
						"INSERT INTO transaction
						(user_id, tx_no, tx_type, amount, description, account_id, status)
						VALUES
						(?, ?, ?, ?, ?, ?, 1)";
					$investtr = $db->prepare($sql);
					$post->description = $db->real_escape_string("{$thisplan->title} Investment");
					$post->trnx_no = uniqid($user_id);
					$post->tx_type = "invest";


					$investtr->bind_param('issisi', $user_id, $post->trnx_no, $post->tx_type, $post->amount, $post->description, $db->insert_id);
					if ($investtr->execute()) {
						$response->status = 1;
						$response->data = ["key" => $db->insert_id, "hash_key" => $post->trnx_no];
					} else $response->message = $db->error;
				} else $response->message = $db->error;
			} else $response->message = "Enter correct price range";
		} else $response->message = "Investment is currenly unavailable";
		break;

	case 'fund-account': //Fund Account

		$coin = $generic->getFromTable("coins", "id={$post->PSys}");
		$coin = reset($coin);
		$post->trnx_no = uniqid($session->user_id);
		$post->tx_type = "invoice";
		$post->description = "Account Deposit of {$currency}{$post->amount}";
		$sql =
			"INSERT INTO transaction
					(user_id, tx_no, tx_type, amount, account_id, paid_into, snapshot, account_details, status, description)
					VALUES
					(?, ?, ?, ?, 0, ?, ?, ?, 0, ?)";
		$investtr = $db->prepare($sql);

		$investtr->bind_param('ississss', $session->user_id, $post->trnx_no, $post->tx_type, $post->amount, $coin->symbol, $coin->qr_code, $coin->wallet, $post->description);
		if ($investtr->execute()) {
			$response->status = 1;
			$response->data = ["key" => $db->insert_id, "hash_key" => $post->trnx_no];
		}
		break;

	case "notify-deposit":
		$transaction = $generic->getFromTable("transaction", "id={$post->InvID}, user_id='{$session->user_id}', tx_type=invoice");


		if (count($transaction)) {
			$transaction = reset($transaction);

			$user = $generic->getFromTable("users", "id={$transaction->user_id}");
			$user = reset($user);

			$update = $db->query("UPDATE transaction SET tx_type='deposit' WHERE id='{$transaction->id}'");

			$messenger = new Messenger($generic);
			$mail = (object)[
				'subject' => "New {$company->name} Investment !!!",
				'body' => "Hi, {$user->first_name},  we just recieved a payment notification of {$currency}{$transaction->amount}. \n Please be patient while our team verifies the payment, your account balance would be automatically updated as soon your payment verification is completed. Thank you for choosing {$company->name}.",
				'from' => $company->email,
				'to' => $user->email,
				'from_name' => $company->name,
				'to_name' => $user->first_name,
				'address' => $company->address,
				'template' => "notify"
			];
			$response = $messenger->sendMail($mail);
			// NOtify admin
			$mail->to = $generic->secondary_email;
			$mail->to_name = "Administrator";
			$mail->body = "New Payment from {$user->first_name}. Login to View transaction details";
			$responseMail2 = $messenger->sendMail($mail);

			$response->message = "Payment review in progress";
		} else $response->message = "Invoice is no longer available";
		break;

	case "confirm-investment":
		$duration = $paramControl->load_sources("lock_duration");
		$transaction = $generic->getFromTable("transaction", "id={$post->InvID}, tx_type=invoice");
		if (count($transaction)) {
			$transaction = reset($transaction);
			$zero = 0;

			// Get the plan info
			$thisplan = $generic->getFromTable("content", "id={$transaction->account_id}");
			$thisplan = reset($thisplan);

			// Get the user info
			$user = $generic->getFromTable("users", "id={$transaction->user_id}");
			$user = reset($user);

			if (($transaction->amount >= $thisplan->business && $transaction->amount <= $thisplan->label) || $thisplan->business === $transaction->amount) {

				$next_unlock = date("Y-m-d H:i:s", strtotime("+{$duration}", strtotime(date("Y-m-d H:i:s"))));
				$sql = "INSERT INTO accounts
				(user_id, plan, name, capital, status, paid, date_created, identify, roi, amount, duration, next_unlock, reoccur)
				VALUES
				(?, ?, ?, ?, 0, 1, now(), ?, ?, ?, ?, ?, ?)";
				$invest = $db->prepare($sql);
				$invest->bind_param('iissssssss', $user->id, $thisplan->id, $thisplan->title, $zero, $thisplan->type, $thisplan->auto, $transaction->amount, $thisplan->product, $next_unlock, $thisplan->view);
				if ($invest->execute()) {
					$update = $db->query("UPDATE transaction SET tx_type='deposit', account_id='{$db->insert_id}' WHERE id='{$transaction->id}'");
					if ($update) {
						$messenger = new Messenger($generic);
						$mail = (object)[
							'subject' => "New {$company->name} Investment !!!",
							'body' => "Hi, {$user->first_name},  we just recieved a payment notification of {$currency}{$transaction->amount} for {$thisplan->title}. \n Please be patient while our team verifies the payment, your investment would be active as soon as the verification is done. Thank you for choosing {$company->name}.",
							'from' => $company->email,
							'to' => $user->email,
							'from_name' => $company->name,
							'to_name' => $user->first_name,
							'address' => $company->address,
							'user_id' => $user->id
						];
						$responseEmail = $messenger->sendMail($mail);
						$mail->to = $generic->secondary_email;
						$mail->to_name = "Administrator";
						$mail->body = "New Payment from {$user->first_name}. Login to View transaction details";
						$responseMail2 = $messenger->sendMail($mail);
						$response->status = 1;
						$response->message = "Your payment for {$thisplan->title} has been recieved";
					}
				} else $response->message = $db->error;
			} else $response->message = "Please do not alter the price";
		} else $response->message = "This invoice is no longer available, kindly generate a new one.";
		break;

	case 'submitExchange':
		$GeckoExchange = new GeckoExchange;
		$tx_no = uniqid($session->user_id);

		$coins  	= $generic->getFromTable("coins");
		$coin 	= array_filter($coins, function ($coin) use ($post) {
			return $coin->symbol == $post->PSys;
		});
		$coin 	= reset($coin);

		$temp = array_filter($coins, function ($temp) use ($post) {
			return in_array($temp->symbol, [$post->PSys, $post->PSys2]);
		});
		$temp = array_column($temp, "coin_id");

		$_price = $GeckoExchange->coinGeckoRates($temp);
		$_price = array_remap($_price, array_column($_price, "symbol"));

		$equivalence = ($post->amount * $_price[$post->PSys]->price) / $_price[$post->PSys2]->price;
		$equivalence = $fmn->format(round($equivalence, 4));
		$amount  = $fmn->format(round($post->amount, 4));

		$response = $generic->insert(
			object(["user_id" => $session->user_id, "tx_no" => $tx_no, "amount" => $post->amount, "description" => "Exchange of {$amount}{$post->PSys} to {$equivalence}{$post->PSys2}", "status" => 2, 'account_details' => $coin->wallet, "paid_into" => $post->PSys, "snapshot" => $coin->qr_code, "temp" => $post->PSys2]),
			"exchange"
		);
		if ($response->status) $response->tx_no = $tx_no;

		break;
	case 'confirm-exchange': //Clinent Confirms payment of exchange 
		$user = $generic->getFromTable("users", "id={$session->user_id}");
		$user = reset($user);
		$user->wallet = json_decode($user->wallet);
		$transaction = $generic->getFromTable("transaction", "id={$post->InvID}");
		if (count($transaction)) {
			$transaction = reset($transaction);
			$update = $db->query("UPDATE transaction SET account_details='{$user->wallet->{$transaction->temp}}', status='0' WHERE id='{$transaction->id}'");
			if ($update) $response->status = 1;
		} else $response->message = "This invoice is no longer available, kindly generate a new one.";

		break;
	case 'submit-wallet': // Client submit thier wallet address
		if (!empty($session->wallet) && $post->pin == $session->wallet) {
			$coins = $generic->getFromTable("coins");
			$coins = array_column($coins, "symbol");

			$addresses = json_encode(array_extract(array_filter(arrray($post)), $coins, true));
			$response->status = $db->query("UPDATE users SET wallet='{$addresses}' WHERE id='{$session->user_id}'");
			unset($_SESSION["wallet"]);
			break;
		} else $response->message = "Incorrect token";

	case 'reinvest': //Reinvest This investment
		// Get current user
		$user = $generic->getFromTable("users", "id={$session->user_id}");
		$user = reset($user);
		// Get the investement for reinvesting
		$account = $generic->getFromTable("accounts", "id={$post->plan}, user_id={$session->user_id}, status!=3");
		if (count($account)) {
			$account = reset($account);
			if ($account->amount <= $user->balance) {
				// Deduct the money from the user's balance
				$db->query("UPDATE users SET balance=balance-{$account->amount} WHERE id={$user->id}");
				// Restart the investment
				$db->query("UPDATE accounts SET date_created=now(), next_unlock=now(), status='1', reinvested=reinvested+{$account->amount} WHERE id={$account->id}");
				$response->status = 1;
				$response->message = "Investment restarted";
			} else $response->message = "Insufficient balance to complete operation.";
		} else $response->message = "An Error Occurred";

		break;
	case 'cancel-investment':
		// Get current user
		$user = $generic->getFromTable("users", "id={$session->user_id}");
		$user = reset($user);
		// Get the investement for reinvesting
		$account = $generic->getFromTable("accounts", "id={$post->plan}, user_id={$session->user_id}, status!=3");
		if (count($account)) {
			$account = reset($account);
			// Deduct the money from the user's balance
			$db->query("UPDATE users SET balance=balance+{$account->amount} WHERE id={$user->id}");
			// Cancel the investment
			$db->query("UPDATE accounts SET status='3' WHERE id={$account->id}");
			$response->status = 1;
			$response->message = "Investment Cancelled";
		} else $response->message = "An Error Occurred";

		break;
	case 'free-mine':
		$range = $range = array_map("trim", explode("-", $company->other));

		$range = array_map(
			function ($val) {
				return $val * 10;
			},
			$range
		);
		$range = range(min($range), max($range));
		$range = array_map(
			function ($val) {
				return $val / 10;
			},
			$range
		);

		$reward = $range[array_rand($range)];
		$tx_no = uniqid($session->user_id);

		$today = date("Y-m-d");
		$transactions = $generic->getFromTable("transaction", "tx_type=mining, user_id={$session->user_id}", 1, 10, ID_DESC);
		$transactions = array_filter($transactions, function ($trans) use ($today) {
			$date = new DateTime($trans->date);
			return $date->format("Y-m-d") == $today;
		});
		if (!count($transactions)) {
			if (date("H") <= 22) {
				$response = $generic->insert(
					object(["user_id" => $session->user_id, "tx_no" => $tx_no, "amount" => $reward, "description" => "Rewarded with {$currency}{$reward} for mining", "status" => 1, "temp" => "mining", "paid_into" => "-", "account_details" => "-", "snapshot" => "-"]),
					"mining"
				);
				if ($response->status) {
					$response->reward = $reward;
					$db->query("UPDATE users SET balance=balance+{$reward} WHERE id={$session->user_id}");
				}
			} else $response->message = "You can't mine at this hour";
		} else $response->message = "You have already mined for today";

		break;
	case "sendLoanRequest":
		$messenger = new Messenger($generic);
		$mail = (object)[
			'subject' => "New Loan Request",
			'body' => $post->msg,
			'from' => $post->email,
			'to' => $company->email,
			'from_name' => $post->name,
			'to_name' => $company->name,
			'address' => $company->address,
			'template' => "notify"
		];
		$response = $messenger->sendMail($mail);
		break;
	case 'closeInvoice':
		$db->query("UPDATE transaction SET status='4', tx_type='cancelled' WHERE id='{$post->id}' AND user_id='{$session->user_id}'") or die($db->error);
		break;

	default:
		return (false);
}
