<?php
require_once("includes/client-authentication.php");
$transactions = $generic->getFromTable("transaction", "user_id={$session->user_id}, status=1", 1, 0, ID_DESC);
$transactionx = array_group($transactions, "tx_type");

$deposits = $withdrawn = $reward = $topup = $invest = [];
if (isset($transactionx["deposit"])) $deposits = $transactionx["deposit"];
if (isset($transactionx["invest"])) $invest = $transactionx["invest"];
if (isset($transactionx["withdrawal"])) $withdrawn = $transactionx["withdrawal"];
if (isset($transactionx["topup"])) $topup = $transactionx["topup"];
if (isset($transactionx["bonus"])) $reward = $transactionx["bonus"];

$investments = $generic->getFromTable("accounts", "user_id={$session->user_id}", 1, 0, ID_DESC);

$status_value = $paramControl->load_sources("status");
$approval = $paramControl->load_sources("approval");
?>
<!DOCTYPE html>
<html lang="en" class="js">

<head>
  <title>Client area | <?= $company->name ?></title>
  <?php require_once("includes/client-links.php") ?>
</head>

<body class="page-user">
  <?php require_once("includes/preloader.php"); ?>
  <div class="topbar-wrap mb-4">
    <?php require_once("includes/client-nav.php"); ?>
    <div class="row">
      <div class="col-xl-9">
        <div class="card">
          <div class="card-innr">
            <div class="row justify-content-center">
              <div class="col-lg-4 mb-3 mb-lg-0">
                <h2>Welcome, <?= $user->first_name ?> <?= $user->last_name ?>!</h2>
              </div>
              <div class="col-lg-8">
                <div class="row mb-4">
                  <div class="col-md-12 mb-3 mb-md-0">
                    <div class="copy-wrap">
                      <span class="copy-feedback"></span>
                      <em class="fas fa-link"></em>
                      <input type="text" class="copy-address" value="<?= $uri->site ?>referral/<?= $user->username ?>" disabled>
                      <button class="copy-trigger copy-clipboard" data-clipboard-text="<?= $uri->site ?>referral/<?= $user->username ?>">
                        <em class="ti ti-files"></em>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-lg-4 mb-3 mb-lg-0">
                <div class="row">
                  <div class="col-12 mb-3 mb-sm-0 mb-lg-3 col-sm-6 col-lg-12">
                    <div class="card card-token mb-2 mb-md-0">
                      <div class="card-innr py-2 px-xl-3">
                        <div class="token-balance token-balance-with-icon">
                          <div class="token-balance-text">
                            <h6 class="card-sub-title">Available Balance</h6>
                            <span class="lead" style="font-size: 1.2em;">
                              <?= $currency . $fmn->format(round($user->balance, 2)) ?>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="row" style="margin-left: -8px; margin-right: -8px;">

                  <div class="col-md-4 px-2">
                    <div class="card card-token mb-2 mb-md-0">
                      <div class="card-innr py-2 px-xl-3">
                        <div class="token-balance token-balance-with-icon">
                          <div class="token-balance-text">
                            <h6 class="card-sub-title">Total invested</h6>
                            <span class="lead" style="font-size: 1.2em;">
                              <?= $currency . $fmn->format(array_sum(array_column($invest, "amount"))) ?>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 px-2">
                    <div class="card card-token mb-2 mb-md-0">
                      <div class="card-innr py-2 px-xl-3">
                        <div class="token-balance token-balance-with-icon">
                          <div class="token-balance-text">
                            <h6 class="card-sub-title">Total Earnings</h6>
                            <span class="lead" style="font-size: 1.2em;">
                              <?= $currency . $fmn->format(array_sum(array_column($topup, "amount")))  ?>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 px-2">
                    <div class="card card-token mb-0">
                      <div class="card-innr py-2 px-xl-3">
                        <div class="token-balance token-balance-with-icon">
                          <div class="token-balance-text">
                            <h6 class="card-sub-title">Total withdrawn</h6>
                            <span class="lead" style="font-size: 1.2em;">
                              <?= $currency . $fmn->format(array_sum(array_column($withdrawn, "amount"))) ?>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3">
        <div class="card" style="background: url(../assets/images/token-block-bg.png) no-repeat center #faebba; background-size: auto 160%;">
          <div class="card-innr">
            <h2 class="mb-3">BTC Asset</h2>
            <div class="row justify-content-center">
              <div class="col-lg-12">
                <div class="card card-token card-token-light mb-0">
                  <div class="card-innr">
                    <div class="token-balance token-balance-with-icon">
                      <div class="token-balance-text">
                        <h6 class="card-sub-title">Bitcoin Balance</h6>
                        <span class="lead" style="font-size: 1.2em;"> <?= round($user->terra, 4) ?> <span class="font-weight-normal">BTC</span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row no-gutters">
                  <div class="col pr-1">
                    <a href="<?= $uri->site ?>buy-tokens" class="btn btn-warning btn-auto btn-block mt-3">BUY</a>
                  </div>
                  <div class="col pl-1">
                    <button class="btn btn-secondary btn-auto btn-block mt-3" data-toggle="tooltip" data-placement="top" title="Sell TERRA tokens on our platform from 15th of September" style="font-size: 14px;" disabled>SELL</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="token-transaction card card-full-height">
          <div class="card-innr">
            <div class="card-head has-aside">
              <h4 class="card-title">Recent Transactions</h4>
              <div class="card-opt">
                <a href="<?= $uri->site ?>transactions" class="link ucap">View ALL <em class="fas fa-angle-right ml-2"></em>
                </a>
              </div>
            </div>
            <?php if (count($transactions)) { ?>
              <div class=table-responsive>
                <table class=table>
                  <thead>
                    <th>S/N</th>
                    <th>TX TYPE</th>
                    <th>TX REF</th>
                    <th>DESCRIPTION</th>
                    <th>AMOUNT</th>
                    <th>DATE</th>
                  </thead>
                  <tbody>
                    <?php foreach (array_range($transactions, 5) as $key => $trans) { ?>
                      <tr>
                        <td><?= intval($key) + 1 ?></td>
                        <td><?= strtoupper($trans->tx_type) ?></td>
                        <td><?= $trans->tx_no ?></td>
                        <td><?= $trans->description ?></td>
                        <td><?= $currency . $fmn->format(round($trans->amount, 2)) ?></td>
                        <td>
                          <?php $date = new DateTime($trans->date) ?>
                          <?= $date->format("jS M, Y") ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            <?php } else { ?>
              No transactions.
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="token-transaction card card-full-height">
          <div class="card-innr">
            <div class="card-head">
              <h4 class="card-title">Personal Statistics</h4>
            </div>
            <ul class="nav nav-tabs nav-tabs-line nav-fill" role="tablist">
              <li class="nav-item">
                <a class="nav-link active show" data-toggle="tab" href="#tab-item-1">Investments</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-item-2">Profit</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-item-3">Withdrawals</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-item-4">Rewards</a>
              </li>
            </ul>
            <div class="tab-content tab-stats">
              <div class="tab-pane fade active show" id="tab-item-1">
                <div class="row">
                  <div class="col-12 text-center">
                    <?php if (count($investments)) { ?>
                      <p>Deposits</p>
                      <div class=table-responsive>
                        <table class=table style="text-align: center;">
                          <thead>
                            <th>S/N</th>
                            <th>PLAN</th>
                            <th>CAPITAL</th>
                            <th>INVESTMENT DATE</th>
                            <th>COMPLETION DATE</th>
                            <th>STATUS</th>
                          </thead>
                          <tbody>
                            <?php foreach (array_range($investments, 5) as $key => $plan) { ?>
                              <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $plan->name ?></td>
                                <td><?= $currency . $fmn->format(round($plan->amount + $plan->reinvested)) ?></td>
                                <td>
                                  <?php $date = new DateTime($plan->date_created) ?>
                                  <?= $date->format("jS M, Y") ?>
                                </td>
                                <td>
                                  <?php
                                  $stop = new DateTime(date("Y-m-d", strtotime("+{$plan->duration}", strtotime($plan->date_created))))
                                  ?>
                                  <?= $stop->format("jS M, Y") ?>
                                </td>
                                <td>
                                  <span class="py-1 px-2 rounded"><?= $status_value[$plan->status] ?></span>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    <?php } else { ?>
                      <p>You didn't make any investments. <strong>Make your first investment.</strong>
                      </p>
                      <a class="btn btn-warning" href="<?= $uri->site ?>invest">Invest now</a>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="tab-item-2">
                <div class="row">
                  <div class="col-12 text-center">
                    <?php if (count($topup)) { ?>
                      <div class=table-responsive>
                        <table class=table>
                          <thead>
                            <th>S/N</th>
                            <th>TX REF</th>
                            <th>DESCRIPTION</th>
                            <th>AMOUNT</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                          </thead>
                          <tbody>
                            <?php foreach (array_range($topup, 5) as $key => $trans) { ?>
                              <tr>
                                <td><?= intval($key) + 1 ?></td>
                                <td><?= $trans->tx_no ?></td>
                                <td><?= $trans->description ?></td>
                                <td><?= $currency . $fmn->format(round($trans->amount)) ?></td>
                                <td>
                                  <?php $date = new DateTime($trans->date) ?>
                                  <?= $date->format("jS M, Y") ?>
                                </td>
                                <td>
                                  <?= $approval[$trans->status] ?>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    <?php } else { ?>
                      You didn't receive any profit.
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="tab-item-3">
                <div class="row">
                  <div class="col-12 text-center">
                    <?php if (count($withdrawn)) { ?>
                      <div class=table-responsive>
                        <table class=table>
                          <thead>
                            <th>S/N</th>
                            <th>TX REF</th>
                            <th>DESCRIPTION</th>
                            <th>AMOUNT</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                          </thead>
                          <tbody>
                            <?php foreach (array_range($withdrawn, 5) as $key => $trans) { ?>
                              <tr>
                                <td><?= intval($key) + 1 ?></td>
                                <td><?= $trans->tx_no ?></td>
                                <td><?= $trans->description ?></td>
                                <td><?= $currency . $fmn->format(round($trans->amount)) ?></td>
                                <td>
                                  <?php $date = new DateTime($trans->date) ?>
                                  <?= $date->format("jS M, Y") ?>
                                </td>
                                <td>
                                  <?= $approval[$trans->status] ?>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    <?php } else { ?>
                      You didn't make any withdrawals.
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="tab-item-4">
                <div class="row">
                  <div class="col-12 text-center">
                    <?php if (count($reward)) { ?>
                      <div class=table-responsive>
                        <table class=table>
                          <thead>
                            <th>S/N</th>
                            <th>TX REF</th>
                            <th>DESCRIPTION</th>
                            <th>AMOUNT</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                          </thead>
                          <tbody>
                            <?php foreach (array_range($reward, 5) as $key => $trans) { ?>
                              <tr>
                                <td><?= intval($key) + 1 ?></td>
                                <td><?= $trans->tx_no ?></td>
                                <td><?= $trans->description ?></td>
                                <td><?= $currency . $fmn->format(round($trans->amount)) ?></td>
                                <td>
                                  <?php $date = new DateTime($trans->date) ?>
                                  <?= $date->format("jS M, Y") ?>
                                </td>
                                <td>
                                  <?= $approval[$trans->status] ?>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    <?php } else { ?>
                      <p>You didn't get any rewards. <strong>Invite your friends and get rewards.</strong>
                      </p>
                      <a class="btn btn-warning" href="<?= $uri->site ?>affiliate">Invite friends</a>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- .container -->
  </div>
  <!-- .page-content -->

  <?php require_once("includes/client-footer.php") ?>
</body>

</html>