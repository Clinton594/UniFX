<?php include 'includes/header.php'; ?>
<!-- page-title -->
<div class="ttm-page-title-row">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title-box ttm-textcolor-white">
                    <div class="page-title-heading">
                        <h1 class="title">Contact Us</h1>
                    </div><!-- /.page-title-captions -->
                    <div class="breadcrumb-wrapper">
                        <span>
                            <a title="Homepage" href="index.php"><i class="ti ti-home"></i>&nbsp;&nbsp;Home</a>
                        </span>
                        <span class="ttm-bread-sep">&nbsp; | &nbsp;</span>
                        <span>Contact Us</span>
                    </div>
                </div>
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- page-title end-->

<!--site-main start-->
<div class="site-main">

    <!-- map-section -->
    <div class="ttm-row map-section clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--map-start-->
                    <div class="map-wrapper">
                        <div id="map_canvas"></div>
                    </div>
                    <!--map-end-->
                </div>
            </div>
        </div>
    </div>
    <!-- map-section end -->
    <!-- contact-form-section -->
    <section class="ttm-row contact-form-section clearfix">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="spacing-6 clearfix">
                        <!-- section title -->
                        <div class="section-title clearfix">
                            <div class="title-header">
                                <h3 class="title">We’re Happy to Discuss Your Investments and Answer any Question</h3>
                            </div>
                        </div><!-- section title end -->
                        <ul class="ttm_contact_widget_wrapper">
                            <li>
                                <h6>Address</h6>
                                <i class="ttm-textcolor-skincolor ti ti-location-pin"></i>
                                <span>2031 Flatbush Ave, No. 49 Brooklyn, NY 11234</span>
                            </li>
                            <li>
                                <h6>Email</h6>
                                <i class="ttm-textcolor-skincolor ti ti-comment"></i>
                                <span><a href="mailto:info@uniquefxcapital.com">info@uniquefxcapital.com</a></span>
                            </li>
                            <li>
                                <h6>Our Number</h6>
                                <i class="ttm-textcolor-skincolor ti ti-mobile"></i>
                                <span><img src="images/whatsapp.png">+1 (929) 314-8046</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="map-col-bg ttm-bgcolor-skincolor spacing-7">
                        <!-- section title -->
                        <div class="section-title text-left with-desc clearfix">
                            <div class="title-header">
                                <h2 class="title">Let’s Start <br> The Conversation.</h2>
                            </div>
                        </div><!-- section title end -->
                        <form id="ttm-contactform" class="ttm-contactform wrap-form clearfix" method="post" action="#">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>
                                        <span class="text-input">
                                            <input name="your-name" type="text" value="" placeholder="Your Name" required="required">
                                        </span>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label>
                                        <span class="text-input">
                                            <input name="email" type="email" value="" placeholder="Your Email" required="required">
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>
                                        <span class="text-input">
                                            <input name="your-phone" type="text" value="" placeholder="Your Phone" required="required">
                                        </span>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label>
                                        <span class="text-input">
                                            <input name="venue" type="text" value="" placeholder="Subject" required="required">
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <label>
                                <span class="text-input">
                                    <textarea name="message" cols="40" rows="3" placeholder="Message" required="required"></textarea>
                                </span>
                            </label>
                            <input name="submit" type="submit" id="submit" class="submit ttm-btn ttm-btn-size-md ttm-btn-shape-square ttm-btn-bgcolor-darkgrey" value="MAKE A RESERVATION">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact-form-section END-->
</div>
<!--site-main end-->
<?php include 'includes/footer.php'; ?>