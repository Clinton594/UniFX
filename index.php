<?php
session_start();
require_once("backend/controllers/Controllers.php");
// require_once("backend/controllers/GeckoExchange.php");
// require_once("backend/controllers/NumberFormatter.php");
$generic = new Generic;
$generic->connect();
$company = $generic->company();
$uri = $generic->getURIdata();
// see($company);
$paramControl = new ParamControl($generic);
$session = object($_SESSION);

$forExchange = new GeckoExchange;
$currency = $paramControl->load_sources("currency");

$ext = pathinfo($uri->page_source, PATHINFO_EXTENSION);
if (!empty($ext)) {
  $url = $_SERVER['REQUEST_URI'];
  $url = str_replace(".$ext", "", $url);
  header("Location: $url");
}
$fmn = new NumberFormatter("en", NumberFormatter::DECIMAL);
$valid_pages = [
  '' => "home.php",
  'about' => "about.php",
  'referral' => "home.php",
  'contact-us' => "contact-us.php",
  'confirm-email' => "confirm-email.php",
  'sign-up' => "registration.php",
  'sign-in' => "login.php",

  'mining' => "mining.php",
  'sign-out' => "sign-out.php",
  'account' => "account.php",
  'settings' => "settings.php",
  'invest' => "client-invest.php",
  'fund-account' => "client-funding.php",
  'payment' => "client-payment.php",
  'withdraw' => "client-withdraw.php",
  'exchange' => "client-exchange.php",
  'wallets' => "client-wallet-details.php",
  'transactions' => "client-transactions.php",
  'operations' => "client-payment.php",
  'buy-tokens' => "client-buy-tokens.php",
  'join-affiliate' => "client-affiliate.php",
];
$cache_control = "?tabdle";

$page_exists = isset($valid_pages[$uri->page_source]);
if ($page_exists == true) {
  require_once("views/{$valid_pages[$uri->page_source]}");
} else {
  require_once("views/home.php");
}
