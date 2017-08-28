<footer id="main-footer">
        <div class=" pre-footer ">
            <nav class="footer-nav wrapper pure-g-r container">
                <?php

                	$menus = (object) get_option('footer_menu');
                	$label = array(
                		'first_title' => 'Contact Us',
                		'second_title' => 'Help & Resources',
                		'third_title' => 'Commercial',
                	);
                	$args = array( 'first'=>'','second' => '','third' => '');
                	foreach( $args as $key => $value){
                		echo '<div class="col-md-3 col-xs-12">';
	                		$title_key = $key.'_title';

	                		$title =  $label[$title_key];
	                		if( isset($menus->$title_key) ){
	                			$title =  $menus->$title_key;
	                		}
	                		echo '<h5 class="footer-list-header">'.$title.'</h5>';
	                		if( !empty($menus->$key) ){

	                			wp_nav_menu( array(
			                		'menu'        => $menus->$key,
			                		'menu_class' =>'full',
	                				'container' => '',
			                		)
	                			);
	                		}
	                	echo '</div>';
                	}

                	?>

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
            	<div class="row">
	            	<div class="col-md-8">
	                	<p><?php global $general; echo !empty($general->coppyright) ? stripslashes($general->coppyright) :'2017 © Boxthemes. All rights reserved. <a href="https://boxthemes.net/terms-and-conditions/" target="_blank">Term of Use</a> and <a href="https://boxthemes.net/terms-and-condition/" target="_blank">Privacy Policy</a>';?></p>
	                </div>
	                <div class="col-md-4">
	                	<ul class="social-link">
	                		<?php
	                		if ( isset( $general->gg_link ) )
	                			echo '<li><a class="gg-link"  target="_blank" href="'.esc_url($general->gg_link).'"><span></span></a></li>';
	                		if ( isset( $general->tw_link ) )
	                			echo '<li><a class="tw-link" target="_blank"  href="'.esc_url($general->tw_link).'"><span></span></a></li>';
	                		if ( isset( $general->fb_link ) )
	                			echo '<li><a class="fb-link"  target="_blank" href="'.esc_url($general->fb_link).'"><span></span></a></li>';
	                		?>
	                	</ul>
	                </div>
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