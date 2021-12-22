<?php
require_once("includes/client-authentication.php");
$wallet = json_decode($user->wallet);
?>
<!DOCTYPE html>
<html lang="en" class="js">

<head>
  <title>Exchange | <?= $company->name ?></title>
  <?php require_once("includes/client-links.php"); ?>
</head>

<body class="page-user">
  <canvas class="d-none"><?= json_encode(array_remap($coins, array_column($coins, "symbol"))) ?></canvas>
  <?php require_once("includes/preloader.php"); ?>
  <div class="topbar-wrap mb-4">
    <?php require_once("includes/client-nav.php"); ?>
  </div>
  <!-- .topbar-wrap -->
  <div class="page-header page-header-kyc">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9 text-center">
          <h2 class="page-title">Exchange</h2>
          <p>We give the best exchange rate on all assets with zero fees</p>
        </div>
      </div>
    </div>
    <!-- .container -->
  </div>
  <div class="page-content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
          <div class="content-area card exchange">
            <div class="card-innr">
              <form method="post" name="add" id="exchange_form">
                <input name="Oper" id="add_Oper" value="EX" type="hidden">
                <div class="card-head">
                  <h4 class="card-title text-center">Select Payment Systems</h4>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="input-item input-with-label">
                      <label class="input-item-label">FROM</label>
                      <div class="select-wrapper">
                        <select class="input-bordered" name="PSys" id="add_PSys">
                          <option value="0" selected disabled>- select -</option>
                          <?php foreach ($coins as $key => $coin) { ?>
                            <option value="<?= $coin->symbol ?>"> <?= $coin->name ?> - <?= $coin->symbol ?> (<?= $coin->network ?>)</option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="input-item input-with-label">
                      <label class="input-item-label">TO</label>
                      <div class="select-wrapper">
                        <select class="input-bordered" name="PSys2" id="add_PSys2">
                          <option value="0" selected disabled>- select -</option>
                          <?php foreach ($coins as $key => $coin) {
                            if (isset($wallet->{$coin->symbol})) { ?>
                              <option data-wallet=<?= $wallet->{$coin->symbol} ?> value="<?= $coin->symbol ?>"> <?= $coin->name ?> - <?= $coin->symbol ?> (<?= $coin->network ?>)</option>
                          <?php }
                          } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-head">
                  <h4 class="card-title" id="from-coin">Enter amount</h4>
                </div>
                <div class="token-contribute mt-0">
                  <div class="token-calc">
                    <div class="token-pay-amount w-50">
                      <input name="amount" id="add_Sum" class="input-bordered input-with-hint" autocomplete="off" required type="text" value="" placeholder="0.000000">
                      <div class="token-pay-currency">
                        <span class="input-hint input-hint-sap curr" id="from-ccurr"></span>
                      </div>
                    </div>
                    <div class="token-received">
                      <div class="token-eq-sign">
                        <em class="ti ti-arrow-right">
                        </em>
                      </div>
                      <div class="token-received-amount">
                        <h5 class="token-amount calc-amount">
                          <span id="sum2">0.000000 <small>BTC</small>
                          </span>
                        </h5>
                      </div>
                    </div>
                  </div>
                  <div class="amount-suggest" style="display: none;"> <a href="#" class="btn btn-xs btn-lighter-alt btn-auto mb-2 mr-1 amnt-min pt-0 pb-0">Min. <span>
                      </span>
                    </a> <a href="#" class="btn btn-xs btn-lighter-alt btn-auto mb-2 mr-1 amnt-all pt-0 pb-0">All balance <span>
                      </span>
                    </a> </div>
                  <div class="token-calc-note note note-plane note-min">
                    <span class="note-text text-light"><i id="cf" class="cf"></i><span id="csum"></span> <span id="ccurr"></span></span>
                  </div>
                </div>
                <div class="pay-buttons pt-0">
                  <div class="pay-button pt-0 pb-0">
                    <button name="add_btn" type="submit" class="btn btn-warning btn-between w-100 submit">Continue <em class="ti ti-arrow-right">
                      </em>
                    </button>
                  </div>
                  <span>
                    <small id="wallet-address-preview"></small> <br>
                    <small id="wallet-address"></small>
                  </span>
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
      $("canvas").remove()
      $("#add_PSys")[0].coins = isJson(coins);
      setTimeout(() => {
        delete $("#add_PSys")[0].coins
      }, 1000 * 60 * 10);

      // Select to coin
      $("#add_PSys2").change(function() {
        if ($(this).val()) {
          let val = $(this).val();
          let address = $(this).find(`option[value=${val}]`).data("wallet");
          $("#wallet-address").text(`${address}`)
          $("#wallet-address-preview").text(`${val} Wallet Address`);
          $("#sum2").html(`0.0000 <small>${val}</small>`);
          $("#add_Sum").trigger("change")
        } else {
          $("#sum2").html(`<small>coin pair is unavailable</small>`);
          $("#wallet-address, #wallet-address-preview").text("");
        }
      })

      // Select from coin
      $("#add_PSys").change(function() {
        let coin = $(this).val();
        $("#add_PSys2").find("option").attr({
          disabled: false
        });
        $("#add_PSys2").find(`option[value=0], option[value=${coin}]`).attr({
          disabled: true
        }).trigger("change");

        fetchCoins(function(coins) {
          $("#from-ccurr").text(`${coin}`);
          $("#add_Sum").attr({
            placeholder: `0.0000 (${coin})`
          }).val("");
          $("#cf").removeAttr("class").addClass(`cf cf-${coin.toLowerCase()}`);
          $("#csum").text(`1 ${coin} amounts to`);
          $("#ccurr").text(`$${num_format(parseFloat(coins[coin].price).toFixed(4))}`);
        });
      });

      // Enter amount to exchange
      $("#add_Sum").change(function() {
        let from = $("#add_PSys").val();
        let to = $("#add_PSys2").val();
        let qty = $(this).val();
        fetchCoins(function(coins) {
          let equiva = (qty * coins[from].price) / coins[to].price;
          $("#sum2").html(`${num_format(parseFloat(equiva).toFixed(4))} <small>${to}</small>`)
        });
      });

      // Submit Exchange

      $("#exchange_form").submitForm({
        case: `submitExchange`,
        process_url: `${site.process}custom`,
        validation: `strict`
      }, null, function(response) {
        window.location = `${site.domain}payment?hash=${response.tx_no}&_k=${response.primary_key}`
      })
    })

    function fetchCoins(callback = null) {
      let coins = $("#add_PSys").prop("coins");
      if (coins) {
        callback(coins)
      } else {
        $("#exchange_form . submit").startLoader(true);
        $.post(`${site.domain}custom`, {
          case: `getCoins`
        }, function(response) {
          ("#exchange_form . submit").stopLoader(true);
          let res = isJson(response);
          if (res.status) {
            $("#add_PSys")[0].coins = isJson(res.data);
            setTimeout(() => {
              delete $("#add_PSys")[0].coins
            }, 1000 * 60 * 10);
            callback(res.data);
          }
        });
      }

    }
  </script>
</body>


</html>