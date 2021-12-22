<style>
    #forgot-panel * {
        color: white
    }

    #forgot-panel {
        margin-top: 45rem
    }

    #forgot-panel>form {
        margin-top: unset
    }
</style>
<header class="main-header">
    <div class="container">
        <div class="top-header">
            <div class="row">
                <div class="col-md-6">
                    <ul class="topbar-left">
                        <li><a href="mailto:support@globalhillcapital.com"><span><i class="fa fa-envelope"></i></span>
                                Support@globalhillcapital.com</a></li>
                        <!-- <li><a href="https://wa.me/+48732232604" target="_blant"><span class="phone"><i class="fa fa-phone"></i></span>+48732232604</a></li> -->
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="topbar-right">
                        <li>
                            <a href="" id="google_translate_element" class="text-primary">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <nav class="main-navbar">
            <div class="nav-inner">
                <a href="<?= $uri->site ?>" class="brand"><img src="<?= $company->logo_ref ?>" alt="img"></a>
                <ul class="desktop-menu">
                    <li><a class="home" href="<?= $uri->site ?>">Home</a></li>
                    <li><a class="plan" href="<?= $uri->site ?>investment-plan">Investment Plan</a></li>
                    <li><a class="about" href="<?= $uri->site ?>about">About Us</a></li>
                    <li><a class="services" href="<?= $uri->site ?>services">Services</a></li>

                    <li><a class="legal" href="#"> Legal Agreement <i class="fal fa-chevron-down"></i> </a>
                        <ul class="sub-menu">
                            <li><a href="<?= $uri->site ?>terms"><i class="fal fa-chevron-right"></i>Terms & Conditions</a>
                            </li>
                            <li><a href="<?= $uri->site ?>privacy"><i class="fal fa-chevron-right"></i>Privacy Policy</a></li>
                            <li><a href="<?= $uri->site ?>images/Certificate_of_Incorperation.pdf" target="_about"><i class="fal fa-chevron-right"></i>Certificate of Incorporations</a></li>
                            <li><a href="<?= $uri->site ?>images/conflicts.pdf" target="_about"><i class="fal fa-chevron-right"></i>Conflicts</a></li>
                            <li><a href="<?= $uri->site ?>images/General_Partner_Guidelines.pdf" target="_about"><i class="fal fa-chevron-right"></i>General Partner Guidelines</a></li>
                            <li><a href="<?= $uri->site ?>images/Memo.pdf" target="_about"><i class="fal fa-chevron-right"></i>M.O.U</a></li>
                            <li><a href="<?= $uri->site ?>images/Whitepaper.pdf" target="_about"><i class="fal fa-chevron-right"></i>Whitepaper</a></li>

                        </ul>
                    </li>
                    <li><a class="support" href="#"> Support <i class="fal fa-chevron-down"></i> </a>
                        <ul class="sub-menu">
                            <li><a href="<?= $uri->site ?>contact-us"><i class="fal fa-chevron-right"></i>Contact-us</a></li>
                            <li><a href="<?= $uri->site ?>faq"><i class="fal fa-chevron-right"></i>Faqs</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="mobile-header">
                    <a href="#" class="search_btn border-0 login_btn" title="My Account"><i class="far fa-user-circle" style="font-size: 45px; color: #FF9C1A;"></i></a>
                    <div class="menu-icon">
                        <div class="open-menu"><i class="far fa-bars"></i></div>
                        <div class="close-menu"><i class="far fa-times"></i></div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="mobile-menu">
            <ul>
                <li><a class="home" href="<?= $uri->site ?>home">Home</a></li>
                <li><a class="plan" href="<?= $uri->site ?>investment-plan">Investment Plan</a></li>
                <li><a class="about" href="<?= $uri->site ?>about">About Us</a></li>
                <li><a class="services" href="<?= $uri->site ?>services">Services</a></li>


                <li><a href="<?= $uri->site ?>terms">Terms & Conditions</a>
                </li>
                <li><a href="<?= $uri->site ?>privacy">Privacy Policy</a></li>
                <li><a href="<?= $uri->site ?>images/Certificate_of_Incorperation.pdf" target="_about">Certificate of Incorporations</a></li>
                <li><a href="<?= $uri->site ?>images/conflicts.pdf" target="_about">Conflicts</a></li>
                <li><a href="<?= $uri->site ?>images/General_Partner_Guidelines.pdf" target="_about">General Partner Guidelines</a></li>
                <li><a href="<?= $uri->site ?>images/Memo.pdf" target="_about">M.O.U</a></li>
                <li><a href="<?= $uri->site ?>images/Whitepaper.pdf" target="_about">Whitepaper</a></li>

                <li><a href="<?= $uri->site ?>contact-us">Contact-us</a></li>
                <li><a href="<?= $uri->site ?>faq">Faqs</a></li>

            </ul>
        </div>
    </div>
</header>

<!-- search modal start  -->
<div class="search_overlay"></div>
<div class="search_close">
    <div style="background: white; border-radius: 100%;"> <i class="fa fa-times p-3"></i> </div>
</div>
<div class="search_modal">
    <div class="input_box">
        <div class="search-popup">
            <div id="login" class=pannel>
                <form method="post" id="login_form" style="background: none;">
                    <button class="theme-btn btn-style-one mt-3 title-btn swappable" data-to="register" type=button><i class="fa fa-user" aria-hidden="true"></i> <span class="txt">Create An account</span></button>
                    <!--Form Group-->
                    <div class="form-group mt-3">
                        <label>User Email</label>
                        <input type="email" class=forgot-element name="email" id="user_email" value="" placeholder="Enter Your Email" required>
                    </div>
                    <!--Form Group-->
                    <div class="form-group mt-3">
                        <label>Password</label>
                        <input type="password" name="password" id="user_password">
                    </div>

                    <a href="javascript:void(0)" id="resetpass_btn" class="d-block pt-3 swappable forgot-password" data-to="reset">I forgot my Password</a>

                    <div class="form-group mt-3 alart_area">

                    </div>

                    <button class="theme-btn btn-style-one mt-5 sub-btn submit" type=submit id="" name="submit-form"><span class="txt">Login <span class="loader"><i class="fa fa-spin fa-spinner" aria-hidden="true"></i></span></span></button>

                </form>
            </div>

            <div id="register" class=pannel style="display:none">
                <form method="post" id="signup_form" style="background: none;">
                    <button class="theme-btn btn-style-one mt-3 login_btn title-btn swappable" data-to="login" type=button><i class="fa fa-user-circle" aria-hidden="true"></i> <span class="txt">Login Instead</span></button>
                    <!--Form Group-->
                    <div class="form-group mt-3">
                        <label>full name</label>
                        <input type="text" name="full_name" id="name" value="" placeholder="Enter Full Name" required>
                    </div>
                    <!--Form Group-->
                    <div class="form-group mt-3">
                        <label>phone number</label>
                        <input type="text" name="phone" id="phone" value="" placeholder="Enter your phone number" required>
                    </div>
                    <!--Form Group-->
                    <div class="form-group mt-3">
                        <label>Email</label>
                        <input type="email" name="email" id="email" value="" placeholder="Enter your Email address" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="country">Select Country</label>
                        <select name="country" id="country">
                            <option value="">Select Country</option>
                            <?php
                            foreach (get_param_countries($uri) as $key => $value) { ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <?php }
                            ?>
                        </select>

                    </div>

                    <div class="form-group mt-3">
                        <label>Password</label>
                        <input type="password" name="password" id="password">
                    </div>

                    <div class="form-group mt-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password2" id="conf_pass">
                    </div>

                    <?php
                    if ($uri->page_source == "referral") { ?>
                        <div class="form-group mt-3">
                            <label>Referrer <small>(<?= $uri->content_id ?>)</small></label>
                            <input type="text" readonly name="referral" id="referral" value="<?= $uri->content_id ?>" placeholder="optional">
                        </div>
                    <?php }
                    ?>



                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="consent" required class=float-left> I have read and accepted GlobalHill Capital Ltd <a href="#" class="checkbox-link">Privacy policy</a> and<br>
                            <a href="#" class="checkbox-link">Terms of Use</a>
                        </label>
                    </div>

                    <div class="form-group mt-3 alart_area">

                    </div>

                    <button class="theme-btn btn-style-one mt-3 sub-btn submit" type=submit id="create_acc" name="submit-form"><span class="txt">Create Account <span class="loader"><i class="fa fa-spin fa-spinner" aria-hidden="true"></i></span></span></button>

                </form>
            </div>


        </div>
    </div>
</div>
<!-- search modal start  -->