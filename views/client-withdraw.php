<?php
require_once("includes/client-authentication.php");
$investments = $generic->getFromTable("accounts", "user_id={$session->user_id}");
// Get Plan Details of selected investments
$plan_status = implode(",", array_unique(array_column($investments, "plan")));
$plan_status = $generic->getFromTable("content", "id IN ($plan_status)");
$plan_status = array_remap($plan_status, array_column($plan_status, "id"));
//extract the reinvestment status of each investment from their plan
$plan_status = array_map(function ($plan = null) {
  $plan = $plan->parent;
  return $plan;
}, $plan_status);
// Profits taken per investment
$profits = $generic->getFromTable("transaction", "user_id={$session->user_id}, status=1", 1, 0, ID_DESC);
$profits = array_group($profits, "account_id");

$investments = array_map(function ($plan = null) use ($plan_status, $profits) {
  $plan->reinvest = $plan_status[$plan->plan];
  $plan->profit   = 0;
  if (isset($profits[$plan->id])) {
    $plan->profit = array_sum(array_column(array_filter($profits[$plan->id], function ($_plan) {
      return $_plan->tx_type == "topup";
    }), "amount"));
  }
  return $plan;
}, $investments);

$status_value = $paramControl->load_sources("status");
?>
<!DOCTYPE html>
<html lang="en" class="js">

<head>
  <title>Withdraw | <?= $company->name ?></title>
  <?php require_once("includes/client-links.php") ?>
</head>

<body class="page-user">
  <?php require_once("includes/preloader.php"); ?>
  <div class="topbar-wrap mb-4">
    <?php require_once("includes/client-nav.php"); ?>
  </div>
  <!-- .topbar-wrap -->
  <div class="page-header page-header-kyc">
    <div class="container">
      <div class="card-innr card-nner">
        <div class="row">
          <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="card card-token mb-2 mb-md-0">
              <div class="card-innr py-2 px-xl-3 pb-4">
                <div class="token-balance token-balance-with-icon">
                  <div class="token-balance-text">
                    <h6 class="card-sub-title">Available Balance</h6>
                    <span class="lead" style="font-size: 1.2em;"> <span><?= $currency ?></span> <?= $fmn->format(round($user->balance, 2)) ?></span>
                  </div>
                </div>
                <?php if ($user->balance > 0) {
                  if (isjson($user->wallet)) { ?>
                    <button class="btn btn-warning btn-auto btn-block" id="open-withdrawal">Withdraw</button>
                    <div class=d-none>
                      <small>Wallet Address</small>
                      <div class="copy-address w-100" id="wallet-address-preview"></div>
                    </div>
                  <?php
                  } else { ?>
                    <div>
                      <p>You have not added withdrawal wallet addreses yet.</p>
                      <a href="<?= $uri->site ?>wallets" class="btn btn-warning btn-auto btn-block">Create Wallet</a>
                    </div>
                  <?php }
                } else { ?>
                  <small>You'll be able to make withdrawals once you receive your earning.</small>
                <?php } ?>
              </div>
            </div>
          </div>
          <?php if ($user->balance > 0) { ?>
            <div class="col-lg-8 d-none">
              <form action="" method=" post" id="withdraw-form">
                <div class="row mb-4">
                  <div class="col-md-6 mb-3 mb-md-0">
                    <label for="amount">Enter amount (<?= $currency ?>)</label>
                    <div class="copy-wrap">
                      <span class="copy-feedback"></span>
                      <input type="number" max=<?= $user->balance ?> class="copy-address trigger-fetch" placeholder="<?= $currency . $fmn->format($user->balance) ?>" name="amount" required>
                      <span class="copy-trigger" data-amount=<?= $user->balance ?>>
                        <em class="fas fa-donate"></em>
                      </span>
                    </div>
                    <div class="copy-wrap mt-4">
                      <label for="amount">Choose Wallet Address</label>
                      <select name="coin" id="" class="copy-address trigger-fetch">
                        <?php foreach (isjson($user->wallet) ?? [] as $key => $wallet) { ?>
                          <option data-address="<?= $wallet ?>" value="<?= $key ?>"><?= $key ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3 mb-md-0">
                    <label for="pin">Click on send code</label>
                    <div class="copy-wrap">
                      <input type="number" data-code=withdrawal class="copy-address send-code" placeholder="Enter Pin" name="pin" required>
                    </div>
                    <div class="copy-wrap mt-4">
                      <label for="submit" id="amount-preview"></label>
                      <button type="submit" class="submit btn btn-warning w-100">Submit Request</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <!-- .container -->
  </div>
  <div class="page-content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-12">
          <div class="content-area card withdraw">
            <div class="card-innr">
              <?php if (count($investments)) { ?>
                <p>My Investments</p>
                <div class=table-responsive>
                  <table class=table style="text-align: center;">
                    <thead>
                      <th>S/N</th>
                      <th>PLAN</th>
                      <th>CAPITAL</th>
                      <th>PROFITS</th>
                      <th>INVESTMENT DATE</th>
                      <th>COMPLETION DATE</th>
                      <th>STATUS</th>
                      <td></td>
                    </thead>
                    <tbody>
                      <?php foreach ($investments as $key => $plan) { ?>
                        <tr>
                          <td><?= $key + 1 ?></td>
                          <td><?= $plan->name ?></td>
                          <td><?= $currency . $fmn->format(round($plan->amount + $plan->reinvested, 2)) ?></td>
                          <td><?= $currency . $fmn->format(round($plan->profit, 2)) ?></td>
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
                            <span class="<?= ["bg-default", "bg-success", "bg-warning", "bg-default"][$plan->status] ?> py-1 px-2 text-white rounded"><?= $status_value[$plan->status] ?></span>
                          </td>
                          <td>
                            <div class=px-2>
                              <?php if ($plan->status == 2) { ?>
                                <?php if (!empty($plan->reinvest)) { //Completed 
                                ?>
                                  <button class="btn btn-success btn-small mr-2 plan-reinvest" data-plan=<?= $plan->id ?> data-case=reinvest capital=<?= $plan->amount ?>>Reinvest</button>
                                <?php } ?>
                              <?php } else if ($plan->status != 3) { //Not Cancelled
                              ?>
                                <button data-case=cancel-investment data-plan=<?= $plan->id ?> class="btn btn-danger btn-small mr-2 plan-cancel">&times; Cancel</button>
                              <?php } ?>
                            </div>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              <?php } else { ?>
                <div class="alert alert-danger mb-0">You do not have the funds to withdraw.</div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- .container -->
  </div>
  <?php require_once("includes/client-footer.php") ?>
  <script src="<?= $uri->backend ?>js/swal.js?d"></script>
  <script>
    $(document).ready(function() {
      $(".plan-reinvest").click(function() {
        let button = $(this);
        let captial = button.attr("capital")
        Swal.fire({
          title: `Re-Invest this investment ?`,
          text: `Make sure you have up to $${captial} in your dashboard to proceed.`
        }).then(function(value) {
          if (value.isConfirmed) {
            button.startLoader();
            let data = button.data();
            $.post(`${site.process}custom`, data, function(response) {
              button.stopLoader();
              let res = isJson(response)
              if (res.status) {
                window.location.reload();
                toast(res.message);
              } else toast(res.message, "red");
            });
          }
        })
      });

      $(".plan-cancel").click(function() {
        let button = $(this);
        let captial = button.attr("capital")
        Swal.fire({
          icon: `error`,
          title: `Cancel this investment ?`,
          text: `Are you sure you want to stop recieving profits on this investment ?`,
          confirmButtonText: `Proceed`
        }).then(function(value) {
          if (value.isConfirmed) {
            button.startLoader();
            let data = button.data();
            $.post(`${site.process}custom`, data, function(response) {
              button.stopLoader();
              let res = isJson(response)
              if (res.status) {
                window.location.reload();
                toast(res.message);
              } else toast(res.message, "red");
            });
          }
        })
      })

      $("#open-withdrawal").click(function() {
        let button = $(this);
        button.closest(".card-nner").addClass("card").find(".col-lg-8.d-none").removeClass("d-none");
        button.hide().next().removeClass("d-none");
        $("select.trigger-fetch").trigger("change");
      });

      $(".copy-trigger").click(function() {
        let data = $(this).data();
        $(this).prev().val(data.amount).trigger("change");
      });

      $(".trigger-fetch").change(function() {
        let values = $(".trigger-fetch").values();
        values.case = `convertCurrency`;

        let node = $(this).prop('tagName').toLowerCase();
        if (node == "select") {
          let address = $(this).find(`option[value=${values.coin}]`).data("address")
          $("#wallet-address-preview").text(address);
        }
        $("#withdraw-form .submit").startLoader(true);
        $.post(`${site.process}custom`, values, function(response) {
          $("#withdraw-form .submit").stopLoader(true);
          let res = isJson(response);
          if (res) {
            $("#amount-preview").text(`Approx. ${res.data} ${values.coin}`);
            $("#withdraw-form .submit").attr({
              disabled: false
            })
          } else {
            $("#amount-preview").text("");
            $("#withdraw-form .submit").attr({
              disabled: true
            })
          }
        });
      });

      if ($("#withdraw-form").length) {
        $("#withdraw-form").submitForm({
          process_url: `${site.process}custom`,
          case: `withdrawal`
        }, null, function(response) {
          Swal.fire({
            title: `Successful`,
            text: `Your funds are on the way to your wallet`,
            icon: `success`
          }).then(function(vale) {
            window.location = `${site.domain}transactions`
          })
        })
      }
    });
  </script>
</body>

</html>