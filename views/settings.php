<?php
require_once("includes/client-authentication.php");

$countries = get_param_countries($uri);
?>
<!DOCTYPE html>
<html lang="en" class="js">

<head>
  <title>Settings | <?= $company->name ?></title>
  <?php require_once("includes/client-links.php") ?>
  <style>
    span.input-bordered {
      float: left;
      position: relative;
      width: 100%;
      margin-bottom: 20px;
    }
  </style>
</head>

<body class="page-user">
  <?php require_once("includes/preloader.php"); ?>
  <div class="topbar-wrap mb-4">
    <?php require_once("includes/client-nav.php"); ?>
  </div>
  <div class="page-content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="main-content col-lg-10 col-xl-9">
          <div class="content-area card">
            <div class="card-innr">
              <div class="card-head">
                <h4 class="card-title">Profile Settings </h4>
              </div>
              <ul class="nav nav-tabs nav-tabs-line nav-fill" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#profile" data-role="profile">Personal Data</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link " data-toggle="tab" href="#change-password" data-role="change-password">Change Password</a>
                </li>
              </ul><!-- .nav-tabs-line -->
              <div class="tab-content tab-stats">
                <div class="tab-pane fade active show" id="profile">
                  <form action="" id="profilef-form">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="input-item input-with-label">
                          <label class="input-item-label">Username</label>
                          <span class="input-bordered w-100" type="text" disabled> <?= $user->username ?></span><!-- .input-item -->
                        </div><!-- .input-item -->
                      </div>
                      <div class="col-md-6">
                        <div class="input-item input-with-label">
                          <label class="input-item-label">Email Address</label>
                          <span class="input-bordered w-100" type="text" disabled> <?= $user->email ?></span><!-- .input-item -->
                        </div><!-- .input-item -->
                      </div>
                      <div class="col-md-3">
                        <div class="input-item input-with-label"><label for="account_frm_aName" class="input-item-label">First Name</label><input class="input-bordered" type="text" value="<?= $user->first_name ?>" id="account_frm_aName" name="first_name"></div><!-- .input-item -->
                      </div>
                      <div class="col-md-3">
                        <div class="input-item input-with-label"><label for="account_frm_aName" class="input-item-label">Last Name</label><input class="input-bordered" type="text" value="<?= $user->last_name ?>" id="account_frm_aName" name="last_name"></div><!-- .input-item -->
                      </div>
                      <div class="col-md-6">
                        <div class="input-item input-with-label"><label for="account_frm_aCountry" class="input-item-label">Country</label>
                          <select class="select-bordered select-block" name="country" id="account_frm_aCountry">
                            <option value="" disabled="">Select Country</option>
                            <?php foreach ($countries as $key => $country) { ?>
                              <option <?php if ($user->country == $key) { ?> selected <?php } ?> value="<?= $key ?>"><?= $country ?></option>
                            <?php } ?>
                          </select>
                        </div><!-- .input-item -->
                      </div><!-- .col -->
                      <input type="hidden" name="id" value="<?= $user->id ?>">
                      <div class="col-md-12 mb-3"><label class="input-item-label font-weight-bold">Security settings</label></div>
                      <div class="col-md-12">
                        <div class="input-item"><input type="checkbox" class="input-switch input-switch-sm" name="aNoMail" id="account_frm_aNoMail" value="1"><label for="account_frm_aNoMail" style="font-weight:400;">Do not be notified via e-mail</label></div>
                      </div>
                      <div class="col-md-12">
                        <div class="input-item"><input type="checkbox" class="input-switch input-switch-sm" name="aSessIP" id="account_frm_aSessIP" value="1"><label for="account_frm_aSessIP" style="font-weight:400;">Bind session to IP-address</label></div>
                      </div>
                      <div class="col-md-12">
                        <div class="input-item"><input type="checkbox" class="input-switch input-switch-sm" name="aSessUniq" id="account_frm_aSessUniq" value="1"><label for="account_frm_aSessUniq" style="font-weight:400;">Disallow parallel sessions</label></div>
                      </div>
                      <div class="col-md-12">
                        <hr>
                      </div>
                      <div class="input-item input-with-label w-50">
                        <label for="account_frm_PIN_two" class="input-item-label">Token code <small>(to confirm changes)</small></label>
                        <div class="float-left w-100">
                          <input class="input-bordered send-code" name="pin" id="account_frm_PIN_two" data-code='update-profile' autocomplete="off" size="8" type="number" class="password" required>
                        </div>
                      </div>
                    </div><!-- .row -->
                    <div class="gaps-1x"></div><!-- 10px gap -->
                    <div class="d-sm-flex justify-content-between align-items-center">
                      <button class="btn btn-warning submit" type="submit" name="account_frm_btn">Update Profile</button>
                      <div class="gaps-2x d-sm-none"></div>
                    </div>
                  </form>
                </div><!-- .tab-pane -->
                <div class="tab-pane fade" id="change-password">
                  <form action="" id="password">
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                    <p>Make sure you click on "Send code" button to receive a token in your registered email to be able to change your password.</p>

                    <div class="gaps-1x"></div>
                    <hr>
                    <div class="gaps-1x"></div>

                    <div class="card-head">
                      <h4 class="card-title">Change Password</h4>
                    </div>
                    <div class="gaps-1x"></div>
                    <div class="row align-items-center">
                      <div class="col-6 col-sm-3 mb-3 mb-sm-0"><img src="<?= $uri->site ?>images/icon_lock3.png" class="img-fluid"></div>
                      <div class="col-12 col-sm-9">
                        <div class="copy-wrap mgb-0-5x">
                          <label for="password">Enter your new password</label>
                          <input type="password" class="copy-address" name="password">
                        </div>

                        <div class="copy-wrap mgb-0-5x">
                          <label>Retype your new password</label>
                          <input name="password2" class="copy-address" type="password">
                        </div>
                      </div>
                    </div>
                    <div class="gaps-1x"></div>
                    <hr>
                    <div class="input-item input-with-label ">
                      <label for="account_frm_PIN_two" class="input-item-label">Token code <small>(to confirm changes)</small></label>
                      <div class="float-left w-100">
                        <input class="input-bordered send-code" name="token" id="account_frm_PIN_two" data-code='code' autocomplete="off" size="8" type="number" class="password">
                      </div>
                    </div><!-- .input-item -->
                    <button class="btn btn-warning submit mt-4" required type="submit" name="account_frm_btn">Confirm <em class="ti ti-arrow-right mgl-4-5x"></em></button>
                  </form>
                </div>
              </div><!-- .tab-content -->
            </div><!-- .card-innr -->
          </div>
        </div><!-- .col -->
      </div><!-- .container -->
    </div><!-- .container -->
  </div><!-- .page-content -->
  <?php require_once("includes/client-footer.php") ?>
  <script src="<?= $uri->backend ?>js/swal.js"></script>
  <script>
    $(document).ready(function() {
      $("#profilef-form").submitForm({
        formName: "user-profile",
        action: "resetPassword"
      }, null, function() {
        Swal.fire({
          icon: "success",
          title: "Successful"
        }).then(function() {
          window.location.reload()
        })
      });

      $("#password").submitForm({
        formName: "loginMembers",
        case: 1.4
      }, null, function() {
        Swal.fire({
          icon: "success",
          title: "Successful"
        }).then(function() {
          window.location.reload()
        })
      });
    })
  </script>
</body>

</html>