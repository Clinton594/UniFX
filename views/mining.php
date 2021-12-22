<?php
require_once("includes/client-authentication.php");
$range = array_map("trim", explode("-", $company->other));
$today = date("Y-m-d");
$transactions = $generic->getFromTable("transaction", "tx_type=mining, user_id={$user->id}", 1, 0, ID_DESC);
$transactionx = array_filter($transactions, function ($trans) use ($today) {
  $date = new DateTime($trans->date);
  return $date->format("Y-m-d") == $today;
});

$total = array_sum(array_column($transactions, "amount"));
$transactions = array_range($transactions, 10);
?>
<!DOCTYPE html>
<html lang="en" class="js">

<head>
  <title>Free Mining | <?= $company->name ?></title>
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
      <div class="row">
        <div class="col-xl-3">
          <div class="card" style="background: url(<?= $uri->site ?>assets/images/token-block-bg.png) no-repeat center #faebba; background-size: auto 160%;">
            <div class="card-innr">
              <h2 class="mb-3">Free Mining</h2>
              <div class="row justify-content-center">
                <div class="col-lg-12">
                  <div class="card card-token card-token-light mb-0">
                    <div class="card-innr">
                      <div class="token-balance token-balance-with-icon">
                        <div class="token-balance-text">
                          <h6 class="card-sub-title">Total Mined</h6>
                          <span class="lead" style="font-size: 1.2em;"> <?= $fmn->format($total) ?> <span class="font-weight-normal"><?= $currency ?></span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row no-gutters">
                    <div class="col pr-1">
                      <?php if (count($transactionx)) { ?>
                        <p class="mt-3 text-danger"><strong>Today's Task Completed</strong></p>
                      <?php } else { ?>
                        <form action="" id="mine-today">
                          <button href="javascript:;" type="submit" class="btn btn-warning btn-auto btn-block mt-3 submit">Mine Today</button>
                          <strong class=""></strong>
                        </form>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="main-content col-lg-12 col-xl-9">
          <div class="content-area card">
            <div class="card-innr">
              <div class="card-head">
                <h4 class="card-title card-title-md">Free Mining Program</h4>
              </div>
              <div class="card-text">
                <p>Free mining is a program newly introduced by <?= $company->name ?> LTD for a selected few members. If you are here, it means you are eligible to start earning free rewards for as much as <strong><?= $currency . max($range) ?></strong> daily.</p>
                <p>The rewards you earn on a daily basis is automatically added to your wallet and you can withdraw it directly into any crypto wallet of your choice outside <?= $company->name ?>.</p>
                <p>You are only eligible to mine once in a day to earn a reward within the range of <strong><?= $currency . min($range) ?></strong> to <strong><?= $currency . max($range) ?></strong>.</p>
                <hr>
              </div>
              <div class="referral-form">
                <div class="">
                  <h5 class="mb-3 font-bold">Personal Referral link:</h5>
                  <p><small>Share your referral link to your friends and earn more with them.</small></p>
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
                  </div>
                </div>
                <hr>
              </div>

              <div class="card-text">
                <div class="card-innr">
                  <div class="card-head">
                    <h4 class="card-title">Mining History</h4>
                  </div>

                  <div class=table-responsive>
                    <table class=table>
                      <thead>
                        <th>S/N</th>
                        <th>TX REF</th>
                        <th>DESCRIPTION</th>
                        <th>AMOUNT</th>
                        <th>DATE</th>
                      </thead>
                      <tbody>
                        <?php foreach ($transactions as $key => $trans) { ?>
                          <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $trans->tx_no ?></td>
                            <td><?= $trans->description ?></td>
                            <td>
                              <?= $currency . $fmn->format(($trans->amount)) ?>
                            </td>
                            <td>
                              <?php $date = new DateTime($trans->date) ?>
                              <?= $date->format("jS M, Y") ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
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
  <script>
    $(document).ready(function() {
      if ($("#mine-today").length) {
        $("#mine-today").submitForm({
          case: "free-mine",
          process_url: `${site.process}custom`
        }, null, function(response) {
          $("#mine-today > strong").text(`Reward : $${response.reward}`);
          setTimeout(() => {
            window.location.reload();
          }, 2000);
        })
      }
    })
  </script>
</body>


</html>