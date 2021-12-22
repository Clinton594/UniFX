<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
  <title>Affiliate Program | <?= $company->name ?></title>
  <?php require_once("includes/links.php"); ?>
</head>

<body>
  <?php require_once("includes/preloader.php"); ?>
  <div class="page">
    <?php require_once("includes/header.php"); ?>


    <!-- Breadcrumbs -->
    <section class="bg-image context-dark section-overlay-1" style="background-image: url(images/breadcrumbs-image-1.jpg);">
      <div class="container">
        <div class="breadcrumbs-custom__main">
          <h1 class="breadcrumbs-custom-title mt-5">Affiliate program</h1>
          <div class="breadcrumbs-custom__text">
            <h4>4-tier compensation system</h4>
          </div>
        </div>
      </div>
    </section>
    <!-- Welcome-->
    <section class="section section-md bg-white">
      <div class="container">
        <div class="row row-50 justify-content-center flex-md-row-reverse align-items-center">
          <div class="col-md-10 col-lg-6">
            <p class="text-initial-letter">New participants who register using your affiliate link become your referrals. Our affiliate program offers 4-tier compensation system for new referrals.</p>
            <div class="divider-modern">
            </div>
            <p>You will get <strong>8%</strong> of each deposit a tier 1 referral makes, <strong>3%</strong> of the deposit a tier 2 referral makes, <strong>1%</strong> of the deposit from a tier 3 referral and <strong>1%</strong> of the deposit from a tier 4 referral.</p>
            <p>You can promote your affiliate link in any legal way. We provide all the necessary promotional materials and all kinds of support.</p>
            <hr class="mt-4">
            <p class="lead">Become our Representative and earn higher referral commissions! </p>
            <p>Representative gets <strong>14%</strong> of each deposit a tier 1 referral makes, <strong>4%</strong> of the deposit a tier 2 referral makes, <strong>1%</strong> of the deposit from a tier 3 referral and <strong>1%</strong> of the deposit from a tier 4 referral.</p>
            <div class="group group-middle">
              <a class="button button-primary" href="<?= $uri->site ?>join-affiliate">Become a Representative</a>
            </div>
          </div>
          <div class="col-md-10 col-lg-6">
            <div class="image-group-1">
              <img class="wow fadeIn" src="images/affiliate-img.jpg" alt="" width="399" height="307" />
              <img class="wow fadeIn" src="images/affiliate-percents.png" alt="" width="421" height="332" data-wow-delay=".3s" />
            </div>
          </div>
        </div>
      </div>
    </section> <!-- CTA-->
    <section class="section parallax-container section-md bg-gray-700 text-center text-lg-left" data-parallax-img="images/cta-bg.jpg">
      <div class="parallax-content">
        <div class="container">
          <div class="row row-30 align-items-center">
            <div class="col-lg-9 wow fadeInLeftSmall">
              <h2>We know how to trade successfully!</h2>
              <p class="big">Join us and enjoy real profit and rewards on your investment.</p>
            </div>
            <div class="col-lg-3 wow fadeInRightSmall text-lg-right">
              <a class="button button-primary" href="<?= $uri->site ?>sign-up">Register now</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php require_once("includes/footer.php"); ?>
    <!-- Page Footer-->
</body>

</html>