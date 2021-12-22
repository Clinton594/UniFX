<?php
if ($uri->page_source == "sign-out") {
  session_destroy();
  header("Location: {$uri->site}");
  die();
}

?>
<!DOCTYPE html>
<html lang="en" class="js">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
  <title>Sign In | <?= $company->name ?></title>
  <?php require_once("includes/client-links.php"); ?>
  <style>
    a.btn-error.btn {
      background-color: red;
      min-width: unset;
    }
  </style>
</head>

<body class="page-ath">
  <div class="page-ath-wrap">
    <div class="page-ath-content">
      <div class="page-ath-header">
        <a href="<?= $uri->site ?>" class="page-ath-logo">
          <img src="<?= $company->logo_ref . $cache_control ?>" height="50" alt="Logo">
        </a>
      </div>
      <div class="page-ath-form">
        <h2 class="page-ath-heading">Sign in </h2>
        <div class="alert alert-dark py-2 px-3" style="line-height: 1;">
          <small>Please check that you are visiting <br>
            <strong><?= $uri->site ?></strong>
          </small>
        </div>
        <div>
          <div>
            <form method="post" name="login_frm" id="login_frm">
              <input name="__Cert" value="73a1c874" type="hidden">
              <div class="row">
                <div class="col-12">
                  <div class="input-item">
                    <input type="text" name="email" id="login_frm_Login" value="" placeholder="Your Email" class="input-bordered forgot-element">
                  </div>
                </div>
                <div class="col-12">
                  <div class="input-item">
                    <input type="password" name="password" id="login_frm_Pass" value="" placeholder="Password" class="input-bordered">
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="input-item text-left">
                  <input class="input-checkbox input-checkbox-md" id="login_frm_Remember" name="Remember" value="1" type="checkbox">
                  <label for="login_frm_Remember">Remember</label>
                </div>
                <div>
                  <div class="gaps-2x">
                    <a href="javascript:;" class=forgot-password>Reset password</a>
                  </div>
                </div>
              </div>
              <button name="login_frm_btn" type="submit" class="btn btn-warning btn-block submit">Sign In</button>
            </form>
          </div>
        </div>
        <div class="form-note">Do not have an account? <a href="<?= $uri->site ?>sign-up"> <strong class="font-weight-bold">Register now</strong>
          </a>
        </div>
      </div>
      <div class="page-ath-footer">
        <ul class="footer-links">
          <li>
            <a href="<?= $uri->site ?>privacy-policy">Privacy Policy</a>
          </li>
          <li>
            <a href="<?= $uri->site ?>terms">Terms</a>
          </li>
          <li>&copy; <?= date("Y") . "   " . $company->website ?> </li>
        </ul>
      </div>
    </div>
    <div class="page-ath-gfx">
      <div class="w-100 d-flex justify-content-center">
        <div class="col-md-10 moon-text">
          what is confortable is rarely profitable. !!!
        </div>
      </div>
    </div>
  </div>
  <?php require_once("includes/client-footer.php"); ?>
  <script>
    $(document).ready(function() {
      $("#login_frm").loginForm({
        "formName": "loginMembers",
        'forgoTPassword': true
      }, function(response) {
        setTimeout(() => {
          let url = new String(window.location);
          if (url.indexOf('?') != -1) {
            url = url.split("=")[1];
          } else {
            url = site.domain + "account";
          }
          window.location = url;
        }, 1500);
      })
    })
  </script>
</body>

</html>