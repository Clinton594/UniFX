<?php
require_once("includes/client-authentication.php");
require_once("{$generic->backend}controllers/ForExchange.php");
$transaction = [];

if ($uri->page_source == "payment") {
  $param = object($_GET);
  if (!empty($param->hash) && !empty($param->_k)) {
    $transaction = $generic->getFromTable("transaction", "id={$param->_k}, tx_no={$param->hash}");
  }
} else {
  $transaction = $generic->getFromTable("transaction", "user_id={$session->user_id}, tx_type=invoice");
}
if (count($transaction)) {
  $transaction = reset($transaction);

  $temp = array_filter($coins, function ($temp) use ($transaction) {
    return $temp->symbol == $transaction->paid_into;
  });
  $temp = reset($temp);

  $price = $forExchange->coinGeckoRates([$temp->coin_id], !$generic->islocalhost());
  $coin = reset($price);
}
?>
<!DOCTYPE html>
<html lang="en" class="js">

<head>
  <title>Operation | <?= $company->name ?></title>
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



      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-9 col-xl-8">
            <div class="card content-area">
              <div class="card-innr">
                <?php if (isset($transaction->tx_no)) {
                  if ($transaction->tx_type != "exchange") $amount =  round(($transaction->amount / $coin->price), 4);
                  else $amount =  $transaction->amount;
                ?>
                  <h4 class="popup-title">Payment Details</h4>
                  <form id="payment">
                    <div class="row align-items-center">
                      <div class="col-6 col-sm-3 mb-3 mb-sm-0">
                        <img src="<?= $transaction->snapshot ?>" class="img-fluid">
                      </div>
                      <div class="col-12 col-sm-9">
                        <label><?= $transaction->paid_into ?> Deposit Address</label>
                        <div class="copy-wrap mgb-0-5x mb-3"> <span class="copy-feedback">
                          </span>
                          <input type="text" class="copy-address" value="<?= $transaction->account_details ?>" readonly style="padding-left: 15px;">
                          <span class="copy-trigger" data-clipboard data-clipboard-text="<?= $transaction->account_details ?>">
                            <input type="hidden" name="InvID" value="<?= $transaction->id ?>">
                            <?php if ($transaction->tx_type == "exchange") { ?>
                              <input type="hidden" name="case" value="confirm-exchange">
                            <?php } else { ?>
                              <input type="hidden" name="case" value="notify-deposit">
                            <?php } ?>
                            <em class="ti ti-files"></em>
                          </span>
                        </div>
                        <!-- .copy-wrap -->
                        <label>Deposit amount</label>
                        <div class="copy-wrap mgb-0-5x"> <span class="copy-feedback">
                          </span>
                          <input type="text" class="copy-address" value="<?= $amount ?> <?= $transaction->paid_into ?>" readonly style="padding-left: 15px;">
                          <span class="copy-trigger" data-clipboard data-clipboard-text="<?= $amount ?>">
                            <em class="ti ti-files"></em>
                          </span>
                        </div>
                        <!-- .copy-wrap -->
                      </div>
                    </div>
                    <div class="row my-3" style="justify-content: flex-end;">
                      <div class=mx-3>
                        <button name="add_btn" type="submit" class="btn btn-warning btn-between submit">I have made payment <em class="ti ti-arrow-right">
                          </em>
                        </button>
                      </div>
                    </div>
                    <div class="note note-plane note-danger">
                      <p>
                        <em class="fas fa-info-circle">
                        </em> Make sure you complete the payment within the next <strong>20 minutes</strong> as crytocurrencies are very volatile.
                      </p>
                    </div>
                    <div class="note note-plane note-danger">
                      <p>
                        <em class="fas fa-info-circle">
                        </em> Deposit will be added immediately after <strong>3</strong> network confirmations.
                      </p>
                    </div>
                    <div class="note note-plane note-danger">
                      <p>
                        <em class="fas fa-info-circle">
                        </em> In case you send a different amount, your deposit may be lost.
                      </p>
                    </div>
                    <div class="note note-plane note-danger">
                      <p>
                        <em class="fas fa-info-circle">
                        </em> When your deposit is processed you will receive an email notification.
                      </p>
                    </div>
                  </form>
                <?php  } else { ?>
                  <div>
                    <p> You Currently have no outstanding operation</p>
                  </div>
                <?php  } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- .container -->
  </div>
  <?php require_once("includes/client-footer.php"); ?>
  <script>
    $(document).ready(function() {
      if ($("#payment").length) {
        $("#payment").submitForm({
          process_url: `${site.process}custom`,
        }, null, function(response) {
          window.location = `${site.domain}transactions`
        });
      }
    })
  </script>
</body>

</html>