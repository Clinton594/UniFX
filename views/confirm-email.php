<?php
require_once('app.php');
require_once('includes' . DS . 'header.php');
?>

<body>
<style>
    input.send-code + button{
        width:100px;
        border-top-right-radius:30px !important;
        border-bottom-right-radius:30px !important;
    }
</style>


    <!-- header start  -->

    <!-- header end  -->

    <div class="page-title-area overlay-bg style-1 pt-5 search-popup" style="background-size:cover">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h3 class="title"> Confirm Email</h3>
                    <small>Click on "Send Code" to recieve a code in your email</small>
                </div>
                <div id="reset" class="col-md-6 p-4 bg-white rounded-3 mt-3">

                    <form method="post" class="mt-0" id=otp-form>
                        <!--Form Group-->
                        <div class="form-group mt-3">
                            <label>Enter Code</label>
                            <div>
                            <input type="number" data-code="verify-email" id="reset_email" class=send-code value="" placeholder="xxxxxx" required name=pin>
                            </div>
                        </div>

                        <div class="form-group mt-3 alart_area">

                        </div>

                        <button class="theme-btn btn-style-one mt-5 sub-btn submit" type=submit><span class="txt">Confirm<span class="loader"><i class="fa fa-spin fa-spinner" aria-hidden="true"></i></span></span></button>

                    </form>
                </div>
            </div>
        </div>
    </div>


   
    <!-- Top Investors section end  -->


    <?php require_once('includes' . DS . 'footer.php'); ?>

    <script>
        active_page('plan');
    </script>
<script type="text/javascript">
    $(document).ready(function() {

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