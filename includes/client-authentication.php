<?php
if (!empty($session->mloggedin)) {
  $user = $generic->getFromTable("users", "id={$session->user_id}");
  $user = reset($user);

  if (empty($user->status)) {
    header("Location: {$uri->site}confirm-email?redir={$_SERVER['REQUEST_URI']}");
    die();
  }

  //Coins
  $coins  = $generic->getFromTable("coins");
  $_price = $forExchange->coinGeckoRates(array_column($coins, "coin_id"));
  $_price = array_remap($_price, array_column($_price, "symbol"));

  $coins  = array_map(function ($coin) use ($_price) {
    $coin->price = $_price[$coin->symbol]->price;
    return $coin;
  }, $coins);
} else {
  header("Location: {$uri->site}sign-in?redir={$_SERVER['REQUEST_URI']}");
  die();
}
