<?php
require_once("includes/client-authentication.php");
$coins = array_remap($coins, array_column($coins, "symbol"));
?>
<!DOCTYPE html>
<html lang="en" class="js">

<head>
  <title>Buy Tokens | <?= $company->name ?></title>
  <?php require_once("includes/client-links.php"); ?>
</head>

<body class="page-user">
  <canvas class="d-none"><?= json_encode($coins) ?></canvas>
  <?php require_once("includes/preloader.php"); ?>
  <div class="topbar-wrap mb-4">
    <?php require_once("includes/client-nav.php"); ?>
  </div>
  <!-- .topbar-wrap -->
  <div class="page-content">
    <div class="container">
      <div class="page-header page-header-kyc">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-xl-9 text-center">
            <h2 class="page-title">Buy BTC Asset</h2>
            <span>Buy Bitcoin Asset and store in your secure Bitcoin wallet for a long term saving purpose. You can withdraw your token at any time.</span>
          </div>
        </div>
      </div>
      <!-- .page-header -->
      <div class="page-content invest">
        <div class="row justify-content-center">
          <div class="col-lg-7 col-xl-6">
            <div class="content-area card buy-token">
              <div class="card-innr">
                <form method="post" name="add" id="buySum">

                  <div class="token-contribute mt-0">
                    <label class="input-item-label w-100">
                      <strong>Quantity to buy</strong> <small class="float-right">1 BTC = <?= $fmn->format(round($coins["BTC"]->price, 3)) ?> USD</small>
                    </label>
                    <div class="token-calc pb-1">
                      <div class="token-pay-amount w-100">
                        <input name="" id="add_Sum" class="input-bordered input-with-hint" style="border-color: #101a2d; border-width: 2px;" step="any" autocomplete="off" min="0.5" required type="number" value="0.5" placeholder="0.000000">
                        <div class="token-pay-currency"> <span class="input-hint input-hint-sap curr" id="ccurr">BTC</span> </div>
                      </div>


                    </div>
                    <div class="token-calc-note note note-plane note-min">
                      <em class="fas fa-info-circle"></em>
                      <span class="note-text text-light">Minimum purchasing amount is <strong>0.5 BTC</strong></span>
                    </div>

                  </div>

                  <div class="input-item input-with-label">
                    <label class="input-item-label w-100">
                      <strong>Pay through</strong>


                    </label>
                    <div class="select-wrapper">
                      <select class="input-bordered" name="PSys" id="add_PSys" required>
                        <option value="" selected>- select -</option>

                        <?php foreach ($coins as $key => $coin) {
                          if ($coin->symbol == "BTC") continue; ?>
                          <option value="<?= $coin->symbol ?>"><?= $coin->name ?> - <?= $coin->symbol ?> (<?= $coin->network ?>)</option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="token-received d-block">
                    <label class="input-item-label d-block">Amount to pay</label>
                    <div class="input-bordered" style="min-height: 44px; background: #FAFAFA;">
                      <div class="token-received-amount">
                        <h5 class="token-amount calc-amount">
                          <span id="sum2">0.000000</span>
                          <div class="token-pay-currency"> <span class="input-hint input-hint-sap curr" id="ccurr2"></span> </div>
                        </h5>
                      </div>
                    </div>
                  </div>

                  <input name="PSys2" value="BTC" type="hidden">
                  <input name="amount" id="TRC" type="hidden">

                  <div class="pay-buttons pt-1">
                    <div class="pay-button pt-4 pb-0">
                      <button name="add_btn" type="submit" class="btn btn-warning btn-between w-100 submit">BUY TOKENS <em class="ti ti-arrow-right">
                        </em>
                      </button>
                    </div>
                  </div>
                </form>
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
        let coins = $("canvas").text()
        $("canvas").remove();
        coins = isJson(coins)

        $("#add_PSys").change(function() {
          let coin = $(this).val();
          let qty = $("#add_Sum").val();

          if (qty && coin) {
            let equiva = (qty * coins['BTC'].price) / coins[coin].price;
            $("#sum2").html(`${num_format(parseFloat(equiva).toFixed(4))}`);
            $("#ccurr2").text(coin)
            $("#TRC").val(equiva.toFixed(4))
          }
        });

        $("#add_Sum").change(function() {
          $("#add_PSys").trigger("change");
        })

        $("#buySum").submitForm({
          case: `submitExchange`,
          other: "buycoin",
          process_url: `${site.process}custom`,
          validation: `strict`
        }, null, function(response) {
          window.location = `${site.domain}payment?hash=${response.tx_no}&_k=${response.primary_key}`
        })
      })
    </script>
</body>

</html>