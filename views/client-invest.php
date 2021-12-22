<?php
require_once("includes/client-authentication.php");
$plans = $generic->getFromTable("content", "type=investment");

?>
<!DOCTYPE html>
<html lang="en" class="js">

<head>
  <title>Invest | <?= $company->name ?></title>
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
              <h2 class="page-title">Make Investment</h2>
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
                <div class="form-step form-step2" id="plans">
                  <div class="form-step-head card-innr border-bottom-0 pb-0">
                    <div class="step-head">
                      <div class="step-head-text">
                        <h4 class="font-weight-bold">
                          <span class="badge badge-dark">1</span> Choose Investment Plan
                        </h4>
                        <p> <small>Choose a plan that best fits your budget </small> </p>
                      </div>
                    </div>
                  </div>
                  <!-- .step-head -->
                  <div class="form-step-fields card-innr">
                    <div class="plan-choose row">
                      <?php foreach ($plans as $key => $plan) { ?>

                        <div class="plan-option mb-2 col-sm-6 col-md-4" style="position:relative;">
                          <input class="plan-option-check" type="radio" name="plan_id" id="add_Plan<?= $plan->id ?>" value="<?= $plan->id ?>" required>
                          <label class="d-block plan-option-label" for="add_Plan<?= $plan->id ?>">

                            <div class="row align-items-center">
                              <div class="col-12 plan-title">
                                <h4 class="font-weight-bold mb-2"><?= $plan->title ?></h4>
                                <span class="badge badge-auto badge-light p-0 px-1" title="Paying on Monday">M</span>
                                <span class="badge badge-auto badge-light ml-1 p-0 px-1" class="Paying on Tuesday">T</span>
                                <span class="badge badge-auto badge-light ml-1 p-0 px-1" title="Paying on Wednesday">W</span>
                                <span class="badge badge-auto badge-light ml-1 p-0 px-1" title="Paying on Thursday">T</span>
                                <span class="badge badge-auto badge-light ml-1 p-0 px-1" title="Paying on Friday">F</span>
                                <span class="badge badge-auto badge-light ml-1 p-0 px-1" title="Paying on Saturday">S</span>
                                <span class="badge badge-auto badge-light ml-1 p-0 px-1" title="Paying on Sunday">S</span>
                              </div>
                              <div class="col-12 pt-2">
                                <span>Limits:</span>
                                <strong class="font-weight-bold mr-1">
                                  <span class="pamount11"><?= $currency . $fmn->format($plan->business) ?></span> - <span class="pamount12"><?= $currency . $fmn->format($plan->label) ?></span>
                                </strong>

                              </div>
                              <div class="col-12 pt-2">
                                <span>Total Return:</span> <strong class="font-weight-bold"><?= $val = calculate_roi($plan) ?>%</strong>
                                <br>
                                <!-- <small>Principal included</small> -->
                                <small>In <?= $plan->product ?></small>
                              </div>
                              <div class="col-12 pt-3">
                                <span class="btn btn-sm btn-auto btn-block btn-secondary clickable" data-val="<?= $val ?>" data-duration="<?= $plan->product ?>">
                                  <span class="off">Select</span>
                                  <span class="on">✓</span>
                                </span>
                              </div>
                            </div>
                          </label>
                        </div>
                      <?php } ?>
                    </div>
                  </div>

                </div>
                <div class="form-step form-step3">
                  <div class="form-step-head card-innr border-bottom-0 pb-0">

                    <div class="step-head">
                      <div class="step-head-text">
                        <h4 class="font-weight-bold">
                          <span class="badge badge-dark">2</span>
                          Enter Amount
                        </h4>
                        <p> <small>Enter an amount within the price range of the plan you selected </small> </p>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- .step-head -->
                <div class="form-step-fields card-innr">
                  <div class="token-contribute mb-0 mt-0 py-2">
                    <div class="card-token card-innr py-2 px-xl-3 mb-3">
                      <div class="token-balance token-balance-with-icon">
                        <div class="token-balance-text">
                          <h6 class="card-sub-title">Available Balance</h6>
                          <span class="lead" style="font-size: 1.2em;">
                            <?= $currency . $fmn->format(round($user->balance, 2)) ?>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="token-calc">
                      <div class="token-pay-amount w-60">
                        <input name="amount" id="add_Sum" class="input-bordered input-with-hint" autocomplete="off" required type="number" step="any" max="<?= $user->balance ?>" value="<?= $user->balance ?>" placeholder="0.000000">
                        <div class="token-pay-currency">
                          <span class="input-hint input-hint-sap curr">
                            <?= $currency ?>
                          </span>
                        </div>
                      </div>
                      <div class="token-received">
                        <div class="token-eq-sign">=</div>
                        <div class="token-received-amount">
                          <h5 class="token-amount calc-amount">~0.00</h5>
                          <div class="token-symbol">Total Profit <span id="duration"></span> (USD)</div>
                        </div>
                      </div>
                    </div>
                    <div class="token-calc-note note note-plane note-min mt-2" style="display: none;"> <em class="fas fa-times-circle text-danger">
                      </em> <span class="note-text text-light">
                      </span> </div>
                  </div>
                </div>
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
                  <button name="add_btn" type="submit" class="btn btn-warning btn-between submit">Invest <em class="ti ti-arrow-right">
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
      $(".clickable").click(function() {
        $(".plan-option").each(function() {
          $(this).removeClass("active").find(".plan-option-check").prop("checked", false);
          $(this).find(".clickable > .on").hide();
          $(this).find(".clickable > .off").show();
        });
        let box = $(this).closest(".plan-option");
        box.addClass("active");
        box.find(".plan-option-check").prop("checked", true);
        box.find(".clickable > .on").show();
        box.find(".clickable > .off").hide();
        calc_price();
      });
      $("#add_Sum").change(function() {
        calc_price();
      });
      $("#invest").submitForm({
        process_url: `${site.process}custom`,
        case: "invest"
      }, null, function(response) {
        window.location = `${site.domain}withdraw`
      });

      $(".select-coin").click(function() {
        $(this).siblings("label.pay-option-label").click();
      })
    });

    function calc_price() {
      let box = $(".plan-option.active");
      if (box.length) {
        let roi = box.find(".clickable").attr("data-val");
        let dur = box.find(".clickable").attr("data-duration");
        let amount = $("#add_Sum").val();
        if (amount = parseInt(amount)) {
          amount += ((amount * roi) / 100);
          $(".token-amount.calc-amount").text(amount.toFixed(2));
          $("#duration").text(` in ${dur}`);
        } else {
          $(".token-amount.calc-amount").text("0.00");
          $("#duration").text("")
        }
      } else toast("Select a plan", "red");
    }
  </script>
</body>

</html>