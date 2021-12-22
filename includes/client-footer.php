<?php
if (!in_array($uri->page_source, ["sign-in", "sign-up", "referral"])) { ?>
  <div class="footer-bar pb-5">
    <div class="container pb-4">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-8">
          <ul class="footer-links">
            <li>
              <a href="faq">F.A.Q.</a>
            </li>
            <li>
              <a href="privacy-policy">Privacy Policy</a>
            </li>
            <li>
              <a href="terms">Terms and Conditions</a>
            </li>
          </ul>
        </div>
        <!-- .col -->
        <div class="col-md-4 mt-2 mt-sm-0">
          <div class="d-flex justify-content-between justify-content-md-end align-items-center guttar-25px pdt-0-5x pdb-0-5x">
            <div class="copyright-text">&copy; <?= date("Y") ?> <?= $company->name ?></div>
          </div>
        </div>
        <!-- .col -->
      </div>
      <!-- .row -->
    </div>
    <!-- .container -->
  </div>
  <!-- .footer-bar -->
  <style>
    #yt-widget[data-theme="dark"] .yt-button {
      background-color: rgba(255, 255, 255, 0.15);
      border-color: rgba(255, 255, 255, 0.3);
    }

    #yt-widget[data-theme="dark"] .yt-listbox {
      border-radius: 5px;
      background-color: #fff;
      border: none;
    }

    .yt-widget .yt-servicelink {
      display: none !important;
    }

    #yt-widget .yt-listbox {
      right: 0;
      width: 200px;
      max-height: 400px;
      overflow-y: auto;
    }

    #yt-widget .yt-listbox__col {
      float: left;
      width: 100%;
      display: block;
      font-size: 13px;
    }

    #yt-widget,
    #yt-widget * {
      font-size: 13px;
      color: #707A8A;
      font-family: "Inter";
    }

    #yt-widget .yt-listbox__text {
      color: #707A8A;
    }

    #yt-widget[data-theme="dark"] .yt-button:active,
    #yt-widget[data-theme="dark"] .yt-listbox__text:hover,
    #yt-widget[data-theme="dark"].yt-state_expanded .yt-button_type_right,
    #yt-widget[data-theme="dark"] .yt-listbox__input:checked~.yt-listbox__text {
      color: #fff;
    }
  </style>
<?php } ?>
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/619bbfdf6bb0760a4943ca4b/1fl46b0oc';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<script src="<?= $uri->site ?>js/core.min2df6.js<?= $cache_control ?>"></script>
<script src="<?= $uri->site ?>js/client-script.js<?= $cache_control ?>"></script>
<script src="<?= $uri->site ?>js/script2df6.js<?= $cache_control ?>"></script>
<script src="<?= $uri->backend ?>js/controllers.js<?= $cache_control ?>"></script>