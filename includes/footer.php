    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="left">
                        <!--<a href="#" class="logo"><img src="<?=$company->favicon2?>" alt="img"></a>-->
                        <a href="#" class="logo"><img src="images/footer-logo.png" alt="img"></a>
                        <p>Global Hill Capital Ltd is an algorithm trading firm dedicated to producing exceptional results for it’s investors by strictly adhering to mathematical and statistical methods. Our mission is simple, Global Hill Capital Ltd creates and promotes thought leading investment allocations that deliver exceptional results.</p>

                    </div>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <div class="footer-item">
                        <h3>Useful Link</h3>
                        <ul>
                            <li><a class="home" href="<?=$uri->site?>home"><i class="fal fa-angle-right"></i>Home</a></li>
                            <li><a class="plan" href="<?=$uri->site?>investment-plan"><i class="fal fa-angle-right"></i>Investment Plan</a></li>
                            <li><a class="about" href="<?=$uri->site?>about"><i class="fal fa-angle-right"></i>About Us</a></li>
                            <li><a href="<?=$uri->site?>terms"><i class="fal fa-angle-right"></i></i>Terms & Conditions</a>
                            </li>
                            <li><a href="<?=$uri->site?>privacy"><i class="fal fa-angle-right"></i></i>Privacy Policy</a></li>
                            <li><a href="<?=$uri->site?>contact-us"><i class="fal fa-angle-right"></i></i>Contact-us</a></li>
                            <li><a href="<?=$uri->site?>faq"><i class="fal fa-angle-right"></i></i>Faqs</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-item contact_item">
                        <h3>Contact Info</h3>
                        <ul>
                            <li><a href="#!"><i class="far fa-map-marker-alt"></i><?=$company->address?></a></li>
                            <li><a href="mailto:<?=$company->email?>"><i class="far fa-envelope"></i><?=$company->email?></a></li>
                            <li><a href="whatsapp://send?text=Hi&phone=<?=$company->phone?>"><i class="fab fa-whatsapp"></i> <?=$company->phone?></a></li>
                        </ul>
                    </div>

                    <div class="footer-item contact_item mt-5">
                        <h3>LEGAL DOCs</h3>
                        <ul>
                            <li><a href="<?=$uri->site?>images/Certificate_of_Incorperation.pdf" target="_about">Certificate of Incorporations</a></li>
                            <li><a href="<?=$uri->site?>images/conflicts.pdf" target="_about">Conflicts</a></li>
                            <li><a href="<?=$uri->site?>images/General_Partner_Guidelines.pdf" target="_about">General Partner Guidelines</a></li>
                            <li><a href="<?=$uri->site?>images/Memo.pdf" target="_about">M.O.U</a></li>
                            <li><a href="<?=$uri->site?>images/Whitepaper.pdf" target="_about">Whitepaper</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-item footer-gallery">
                        <h3>Newsletter</h3>
                        <form>
                            <input type="email" placeholder="Enter your email*">
                            <button type="submit" style="padding: 0;" class="theme_btn" id="mail_btn">Subscribe <i class="fa fa-paper-plane"></i></button>
                        </form>
                    </div>
                    <img src="<?=$uri->site?>images/ssl.png" style="max-width: 100%; margin: 10px auto;" alt="">
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="bottom-left">
                    <span>Copyright &copy; <a href="#"><?=$company->name?></a> <?= date('Y') ?>. All rights reserved</span>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer  section end  -->

    <!-- jQuery v3.5.1 -->
    <script src="<?=$uri->site?>js/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap v5.0 -->
    <script src="<?=$uri->site?>js/bootstrap.bundle.min.js"></script>
    <!-- Extra Plugin -->
    <script src="<?=$uri->site?>vendors/wow-js/wow.min.js"></script>
    <script src="<?=$uri->site?>vendors/counterup/jquery.waypoints.min.js"></script>
    <script src="<?=$uri->site?>vendors/counterup/jquery.counterup.min.js"></script>
    <script src="<?=$uri->site?>vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="<?=$uri->site?>vendors/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="<?=$uri->site?>vendors/swiper/swiper-bundle.min.js"></script>

    <!-- Theme js / Custom js -->
    <script src="<?=$uri->site?>js/theme.js?<?=$cache_control?>"></script>
    <script src="<?=$uri->backend?>js/controllers.js"></script>

  <!--Start of Tawk.to Script-->
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
<!--End of Tawk.to Script-->

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
    </script>

    <script>
        function active_page(page) {
            $('.' + page).addClass('active');
        }

        $(document).ready(function(){
            let page = $("body").data("page");
            if(page=="referral"){
                $(".login_btn").click()
            }
            $(".swappable").click(function(e){
                e.preventDefault()
                let button = $(this);
                let to = button.data("to");
                let con = button.closest(".pannel");
                con.swapDiv($(`#${to}`), function(){
                    $(`#${to}`).find("form").show()
                });
            });

            if($("#signup_form").length){
                $("#signup_form").submitForm({
                    formName: "loginMembers",
                    return_values: true
                }, null, function(response) {
                    window.location = site.domain+"confirm-email"
                })
            }

            if($("#login_form").length){
                $("#login_form").loginForm({
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
            }
        })
    </script>
