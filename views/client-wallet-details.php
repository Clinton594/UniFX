<?php
require_once("includes/client-authentication.php");
$user  = $generic->getFromTable("users", "id={$session->user_id}");
$user  = reset($user);
$user->wallet = json_decode($user->wallet);
$coins = array_values(
  array_filter($coins, function ($coin = null) {
    return $coin->withdrawal;
  })
);
$coins = array_remap($coins, array_column($coins, "symbol"));
// see($user)
?>
<!DOCTYPE html>
<html lang="en" class="js">

<head>
  <title>Wallet details | <?= $company->name ?></title>
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
      <div class="page-header page-header-kyc">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7 text-center">
              <h2 class="page-title">Wallet details</h2>
            </div>
          </div>
        </div>
        <!-- .container -->
      </div>
      <!-- .page-header -->
      <div class="page-content">
        <div class="container">
          <form method="post" action="client/wallets" autocomplete="off" id="wallets-form" name="balance/wallets_frm">
            <div class="row justify-content-center wallets">
              <div class="col-lg-10 col-xl-9">
                <div class="card wallet-list mx-lg-4 pb-3 pt-0">
                  <?php foreach ($coins as $key => $value) {
                    $address = $tag = ""; ?>
                    <?php if (!empty($user->wallet->{$value->symbol})) {
                      list($address, $tag) = explode(",", "{$user->wallet->{$value->symbol}},");
                    } ?>
                    <div class="card-innr wallet-row form-step-final py-4">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="input-item input-with-label pb-0">
                            <label class="input-item-label font-weight-bold"><?= $value->name ?> (<?= $value->network ?>)</label>
                            <div class=d-flex>
                              <input placeholder="Paste your <?= $value->symbol ?> wallet address here" name="<?= $value->symbol ?>" <?php if (!empty($address)) { ?> value="<?= $address ?>" <?php } ?> autocomplete="off" type="text" class="input-bordered">
                              <?php if ($value->symbol == "XRP") { ?>
                                <input type="number" name="XRP" id="" <?php if (!empty($tag)) { ?> value="<?= $tag ?>" <?php } ?> class="input-bordered ml-2" placeholder="Paste your XRP tag here">
                              <?php } ?>
                            </div>
                          </div>
                          <!-- .input-item -->
                          <?php if ($value->symbol == "TRC") { ?>
                            <!-- .input-item -->
                            <div class="invalid-feedback d-block text-info">
                              <a href="#" data-toggle="modal" data-target="#bep20Modal">How to get BEP20 wallet?</a>
                            </div>
                          <?php } ?>
                        </div>
                        <!-- .col -->
                      </div>
                    </div>
                  <?php } ?>
                  <div class="form-step form-step-final">
                    <div class="form-step-fields card-innr">
                      <div class="input-item input-with-label">
                        <label for="balance/wallets_frm_PIN" class="input-item-label">Token code from email <small>(to confirm changes)</small>
                        </label>
                        <div class="row">
                          <div class="col-md-6">
                            <input class="input-bordered send-code" name="pin" id="balance/wallets_frm_PIN" required value="" autocomplete="off" size="8" type="number" data-code="wallet">
                            <!-- .input-item -->
                          </div>
                        </div>
                      </div>
                      <div class="gaps-1x">
                      </div>
                      <button type="submit" name="balance/wallets_frm_btn" class="btn btn-warning submit">Save changes</button>
                    </div>
                    <!-- .step-fields -->
                  </div>
                </div>
                <!-- .card -->
              </div>
            </div>
        </div>
        <!-- .container -->
      </div>
      <!-- .page-content -->
      <!-- Modal -->
      <div class="modal fade" id="bep20Modal" tabindex="-1" aria-labelledby="bep20ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content py-0">
            <div class="modal-header">
              <h5 class="modal-title" id="bep20ModalLabel">How to get BEP20 wallet?</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row text-center">
                <div class="col-sm-6 mb-4 mb-sm-0">
                  <p>
                    <a href="https://coinguides.org/custom-tokens-metamask/" target="_blank">
                      <strong>TERRA token on MetaMask</strong>
                    </a>
                  </p>
                  <p>
                    <a href="https://coinguides.org/custom-tokens-metamask/" target="_blank">
                      <img src="https://en.bitcoinwiki.org/upload/en/images/thumb/e/eb/Metamask.png/400px-Metamask.png" class="img-fluid" alt="">
                    </a>
                  </p>
                </div>
                <div class="col-sm-6">
                  <p>
                    <a href="https://community.trustwallet.com/t/how-to-get-bep20-address/70844" target="_blank">
                      <strong>TERRA token on TrustWallet</strong>
                    </a>
                  </p>
                  <p>
                    <a href="https://community.trustwallet.com/t/how-to-get-bep20-address/70844" target="_blank">
                      <img src="https://trustwallet.com/assets/images/media/preview/horizontal_blue.png" class="img-fluid" alt="">
                    </a>
                  </p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <script src="https://terrylinooo.github.io/jquery.disableAutoFill/assets/js/jquery.disableAutoFill.min.js">
      </script>
    </div>
    <!-- .container -->
  </div>
  <?php require_once("includes/client-footer.php"); ?>
  <script>
    $(function() {});
    $(document).ready(function() {
      $('#wallets-form').submitForm({
          case: "submit-wallet",
          process_url: `${site.process}custom`,
          validation: "normal"
        },
        function(formdata) {
          return filterObj(formdata);
        },
        function(response) {
          window.location.reload();
        });
      // $('#wallets-form').disableAutoFill();
    })

    function filterObj(param) {
      let returnArray = [];
      let collectionObj = {};
      for (const key in param) {
        const object = param[key];
        const name = object.name;
        const value = object.value;
        if (collectionObj[name] === undefined) {
          collectionObj[name] = [];
        }
        collectionObj[name].push(value);
      }
      for (const key in collectionObj) {
        const value = collectionObj[key].join(',');
        returnArray.push({
          name: key,
          value: value
        })
      }
      return returnArray;
    }
  </script>
</body>

</html>