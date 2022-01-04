<div class="container-fluid d-none d-lg-block">
  <div class="currencies-rate row justify-content-between">
    <?php foreach ($coins as $key => $_coin) { ?>
      <div class="col py-1 rate-block"> <span class="d-block text-nowrap">
          <i class="cf cf-<?= strtolower($_coin->symbol) ?>">
          </i> <?= $_coin->name ?></span>
        <strong class="font-weight-bold">$<?= $fmn->format(round($_coin->price, 4)) ?></strong>
      </div>
    <?php } ?>
  </div>
</div>
<div class="topbar is-sticky px-0">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <ul class="topbar-nav d-lg-none">
        <li class="topbar-nav-item relative">
          <a class="toggle-nav" href="#">
            <div class="toggle-icon">
              <span class="toggle-line">

              </span>
              <span class="toggle-line">

              </span>
              <span class="toggle-line">

              </span>
              <span class="toggle-line">

              </span>
            </div>
          </a>
        </li>
        <!-- .topbar-nav-item -->
      </ul>
      <!-- .topbar-nav -->
      <a class="topbar-logo" href="<?= $uri->site ?>">
        <img src="<?= $company->logo_ref ?>" height="30" alt="logo">
      </a>
      <div class="languages ml-auto mr-4 d-none d-sm-block">
        <div id="ytWidget">

        </div>
        <script src="https://translate.yandex.net/website-widget/v1/widget.js?widgetId=ytWidget&pageLang=en&widgetTheme=dark&autoMode=false" type="text/javascript">
        </script>
      </div>
      <ul class="topbar-nav">
        <li class="topbar-nav-item relative">
          <span class="user-welcome d-none d-lg-inline-block">Welcome, <?= $user->first_name ?> <?= $user->last_name ?>!</span>
          <a class="toggle-tigger user-thumb" href="<?= $uri->site ?>settings">
            <em class="ti ti-user">

            </em>
          </a>
          <div class="toggle-class dropdown-content dropdown-content-right dropdown-arrow-right user-dropdown">
            <div class="user-status">
              <h6 class="user-status-title">Balance</h6>
              <div class="user-status-balance"><?= $currency . $fmn->format(round($user->balance, 2)) ?> <small>USD</small>
              </div>
            </div>
            <ul class="user-links">
              <li>
                <a href="<?= $uri->site ?>settings">
                  <i class="ti ti-id-badge">

                  </i>Settings</a>
              </li>
              <li>
                <a href="<?= $uri->site ?>join-affiliate">
                  <i class="ti ti-link">

                  </i>Affiliate</a>
              </li>
              <li>
                <a href="<?= $uri->site ?>wallets">
                  <i class="ti ti-wallet">

                  </i>Wallets</a>
              </li>
            </ul>
            <ul class="user-links bg-light">
              <li>
                <a href="<?= $uri->site ?>sign-out">
                  <i class="ti ti-power-off">
                  </i>Logout</a>
              </li>
            </ul>
          </div>
        </li>
        <!-- .topbar-nav-item -->
      </ul>
      <!-- .topbar-nav -->
    </div>
  </div>
  <!-- .container -->
</div>
<!-- .topbar -->
<div class="navbar">
  <div class="container">
    <div class="navbar-innr">
      <ul class="navbar-menu">
        <li>
          <a href="<?= $uri->site ?>account"> Main</a>
        </li>
        <li>
          <a href="<?= $uri->site ?>fund-account">Fund Account</a>
        </li>
        <li>
          <a href="<?= $uri->site ?>invest">Invest</a>
        </li>
        <li>
          <a href="<?= $uri->site ?>withdraw">Withdraw</a>
        </li>
        <li>
          <a href="<?= $uri->site ?>buy-tokens">Buy BTC</a>
        </li>
        <li>
          <a href="<?= $uri->site ?>exchange">Exchange</a>
        </li>

         <li>
          <a href="<?= $uri->site ?>mining">Free Mining</a>
        </li>

        <li>
          <a href="<?= $uri->site ?>transactions">Transactions</a>
        </li>
        <li>
          <a href="<?= $uri->site ?>operations">Operations</a>
        </li>
        <li>
          <a href="<?= $uri->site ?>join-affiliate">Affiliate</a>
        </li>
      </ul>
      <ul class="navbar-btns">
        <li>
          <a href="<?= $uri->site ?>invest#plans" class="btn btn-auto d-block d-lg-inline-block btn-sm btn-warning">
            <span>Investment plans <em class="ml-4 ti ti-arrow-right">

              </em>
            </span>
          </a>
        </li>
      </ul>
    </div>
    <!-- .navbar-innr -->
  </div>
  <!-- .container -->
</div>
<!-- .navbar -->
</div>
<!-- .topbar-wrap -->
<div class="page-content">
  <div class="container">
    <div class="d-lg-none row justify-content-between">
      <div class="col col-auto mb-3">
        <a href="<?= $uri->site ?>invest" class="btn btn-auto d-block d-lg-inline-block btn-sm btn-warning">
          <span>Make Investment <em class="ml-4 ti ti-arrow-right">

            </em>
          </span>
        </a>
      </div>
      <div class="col col-auto mb-3">
        <div id="ytWidget2">

        </div>
        <script src="https://translate.yandex.net/website-widget/v1/widget.js?widgetId=ytWidget2&pageLang=en&widgetTheme=light&autoMode=false" type="text/javascript">
        </script>
      </div>
    </div>
    <!-- <div class="row mb-3 mb-sm-4">
      <div class="col-auto ml-auto d-none d-sm-block">2FA status:<div class="btn-group ml-2" role="group" aria-label="2FA">
          <a href="<?= $uri->site ?>settings?2fa" class="btn btn-auto btn-xs btn-outline btn-dark-alt">Enabled</a>
          <a href="<?= $uri->site ?>settings?2fa" class="btn btn-auto btn-xs btn-dark-alt disabled">Disabled</a>
        </div>
      </div>
      <div class="col-auto d-none d-sm-block">
        <a class="btn btn-xs btn-outline btn-secondary btn-auto" href="<?= $uri->site ?>signin?out">Logout</a>
      </div>
    </div> -->
    <style>
      @keyframes pulse_animation {
        0% {
          transform: scale(.95);
        }

        50% {
          transform: scale(1.02);
        }

        100% {
          transform: scale(.95);
        }
      }

      .pulse {
        animation-name: pulse_animation;
        animation-duration: 1000ms;
        transform-origin: 70% 70%;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
      }

      .pulse:hover {
        animation-name: none !important;
      }

      @keyframes blinking_animation {
        0% {
          opacity: 0.05;
        }

        50% {
          opacity: 1;
        }

        100% {
          opacity: 0.05;
        }
      }

      .blinking {
        animation-name: blinking_animation;
        animation-duration: 1000ms;
        transform-origin: 70% 70%;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
      }

      .blinking:hover {
        animation-name: none !important;
      }
    </style>