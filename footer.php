<?php

global $general;
$label = array(
    'first_title' => 'Contact Us',
    'second_title' => 'Help & Resources',
    'third_title' => 'Commercial',
);
$args = array( 'first'=>'','second' => '','third' => ''); ?>

<footer id="main-footer">
    <div class="pre-footer ">
        <nav class="footer-nav wrapper pure-g-r container">
            <?php foreach( $args as $key => $value){
                $title_key = $key.'_title';
        		$title =  $label[$title_key];

        		if( isset($general->$title_key) ){
        			$title =  $general->$title_key;
        		} ?>
                <div class="col-md-3 col-xs-4">
            		<h5 class="footer-list-header"> <?php echo $title; ?></h5> <?php
                    if( !empty($general->$key) ){
            			wp_nav_menu( array(
                    		'menu'        => $general->$key,
                    		'menu_class' =>'full',
            				'container' => '',
                    		)
            			);
            		} ?>
                </div>
            <?php } ?>

            <div class="col-md-3 col-xs-12"> <?php

            	if( !empty ( $general->contact ) ){
                    echo $general->contact;
                } else { ?>
                	<h5 class="footer-list-header">Contact Us</h5>
					<p>Start a 14 Day Free Trial on any of our paid plans. No credit card required.</p>
                    <p>Call us at <a href="tel:+1 855.780.6889">+1 179.170.6889</a></p>
				<?php } ?>

            </div>
        </nav>
    </div>
    <div class="footer-copyright">
        <div class="wrapper  container">
        	<div class="row">
            	<div class="col-md-8">
                	<p><?php echo stripslashes($general->copyright);?></p>
                </div>
                <div class="col-md-4">
                	<ul class="social-link">
                		<?php
                		if ( !empty( $general->gg_link ) )
                			echo '<li><a class="gg-link"  target="_blank" href="'.esc_url($general->gg_link).'"><span></span></a></li>';
                		if ( !empty( $general->tw_link ) )
                			echo '<li><a class="tw-link" target="_blank"  href="'.esc_url($general->tw_link).'"><span></span></a></li>';
                		if ( !empty( $general->fb_link ) )
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
                <h6><?php _e('Member Login','boxtheme');?></h6>
                <form class="form-material sign-in  mt20" id="login-form" method="post">
                    <div id="login-error" class="alert alert-danger error"></div>
                    <div class="block">
                        <input type="text" class="form-control no-radius" name="user_login" placeholder="<?php _e('Email / Username','boxtheme');?>" required>
                    </div>
                    <div class="block mt10">
                        <input type="password" class="form-control no-radius" name="user_password" placeholder="<?php _e('Password','boxtheme');?>" required>
                    </div>
                    <?php wp_nonce_field( 'bx_login_action', 'nonce_login_field' ); ?>

                    <button id="login-submit" type="submit" class="btn btn-block btn-lg btn-go mt30 no-radius"><?php _e('Login','boxtheme');?></button>
                    <div class="loading-item" id="login-loading" style="display: none;"><div class="loadinghdo"></div></div>
                    <div class="login-via block">
                        <span class="f-left"><a onclick="show_forgot()" title="Forgot password?"><?php _e('Forgot password?','boxtheme');?></a></span>
                        <span class="f-right"><a class="link-signup"  href="<?php echo bx_get_static_link('signup');?>" title="<?php _e('New Member','boxtheme');?>"><?php _e('New Member','boxtheme');?></a></span>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e('Close','boxtheme');?></button>
            </div>
        </div>
    </div>
</div>
    <?php wp_footer();?>
</body>