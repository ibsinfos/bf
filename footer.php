<?php
    global $general;
    $args = array( 'first'=>'','second' => '','third' => '');
    $label = array(
        'first_title' => 'Contact Us',
        'second_title' => 'Help & Resources',
        'third_title' => 'Commercial',
    );
?>

    <footer id="main-footer">
        <div class="pre-footer ">
            <nav class="footer-nav wrapper pure-g-r container">
                <?php
                foreach( $args as $key => $value){

                   $title_key = $key.'_title';
            		$title =  $label[$title_key];

            		if( isset( $general->$title_key ) ){
            			$title =  $general->$title_key;
            		} ?>
                    <div class="col-md-3 col-xs-4">
                		<h5 class="footer-list-header"> <?php echo $title; ?></h5> <?php
                        if( !empty( $general->$key ) ){
                			wp_nav_menu( array(
                        		'menu'        => $general->$key,
                        		'menu_class' =>'full',
                				'container' => '',
                        		)
                			);
                		} ?>
                    </div> <?php
                } ?>

                <div class="col-md-3 col-xs-12"> <?php
                	if( ! empty ( $general->contact ) ){
                        echo $general->contact;
                    } else {
                    	echo '<h5 class="footer-list-header">Contact Us</h5><p>Start a 14 Day Free Trial on any of our paid plans. No credit card required.</p>
								<p>Call us at <a href="tel:+1 855.780.6889">+1 179.170.6889</a></p>';
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