<?php
require_once("controllers/Generic.php");
require_once("controllers/ParamControl.php");

$generic = new Generic;
$db = $generic->connect();
$company = $generic->company();
$paramcontrol = new ParamControl($generic);
$countdown = $paramcontrol->load_sources("countDown");

$response = [];

// Get all real estates and investments
$transactions = $generic->getFromTable("transaction", "tx_type=INVOICE");
//Loop through the investments
$count = 0;
foreach ($transactions as $transaction) {

  $moment = new DateTime();
  $started = new DateTime($transaction->date);

  // $started->setTimeZone($timezone);
  // $moment->setTimeZone($timezone);

  $start = strtotime($started->format("Y-m-d H:i:s"));
  $end = strtotime("+{$countdown}", $start);
  $now = $moment->getTimestamp();

  if ($now > $end) {
    $db->query("UPDATE transaction SET status='4', tx_type='cancelled' WHERE id='{$transaction->id}'") or die($db->error);
    $count++;
  }
}
echo "Deleted {$count} invoices";
