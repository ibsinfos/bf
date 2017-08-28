<footer id="main-footer">
        <div class=" pre-footer ">
            <nav class="footer-nav wrapper pure-g-r container">
                <ul class="col-md-3 col-xs-4">
                    <li class="footer-list-header">About Us</li>
                    <li>
                        <ul>
                            <li><a href="#/features">Features</a></li>
                            <li><a href="#/templates">Templates</a></li>
                            <li><a href="#/team">Team</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="col-md-3 col-xs-4">
                    <li class="footer-list-header">Help &amp; Resources</li>
                    <li>
                        <ul>
                            <li><a href="#/contact">Contact</a></li>
                            <li><a href="#/help">Help Center</a></li>
                            <li><a href="https://vimeo.com/136125269">Video Tutorial!</a></li>
                            <li><a href="#/blog">Blog</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="col-md-3 col-xs-4">
                    <li class="footer-list-header">Commercial</li>
                    <li>
                        <ul>
                            <li><a href="#/why-lander">Why Lander</a></li>
                            <li><a href="#/pricing">Pricing</a></li>
                        </ul>
                    </li>
                    <li>
                        <nav class="footer-socialmedia">
                            <ul>
                                <li class="footer-list-header">Stay Tunned!</li>
                                <li class="socialmedia-icons">
                                    <a href="https://www.facebook.com/LanderApp" target="_blank" class="icon-facebook"></a>
                                    <a href="https://twitter.com/landerapp" target="_blank" class="icon-twitter"></a>
                                    <a href="https://plus.google.com/+Landerapp" target="_blank" class="icon-googleplus"></a>
                                    <a href="http://www.pinterest.com/landerapp/" target="_blank" class="icon-pinterest"></a>
                                </li>
                            </ul>
                        </nav>
                    </li>
                </ul>
                <ul class="col-md-3 col-xs-12">
                    <li class="footer-list-header">Contact Us</li>
                    <li>
                        <ul>
                            <li><p>Start a 14 Day Free Trial on any of our paid plans. No credit card required.</p></li>
                        </ul>
                        <ul>
                            <li><p>Call us at <a href="tel:+1 855.780.6889">+1 179.170.6889</a></p></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="footer-copyright">
            <div class="wrapper  container">
            	<div class="col-md-7">
                	<p><?php global $general; echo $general->coppyright;?></p>
                </div>
                <div class="col-md-5">

                </div>
            </div>
        </div>
    </footer>
    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content no-radius">
                <div class="modal-body">
                    <h6>Member Login</h6>
                    <form class="form-material sign-in  mt20" id="login-form" method="post">
                        <div id="login-error" class="alert alert-danger error"></div>
                        <div class="block">
                            <input type="text" class="form-control no-radius" name="user_login" placeholder="Email / Username" required>
                        </div>
                        <div class="block mt10">
                            <input type="password" class="form-control no-radius" name="user_password" placeholder="Password" required>
                        </div>
                        <?php wp_nonce_field( 'bx_login_action', 'nonce_login_field' ); ?>
                        <button id="login-submit" type="submit" class="btn btn-block btn-lg btn-go mt30 no-radius">Login</button>
                        <div class="loading-item" id="login-loading" style="display: none;"><div class="loadinghdo"></div></div>
                        <div class="login-via block">
                            <span class="f-left"><a onclick="show_forgot()" title="Forgot password?">Forgot password?</a></span>
                            <span class="f-right"><a class="link-signup"  href="<?php echo bx_get_static_link('signup');?>" title="New Member">New Member</a></span>
                            <div class="clearfix"></div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php wp_footer();?>
</body>