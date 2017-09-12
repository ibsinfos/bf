<?php
    global $general;
    $args = array( 'first'=>'','second' => '','third' => '');
    $label = array(
        'first_title' => __('Contact Us','boxtheme'),
        'second_title' => __('Help & Resources','boxtheme'),
        'third_title' => __('Commercial','boxtheme'),
    );
?>
<?php
	if( function_exists( 'box_debug') ){
		box_debug();
	}
?>

    <footer id="main-footer">
        <div class="pre-footer ">
            <nav class="footer-nav wrapper pure-g-r container">
                <?php
                $customier_link = admin_url( 'customize.php?autofocus[section]=footer_setup');

                foreach( $args as $key => $value) {

                   	$title_key = $key.'_title';
            		$title =  $label[$title_key];

            		if( isset( $general->$title_key ) )
            			$title =  $general->$title_key;
            		?>
                    <div class="col-md-3 col-xs-4">
                		<h5 class="footer-list-header"> <?php echo $title; ?></h5> <?php
                        if( ! empty( $general->$key ) ) {
                			wp_nav_menu( array(
                        		'menu'        => $general->$key,
                        		'menu_class' =>'full',
                				'container' => '',
                        		)
                			);
                		} else if( current_user_can( 'manage_options' ) ) {

                			printf(__('Setup this menu <a href="%s"> <i>here</i></a>.','boxtheme'), $customier_link );

                		} ?>
                    </div> <?php
                } ?>

                <div class="col-md-3 col-xs-12"> <?php
                	if( ! empty ( $general->contact ) ) {
                        echo $general->contact;
                    } else {
                    	echo '<h5 class="footer-list-header">Contact Us</h5><p>Start a 14 Day Free Trial on any of our paid plans. No credit card required.</p>
								<p>Call us at <a href="tel:+1 855.780.6889">+1 179.170.6889</a></p>';
						if(current_user_can( 'manage_options' ) ){ ?>
						<a class="box-customizer-link" href="<?php echo $customier_link;?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z"></path></svg></a>
						<?php }
    				} ?>
                </div>
            </nav>
        </div>
        <div class="footer-copyright">
            <div class="wrapper  container">
            	<div class="col-md-8 col-xs-12"> <p><?php echo stripslashes($general->copyright);?></p> </div>
                <div class="col-md-4 col-xs-12"> <?php box_social_link($general);?> </div>
            </div>
        </div>
    </footer>
    <?php get_template_part( 'modal/mobile', 'login' ); ?>
    <?php wp_footer();?>
</body>