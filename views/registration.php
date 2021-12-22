<!DOCTYPE html>
<html lang="en" class="js">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
  <title>Sign Up | <?= $company->name ?></title>
  <?php require_once("includes/client-links.php"); ?>
</head>

<body class="page-ath">
  <?php require_once("includes/preloader.php"); ?>
  <div class="page-ath-wrap">
    <div class="page-ath-content">
      <div class="page-ath-header">
        <a href="<?= $uri->site ?>" class="page-ath-logo">
          <img src="<?= $company->logo_ref ?>" height="50" alt="Logo">
        </a>
      </div>
      <div class="page-ath-form">
        <h2 class="page-ath-heading">Sign up <span>Create New Account</span>
        </h2>
        <form method="post" action="" name="register_frm" id="register_frm">
          <input name="__Cert" value="a5d76e23" type="hidden">
          <div class="input-item">
            <input id="register_frm_aName" name="first_name" type="text" value="" placeholder="First Name" class="input-bordered" required>
            <small id="" class="form-text text-muted">First Name</small>
          </div>
          <div class="input-item">
            <input id="register_frm_uLogin" name="last_name" type="text" value="" placeholder="Last Name" class="input-bordered" required>
            <small id="" class="form-text text-muted">Last Name</small>
          </div>
          <div class="input-item">
            <input id="register_frm_uMail" name="email" type="email" value="" placeholder="Your Email" class="input-bordered">
          </div>
          <div class="input-item">
            <input id="register_frm_uPass" name="password" type="password" placeholder="Password" class="input-bordered">
            <small id="" class="form-text text-muted">Min Password length is 6 symbols</small>
          </div>
          <div class="input-item">
            <input id="register_frm_Pass2" name="password2" type="password" placeholder="Repeat Password" class="input-bordered">
          </div>
          <?php if ($uri->page_source == "referral" && !empty($uri->content_id)) { ?>
            <input type="hidden" name="referral" value="<?= $uri->content_id ?>">
            <div class="input-item">
              <div class="input-bordered">Referred by <?= strtoupper($uri->content_id) ?></div>
            </div>
          <?php } ?>
          <div class="input-item text-left">
            <input class="input-checkbox input-checkbox-md" required id="register_frm_Agree" name="Agree" value="1" type="checkbox">
            <label for="register_frm_Agree">I agree to <a href="<?= $uri->site ?>privacy-policy">Privacy Policy</a> &amp; <a href="<?= $uri->site ?>terms"> Terms.</a>
            </label>
          </div>
          <button name="register_frm_btn" type="submit" class="btn btn-warning btn-block submit">Create Account</button>
        </form>
        <div class="gaps-2x">
        </div>
        <div class="gaps-2x">
        </div>
        <div class="form-note">Already have an account ? <a href="<?= $uri->site ?>sign-in"> <strong>Sign in instead</strong>
          </a>
        </div>
      </div>
      <div class="page-ath-form" style="display:none">
        <h2 class="page-ath-heading">Activate Account</h2>
        <form id="otp-form" class="account-form">
          <div class="text-center  mb-4">
            <p>
              <b>
                <small>
                  <i>
                    Click on the "Send Code" button to receive a token in your email account
                  </i>
                </small>
              </b>
            </p>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-12">
              <div class="form-group">
                <label for="pin">6 Digit Token</label>
                <input type="text" name="pin" required class="send-code" data-code="verify-email">
              </div>
            </div>
          </div>
          <div class="form-group text-center">
            <button class="btn btn-success btn-block submit" type="submit">Confirm Email</button>
          </div>
        </form>
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
          Your <br> Journey <br> to the moon.
        </div>
      </div>
    </div>
  </div>
  <?php require_once("includes/client-footer.php"); ?>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#register_frm").submitForm({
        formName: "loginMembers",
        return_values: true
      }, null, function(response) {
        $("#register_frm")[0].reset();
        $("#register_frm").parent().swapDiv($("#otp-form").parent());
      })

      $("#otp-form").submitForm({
        formName: "none",
        process_url: `${site.process}custom`,
        case: "confirm-email",
        validation: "strict",
        pinAction: "verify-email"
      }, null, function(response) {
        setTimeout(() => {
          let url = new String(window.location);
          if (url.indexOf('?') != -1) {
            url = url.split("=")[1];
          } else {
            url = site.domain + "account";
          }
          // alert(url)
          window.location = url;
        }, 1500);
      })
    })
  </script>
</body>

</html>