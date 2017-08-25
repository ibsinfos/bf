 <?php
/**
 * Template Name: Page Signup
*/
 get_header();
 ?>
 	<!-- List job !-->
    <div class="container site-container">
        <div class="page-signup row m-lg-top m-xlg-bottom">
            <div class="col-md-12 m-lg-bottom">
                <hgroup class="text-center">
                    <h1 class="m-xs-top-bottom"><?php _e('Let\'s get started!','boxtheme');?></h1>
                    <h1 class="m-xs-top-bottom"><?php _e('First, tell us what you\'re looking for.','boxtheme');?></h1>
                </hgroup>
            </div>

            <div class="m-lg-bottom hidden-xs">&nbsp;</div>
            <div class="p-md-bottom visible-xs">&nbsp;</div>

            <div class=" col-md-offset-2 col-md-8 text-center">
                <div class="col-md-5">
                    <div class="text-muted">
                        <div><i class="glyphicon-xlg air-icon-client"></i></div>
                        <div class="o-user-type-selection"><?php _e('I want to hire a freelancer','boxtheme');?></div>
                    </div>
                    <p class="fs-sm m-lg-bottom">
                        <?php _e('Find, collaborate with,<br>and pay an expert.','boxtheme');?>
                    </p>
                    <a class="btn btn-primary text-capitalize m-0" href="<?php echo bx_get_static_link('signup-employer'); ?>"><?php _e('Hire','boxtheme');?></a>
                </div>

                <div class="col-md-2 o-or-divider"><?php _e('OR','boxtheme');?></div>

                <div class="col-md-5">
                    <div class="text-muted">
                        <div><i class="glyphicon-xlg air-icon-freelancer"></i></div>
                        <div class="o-user-type-selection"><?php _e('I\'m looking for online work','boxtheme');?></div>
                    </div>
                    <p class="fs-sm m-lg-bottom">
                        <?php _e('Find freelance projects and <br> grow your business.','boxtheme');?>
                    </p>
                    <a class="btn btn-primary text-capitalize m-0" href="<?php echo bx_get_static_link('signup-jobseeker');?>">Work</a>
                </div>

                <div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                	<hr />
                	<center><?php bx_social_button_signup() ?></center>
                </div>
            </div>
        </div>
    </div>
    <!-- End List Job !-->
<?php get_footer(); ?>