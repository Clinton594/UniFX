<?php
$db = $generic->connect();
require_once("includes/client-authentication.php");
$pla = "SELECT first_name, last_name, referred_id, referral.status, amount, referral.date FROM referral LEFT JOIN users ON users.id=referral.referred_id WHERE referral_id='{$user->id}'";
$plan = $db->query($pla) or die($db->error . "($pla)");
$referals = [];
if ($plan->num_rows) {
  while ($row = $plan->fetch_object()) {
    $referals[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="en" class="js">

<head>
  <title>Affiliate program | <?= $company->name ?></title>
  <?php require_once("includes/client-links.php"); ?>
</head>

<body class="page-user">
  <?php require_once("includes/preloader.php"); ?>
  <div class="topbar-wrap mb-4">
    <?php require_once("includes/client-nav.php"); ?>
  </div>
  <!-- .topbar-wrap -->
  <div class="page-content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="main-content col-lg-10 col-xl-9">
          <div class="content-area card">
            <div class="card-innr">
              <div class="card-head">
                <h4 class="card-title card-title-md">Affiliate program</h4>
              </div>
              <div class="card-text">
                <p>New participants who register using your affiliate link become your referrals. Our affiliate program offers 4-tier compensation system for new referrals. You will get 8% of each deposit a Level 1 referral makes, 3% of the deposit a Level 2 referral makes, 1% of the deposit from a Level 3 referral and 1% of the deposit from a Level 4 referral . </p>
                <p>You can promote your affiliate link in any legal way. We provide all the necessary promotional materials and all kinds of support.</p>
              </div>
              <div class="referral-form">
                <div class="d-flex justify-content-between align-items-center">
                  <h5 class="mb-3 font-bold">Personal Referral link:</h5>
                </div>
                <div class="row align-items-end">
                  <div class="col-md-7 mb-2">
                    <div class="copy-wrap"> <span class="copy-feedback">
                      </span> <em class="fas fa-link">
                      </em>
                      <input type="text" class="copy-address" value="<?= $uri->site ?>?ref=<?= $user->username ?>" disabled>
                      <button class="copy-trigger copy-clipboard" data-clipboard-text="<?= $uri->site ?>?ref=<?= $user->username ?>">
                        <em class="ti ti-files">
                        </em>
                      </button>
                    </div>
                    <!-- .copy-wrap -->
                  </div>
                </div>
              </div>
              <div class="card" style="border: 2px #707A8A solid; box-shadow: none;">
                <div class="card-innr">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="card-head">
                        <h6 class="card-title">Your Status</h6>
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="card-head">
                        <h6 class="card-title">Your Commissions</h6>
                      </div>
                      <div class="row">
                        <div class="col-3">
                          <span class="card-sub-title">Tier 1</span>
                          <span class="lead font-weight-bold">8%</span>
                        </div>
                        <div class="col-3">
                          <span class="card-sub-title">Tier 2</span>
                          <span class="lead font-weight-bold">3%</span>
                        </div>
                        <div class="col-3">
                          <span class="card-sub-title">Tier 3</span>
                          <span class="lead font-weight-bold">1%</span>
                        </div>
                        <div class="col-3">
                          <span class="card-sub-title">Tier 4</span>
                          <span class="lead font-weight-bold">1%</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="token-transaction card" id="referrals">
            <div class="card-innr pb-0">
              <div class="card-head has-aside">
                <h4 class="card-title">Your Referrals</h4>
              </div>
              <ul class="nav nav-tabs nav-tabs-line">
                <li class="nav-item">
                  <a class="nav-link active" href="<?= $uri->site ?>join-affiliate?level=1#referrals">Tier 1 <small>(0)</small>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= $uri->site ?>join-affiliate?level=2#referrals">Tier 2 <small>(0)</small>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= $uri->site ?>join-affiliate?level=3#referrals">Tier 3 <small>(0)</small>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= $uri->site ?>join-affiliate?level=4#referrals">Tier 4 <small>(0)</small>
                  </a>
                </li>
              </ul>
            </div>
            <div class="sap">
            </div>
            <style>
              .reflist .data-head .data-col {
                text-align: right !important;
              }

              .reflist .data-head .data-col:first-child {
                text-align: left !important;
              }
            </style>
            <div class="card-innr reflist">
              <?php if (count($referals)) { ?>
                <table>
                  <thead>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Date</th>
                  </thead>
                  <tbody>
                    <?php foreach ($referals as $key => $referal) { ?>
                      <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $referal->first_name ?> <?= $referal->last_name ?></td>
                        <td><?= $currency . $fmn->format(round($referal->amount)) ?></td>
                        <td><?php $date = new DateTime($referal->date) ?> <?= $date->format("jS M, Y") ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              <?php } else { ?>
                <div class="alert alert-light"> No data </div>
              <?php }
              ?>
            </div>
          </div>
        </div>
        <!-- .col -->
      </div>
      <!-- .container -->
    </div>
    <!-- .container -->
  </div>
  <?php require_once("includes/client-footer.php"); ?>
</body>

</html>