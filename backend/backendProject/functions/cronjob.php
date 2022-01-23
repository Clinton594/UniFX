<?php
require_once("controllers/Generic.php");
require_once("controllers/DateDifference.php");
require_once("controllers/Messenger.php");
$generic = new Generic;
$db = $generic->connect();
$company = $generic->company();


$response = [];

// Get all real estates and investments
$accounts = $generic->getFromTable("accounts", "status=1, identify=investment, identify=real-estate", 1, 0);

$users = $generic->getFromTable("users");
$users = array_remap($users, array_column($users, "id"));

$messenger = new Messenger($generic);

//Loop through the investments
foreach ($accounts as $account) {
  //Check if investment duration is still due
  $today            = new DateTime(date("Y-m-d", time()));
  $date_created     = new DateTime($account->date_created);
  $last_topup       = new DateTime($account->last_topup);

  $stopdate   = date("YmdHis", strtotime("+{$account->duration}", strtotime($account->date_created)));
  $currdate   = date("YmdHis");

  //Set status to completed
  if ($currdate > $stopdate) {
    // Turn off the investment
    $db->query("UPDATE accounts SET status='2' WHERE id='{$account->id}'") or die($db->error);
    $db->query("UPDATE users SET balance=balance+{$account->amount} WHERE id={$account->user_id}");

    $rand = uniqid($account->user_id);
    $trs = $db->query("INSERT INTO transaction (user_id, tx_no, tx_type, paid_into, account_details, amount, description, account_id, status) VALUES ('{$account->user_id}', '{$rand}', 'completion', 'MYWALLET', 'xxxxxxxxxxxxxxxxx', '{$account->amount}', 'Completed {$account->name} investment cycle','{$account->id}', '1')");

    $messenger->sendMail(
      object(
        [
          "subject" => "{$account->name} Completed",
          "body" => "Hi {$users[$account->user_id]->first_name}, your {$account->name} investment has just completed. Proceed to withdraw your earnings.",
          "to" => $users[$account->user_id]->email,
          "from" => $company->email,
          "to_name" => $users[$account->user_id]->first_name,
          "from_name" => $company->name,
          "template" => "notify"
        ]
      )
    );
  } else {

    //Check if the last time it topped up is today. (It must not top up twice in a day)
    if ($last_topup->format("Ymd") !== date("Ymd")) {
      $next_release = "";

      // Calculate daily percentage
      $reoccur   = date("Ymd", strtotime("+{$account->reoccur}", strtotime(date("Y-m-d", time()))));
      $reoccur   = new DateTime($reoccur);
      $reoccurance_days = $reoccur->diff($today)->days;

      $percent = get_percent_of($account->roi, $account->amount);
      $account->increase = round(($percent / $reoccurance_days), 2);

      // //Calculate next available withdrawal date if available
      // $next_unlock   = date("Ymd", strtotime($account->next_unlock));

      // if (($next_unlock <= $currdate)) { //if next_unlock is today or a day that has passed
      //   $next_unlock   = date("Y-m-d", strtotime("+{$lock_duration}", time()));
      //   $next_release  = "next_unlock='{$next_unlock}',";
      // }

      // Update last top_up of the investment
      $con = $db->query("UPDATE accounts SET {$next_release} last_topup=now() WHERE id='{$account->id}'");
      // Update interest balance of the user
      $con = $db->query("UPDATE users SET balance=balance+{$account->increase} WHERE id='{$account->user_id}'");

      $rand = uniqid($account->user_id);
      $trs = $db->query("INSERT INTO transaction (user_id, tx_no, tx_type, paid_into, account_details, amount, description, account_id, status) VALUES ('{$account->user_id}', '{$rand}', 'topup', 'MYWALLET', 'xxxxxxxxxxxxxxxxx', '{$account->increase}', 'Top Up for {$account->name} investment','{$account->id}', '1')");

      if (!$trs) {
        $response[$account->id] = $db->error;
      } else {
        $response[$account->id] = $account->increase;
      }
    }
  }
}

$db->close();
// $response = $messenger->sendMail(
//   object(
//     [
//       "subject" => "Cron Ran",
//       "body" => "This is a confirmation that your cron job has executed." . json_encode($response),
//       "to" => "uc_modulus@yahoo.com",
//       "from" => $company->email,
//       "to_name" => "Clinton",
//       "from_name" => $company->name
//     ]
//   )
// );
see($response);
