<?php include 'includes/header.php'; ?>


<body style="overflow-x: hidden;">



    <!-- header start  -->


    <!-- search modal start  -->

    <!-- header end  -->

    <!-- page-title -->
    <div class="ttm-page-title-row">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-box ttm-textcolor-white">
                        <div class="page-title-heading">
                            <h1 class="title">Services</h1>
                        </div><!-- /.page-title-captions -->
                        <div class="breadcrumb-wrapper">
                            <span>
                                <a title="Homepage" href="index.php"><i class="ti ti-home"></i>&nbsp;&nbsp;Home</a>
                            </span>
                            <span class="ttm-bread-sep">&nbsp; | &nbsp;</span>
                            <span> Services </span>
                        </div>
                    </div>
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- page-title end-->



    <!-- about-section start  -->
    <section class="about-section about_two_page" style="overflow-x: hidden;">
        <div class="container">

            <div class="heading-title">
                <h6><span></span> services</h6>
                <h2><span class="c-text"> Financial</span> Market Investments

                </h2>
            </div>
            <div class="mb-5" style="padding-bottom: 5rem;">
                <p>We Buy or Sell hundreds of CFD assets including major, minor and exotic forex pairs, metals, energies, indices, cryptocurrencies and shares of the world’s biggest companies. We trade at some of the tightest spreads available, and enjoy ultra-low trading costs, advanced execution, exclusive analysis tools and world-class market research by our professional traders and market analysts. We access 250+ underlying instruments from our 5 asset classes at some of the most competitive conditions.
                </p>
                <p>
                    Throughout its history, Global Hill Co Limited has completed numerous direct investments across different sectors and geographies. In 2017, Direct Investments was officially launched as the primary platform for Global Hill Investment Limited’s long term principal investing activity and as part of the firm’s strategic refocus on becoming the preferred investment partner in Asia. Global Hill Co Limited provides medium-to long-term debt financing through loans and guaranties to eligible investments in many countries and emerging markets. By complementing the private sector, Global Hill Co Limited can provide financing in countries where conventional financial institutions often are reluctant or unable to lend. Our Debt financing package for startups can take a variety of forms and, depending on the form and source of financing, may co-exist with equity investment in your business. Debt can be used to benefit all shareholders, including founders and investors, to fund the growth of the business without further diluting the ownership position of the existing shareholders.

                </p>

            </div>



            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="left-content">
                        <div class="heading-title">
                            <h2><span class="c-text"> Corporate</span> Loans


                            </h2>
                        </div>
                        <div class="">
                            <div class="images">
                                <!-- <img src="<?= $uri->site ?>images/01Icon.svg" alt="img"> -->
                            </div>
                            <div class="media-body">
                                <!-- <h3 class="c-text">Market Analysis</h3> -->
                                <p>As the leader of a private company, you need to make sound financial decisions that will not only benefit the business now, but also in the long term. You may be facing the challenges of accessing financing, trying to determine the value of your business to communicate to stakeholders, or considering selling your business or buying another business. Access to capital and a strong financial foothold is essential for the success of your company. Whether you are looking for financing from the bank or through alternative methods, there are a number of options available to choose from. We can advise you on the different sources of capital, assist you in accessing financing, manage your risk and compliance and help you evaluate ways to increase your liquidity. We work with clients to articulate their goals and then create an integrated plan to achieve those goals, no matter what phase of the wealth cycle they are currently in. We help firms worldwide define, build, and maintain winning strategies. Our network of strategists works with banks, insurers, asset managers and payments companies to help define, build and maintain winning business portfolios, align actions with long-term objectives, and balance risks.

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-side">
                        <div class="post-comment">
                            <h2 class="title form_title">Request Loan</h2>
                            <h6 class="mb-5">send us a request and we will handle the rest. </h6>
                            <form method="post" class="post_from" action="<?= $url->site ?>actions/contact_us.php" id="contact-form">
                                <input type="text" id="msg_name" name="name" placeholder="Name *" required>
                                <input type="email" id="msg_email" name="email" placeholder="Emaill Address *" required>
                                <!-- <input type="text" name="subject" placeholder="Subject (Optional)" required> -->
                                <textarea name="msg" id="msg_text" placeholder="Request details"></textarea>

                                <div class="msg">

                                </div>

                                <button class="theme_btn" id="msg_btn" type="button" name="how_it_work"><span class="txt">Send Request</span></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 mt-5 pt-5">
                    <p>Our involvement with a client begins from concept and ends with implementation. In doing so the company has the ability to deliver an efficient investment management approach to private, corporate and institutional customers. We continue to look for opportunities where we can use our insight into the growth drivers of the underlying business. We believe that this is a more robust source of returns, over the business cycle, than a sole reliance on financial leverage and we invest with the primary intention of creating a measurable social impact. The corporate finance department of GlobalHill Capital Limited consists of experienced and credentialed financial experts that strive to offer the highest quality of services that are tailored for the client’s needs.

                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- about-section end  -->

    <!-- footer  section start  -->
    <?php include 'includes/footer.php'; ?>

    <script>
        active_page('services');
        $(document).ready(function() {
            $('#msg_btn').click(function(e) {
                e.preventDefault();
                var btn = $('#msg_btn');
                btn.attr('disabled', 'disabled');
                btn.html('<i class="fa fa-spin fa-spinner"></i>');
                $.post("<?= $uri->site ?>actions/contact_us.php", {
                        name: $('#msg_name').val(),
                        email: $('#msg_email').val(),
                        msg: $('#msg_text').val(),
                        how_it_work: 'ok'
                    },
                    function(data) {
                        if (data != 'success') {
                            $('.msg').html('<p class="text-danger" style="color:red">' + data + '</p>');
                        } else {
                            $('.msg').html('<p class="text-success" style="color:green">Your request has been submitted, We will contact you within 24hr</p>');
                        }
                        btn.removeAttr('disabled');
                        btn.html('Send Request');
                    }
                );
            });
        });
    </script>
</body>


</html>