<?php
require_once("includes/client-authentication.php");
require_once("{$generic->backend}controllers/ForExchange.php");

$transaction = [];
$countdown = $paramControl->load_sources("countDown");
$coins = array_remap($coins, array_column($coins, "symbol"));

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

  $timezone = new DateTimeZone("UTC");
  $moment = new DateTime();
  $started = new DateTime($transaction->date);

  // $moment->setTimeZone($timezone);

  $start = strtotime($started->format("Y-m-d H:i:s"));
  $end = strtotime("+{$countdown}", $start);
  $now = $moment->getTimestamp();

  // see([$started->format("h:i:s"), date("h:i:s", $end), $moment->format("h:i:s")]);
}
?>
<!DOCTYPE html>
<html lang="en" class="js">

<head>
  <title>Operation | <?= $company->name ?></title>
  <?php require_once("includes/client-links.php"); ?>
  <link rel="stylesheet" type="text/css" href="<?= $uri->site ?>css/demo.css<?= $cache_control ?>">
</head>

<body class="page-user" data-trigger=<?= isset($now) && ($now - $end) ?>>
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
                  <div class="pannel" id="wallet-pannel">
                    <h4 class="popup-title">Payment Details</h4>
                    <div>
                      <div class="row align-items-center">
                        <div class="col-6 col-sm-3 mb-3 mb-sm-0">
                          <img src="<?= $coins[$transaction->paid_into]->qr_code ?>" class="img-fluid">
                        </div>
                        <div class="col-12 col-sm-9">
                          <label><?= $transaction->paid_into ?> Deposit Address</label>
                          <div class="copy-wrap mgb-0-5x mb-3"> <span class="copy-feedback">
                            </span>
                            <input type="text" class="copy-address" value="<?= $coins[$transaction->paid_into]->wallet ?>" readonly style="padding-left: 15px;">
                            <span class="copy-trigger" data-clipboard data-clipboard-text="<?= $coins[$transaction->paid_into]->wallet ?>">
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
                          <time><em class="ti ti-timer mr-1"></em> <small><?= $started->format("l jS M Y, h:i:a") ?></small></time> <br>
                          <button name="add_btn" type="button" class="btn btn-warning btn-between submit swappable" data-to=timer-pannel>Proceed <em class="ti ti-arrow-right">
                            </em>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div data-id=<?= $transaction->id ?> class="pannel" id="timer-pannel" style="display: none;">
                    <h4 class="popup-title">Timer CountDown</h4>
                    <form id="payment">
                      <div class="row align-items-center">
                        <div class="countdown countdown-container container">
                          <div class="clock row" id="clock-row" data-start="<?= $start ?>" data-end="<?= $end ?>" data-now="<?= $now ?>">
                            <input type="hidden" name="InvID" value="<?= $transaction->id ?>">
                            <?php if ($transaction->tx_type == "exchange") { ?>
                              <input type="hidden" name="case" value="confirm-exchange">
                            <?php } else { ?>
                              <input type="hidden" name="case" value="notify-deposit">
                            <?php } ?>
                            <div class="clock-item clock-days countdown-time-value col-6 col-md-3">
                              <div class="wrap">
                                <div class="inner">
                                  <div id="canvas-days" class="clock-canvas"></div>

                                  <div class="text">
                                    <p class="val">0</p>
                                    <p class="type-days type-time">DAYS</p>
                                  </div><!-- /.text -->
                                </div><!-- /.inner -->
                              </div><!-- /.wrap -->
                            </div><!-- /.clock-item -->

                            <div class="clock-item clock-hours countdown-time-value col-6 col-md-3">
                              <div class="wrap">
                                <div class="inner">
                                  <div id="canvas-hours" class="clock-canvas"></div>

                                  <div class="text">
                                    <p class="val">0</p>
                                    <p class="type-hours type-time">HOURS</p>
                                  </div><!-- /.text -->
                                </div><!-- /.inner -->
                              </div><!-- /.wrap -->
                            </div><!-- /.clock-item -->
                            <div class="clock-item clock-minutes countdown-time-value col-6 col-md-3">
                              <div class="wrap">
                                <div class="inner">
                                  <div id="canvas-minutes" class="clock-canvas"></div>

                                  <div class="text">
                                    <p class="val">0</p>
                                    <p class="type-minutes type-time">MIN</p>
                                  </div><!-- /.text -->
                                </div><!-- /.inner -->
                              </div><!-- /.wrap -->
                            </div><!-- /.clock-item -->

                            <div class="clock-item clock-seconds countdown-time-value col-6 col-md-3">
                              <div class="wrap">
                                <div class="inner">
                                  <div id="canvas-seconds" class="clock-canvas"></div>

                                  <div class="text">
                                    <p class="val">0</p>
                                    <p class="type-seconds type-time">SEC</p>
                                  </div><!-- /.text -->
                                </div><!-- /.inner -->
                              </div><!-- /.wrap -->
                            </div><!-- /.clock-item -->
                          </div><!-- /.clock -->
                        </div>
                      </div>
                      <details open class="mt-4">
                        <div class="note note-plane note-danger">
                          <p>
                            <em class="fas fa-info-circle">
                            </em> Make sure you complete the payment <strong>before the timer finishes</strong> as crytocurrencies are very volatile.
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
                            </em> In case you send a different amount, your deposit would be updated accordingly.
                          </p>
                        </div>
                        <div class="note note-plane note-danger">
                          <p>
                            <em class="fas fa-info-circle">
                            </em>After making payment, wait on this page until the green button appears (after 1 min), click on it to complete the payment.
                          </p>
                        </div>
                        <div class="note note-plane note-danger">
                          <p>
                            <em class="fas fa-info-circle">
                            </em> When your deposit is processed you will receive an email notification.
                          </p>
                        </div>
                      </details>
                      <div class="row my-3" style="justify-content: space-around;">
                        <div class=mx-3>
                          <button name="add_btn" type="button" class="btn btn-warning btn-between swappable" data-to="wallet-pannel">Back <em class="ti ti-arrow-left">
                            </em>
                          </button>
                        </div>
                        <div class=mx-3>
                          <button id="cancel" type="button" onclick="closeInvoice()" class="btn btn-danger btn-between">Cancel <em class="ti ti-arrow-clear">
                            </em>
                          </button>
                        </div>
                        <div class=mx-3>
                          <button name="add_btn" id="submit" type="submit" class="btn btn-success btn-between submit d-none">I have made payment <em class="ti ti-arrow-right">
                            </em>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
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
  <script type="text/javascript" src="<?= $uri->site ?>js/jquery.final-countdown.min.js"></script>

  <script>
    $(document).ready(function() {
      if ($("#payment").length) {
        $("#payment").submitForm({
          process_url: `${site.process}custom`,
        }, null, function(response) {
          window.location = `${site.domain}transactions`
        });


        $(".swappable").click(function() {
          let button = $(this);
          let contain = $(this).closest(".pannel");
          let shownext = button.data("to")
          contain.swapDiv($(`#${shownext}`), (response) => {
            if ($(response).attr("id") == "timer-pannel") {
              if (!$("#clock-row").attr("started")) {
                let data = $("#clock-row").attr({
                  "started": "started"
                }).data();

                $('.countdown').final_countdown({
                  'start': data.start,
                  'end': data.end,
                  'now': data.now
                }, (response) => {
                  closeInvoice();
                });
                // Togggle hide buttons
                $(".clock-days, .clock-hours").hide();
                let downnow = (data.end - data.now); //Remaining seconds
                setInterval(() => {
                  downnow = downnow - 1;
                  if (((data.end - data.start) / 60) - 1 > (downnow / 60)) {
                    $("#submit").removeClass("d-none");
                  }
                }, 1000);
              }
            }
          });
        })

      }

    })

    function closeInvoice() {
      $("#cancel").attr({
        disabled: true
      }).startLoader()
      let id = $("#timer-pannel").data("id");
      $.post(`${site.process}custom`, {
        case: "closeInvoice",
        id: id
      }, (response) => {
        if (isJson(response)) {
          toast("Invoice Cancelled", "red");
          window.location = `${site.domain}operations`;
        }
      });
    }
  </script>
</body>

</html>