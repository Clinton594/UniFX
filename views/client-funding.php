<?php
require_once("includes/client-authentication.php");
$plans = $generic->getFromTable("content", "type=investment");

?>
<!DOCTYPE html>
<html lang="en" class="js">

<head>
  <title>Fund Account | <?= $company->name ?></title>
  <?php require_once("includes/client-links.php"); ?>
</head>

<body class="page-user">
  <?php require_once("includes/preloader.php"); ?>
  <div class="topbar-wrap mb-4">
    <?php require_once("includes/client-nav.php"); ?>
  </div>
  <div class="page-content">
    <div class="container">
      <div class="page-header page-header-kyc">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9 text-center">
              <h2 class="page-title">Fund Account</h2>
            </div>
          </div>
        </div>
        <!-- .container -->
      </div>
      <div class="page-content invest">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-xl-9">
            <form method="post" name="add" id="invest">
              <input name="Oper" id="add_Oper" value="CASHIN" type="hidden">
              <div class="kyc-form-steps card">
                <div class="form-step form-step3">
                  <div class="form-step-head card-innr border-bottom-0 pb-0">
                    <div class="step-head">
                      <div class="step-head-text">
                        <h4 class="font-weight-bold">
                          <span class="badge badge-dark">1</span>
                          Enter Amount
                        </h4>
                        <p> <small>Enter an amount You want to fund in your walet </small> </p>
                      </div>
                    </div>
                  </div>
                  <!-- .step-head -->
                  <div class="form-step-fields card-innr">
                    <div class="token-contribute mb-0 mt-0 py-2">
                      <div class="token-calc">
                        <div class="token-pay-amount w-60">
                          <input name="amount" id="add_Sum" class="input-bordered input-with-hint" autocomplete="off" required type="text" value="" placeholder="0.000000">
                          <div class="token-pay-currency">
                            <span class="input-hint input-hint-sap curr">
                              <?= $currency ?>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="token-calc-note note note-plane note-min mt-2" style="display: none;"> <em class="fas fa-times-circle text-danger">
                        </em> <span class="note-text text-light">
                        </span> </div>
                    </div>
                  </div>
                </div>
                <div class="form-step form-step1">
                  <div class="form-step-head card-innr border-bottom-0 pb-0">
                    <div class="step-head">
                      <div class="step-head-text">
                        <h4 class="font-weight-bold">
                          <span class="badge badge-dark">2</span> Choose Payment Method
                        </h4>
                        <p> <span>Select a crypto asset you want to pay with</span> </p>
                      </div>
                    </div>
                  </div>
                  <!-- .step-head -->
                  <div class="form-step-fields card-innr">
                    <div class="token-currency-choose payment-system mt-0">
                      <div class="row guttar-15px">
                        <?php foreach ($coins as $key => $coin) { ?>
                          <div class="col-6 col-sm-3">
                            <div class="pay-option">
                              <small class="select-coin"> <span>Select <?= $coin->name ?></span> </small>
                              <input class="pay-option-check" type="radio" id="curr_<?= $coin->symbol ?>" name="PSys" value="<?= $coin->id ?>" required>
                              <label class="pay-option-label" for="curr_<?= $coin->symbol ?>" data-curr="<?= $coin->symbol ?>">
                                <img src="<?= $coin->logo ?>" alt="<?= $coin->name ?>" style="border-radius:50%;">
                              </label>
                            </div>
                          </div>
                        <?php } ?>
                      </div>
                      <!-- .row -->
                    </div>
                  </div>
                  <!-- .step-fields -->
                </div>

                <div class="form-step form-step-final">
                  <div class="form-step-fields card-innr">
                    <div class="input-item">
                      <input class="input-checkbox input-checkbox-md" id="term-condition" type="checkbox" required checked>
                      <label for="term-condition">I have read the <a target="_blank" href="terms">Terms of Condition</a> and <a target="_blank" href="privacy-policy">Privacy Policy.</a>
                      </label>
                    </div>
                    <div class="gaps-1x">
                    </div>
                    <button name="add_btn" type="submit" class="btn btn-warning btn-between submit">Proceed <em class="ti ti-arrow-right">
                      </em>
                    </button>
                    <div class="mt-3">
                      <p>
                        <em class="fas fa-info-circle">
                        </em> Investment will be added automatically after payment confirmation.
                      </p>
                    </div>
                  </div>
                  <!-- .step-fields -->
                </div>
                <input name="__Cert" value="1740adcf" type="hidden">
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- .container -->
  </div>
  <?php require_once("includes/client-footer.php"); ?>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#invest").submitForm({
        process_url: `${site.process}custom`,
        case: "fund-account"
      }, null, function(response) {
        window.location = `${site.domain}payment?hash=${response.data.hash_key}&_k=${response.data.key}`
      });

      $(".select-coin").click(function() {
        $(this).siblings("label.pay-option-label").click();
      })
    });
  </script>
</body>

</html>