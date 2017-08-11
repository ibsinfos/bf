<?php
/**
 *	Template Name: LandingPage 1
 */
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
add_action('before_header_menu','box_add_div' );
function box_add_div(){
	echo '<div class="full cover-img"><div class="full opacity"></div>';
}
add_action('after_cover_img','box_after_cover_img' );
function box_after_cover_img(){
	echo '</div>';
}
get_header(); ?>
<style type="text/css">
	.cover-img{
		background:url('<?php echo get_stylesheet_directory_uri();?>/img/banner.jpg') top center no-repeat;
	    background-size: cover;
	}
	.cover-img, .opacity{
		height: 588px;
	}
	.opacity{
		opacity: 0.8;
		position: absolute;
		background-color: rgba(255, 255, 255, 0.18);
	}
	.cover-img .header{
		background-color: transparent;
	}
	.cover-img .header .container{
		border:none;
	}
	body.fixed .cover-img .header .container{
		background-color: #fff;
	}
	.cover-img .header nav ul li a{
		color: #fff;
	}
	body.fixed .cover-img .header nav ul li a{
		color: #000;
	}
	.cover-img ul.main-login .btn-login{
		background-color: transparent;
		border:none;
		box-shadow: 0 0 0 1px #fff, 0 0 0 1px #fff;
		color: #fff;
	}
	body.fixed .cover-img ul.main-login .btn-login{
		color: #333;
    	background-color: #ddd;
	}
	body.fixed .cover-img .header{
		background-color: #fff;
	}

</style>
<div class="full-width">
	<div class="container">
		<div class="heading-aligner">
	        <h1>#JOIN OUR FREELANCE COMMUNITY</h1>
	        <p>We know it's hard to find a online expert when you need one,
	            which is why we've set on a mission to bring them all to one place.
	        </p>
	        <!-- CREATE PRODILE BUTTON -->
	        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	            <a href="" class="btn review-btn btn-action">
	                Create a Profile            </a>
	        </div>
	        <!-- POST A PROJECT BUTTON -->
	        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	            <a href="<?php echo home_url("submit-project");?>" class="btn   review-btn find-btn btn-action">Post a Project</a>
	        </div>
	    </div>
	</div>
</div>
<?php do_action('after_cover_img' );?>
<div class="full-width top-profile">
	<div class=" container site-container">
		<div class="row">
		<div class="col-md-12">
			<h2> Looking for Professional Freelancers?</h2>
		</div>
		<?php
		$profile_query = new WP_Query( array (
			'post_type' => PROFILE,
			'post_status' => 'publish',
			'orderby'   => 'meta_value_num',
			'meta_key'  => RATING_SCORE,
			'order'     => 'DESC',
			'orderby'    => 'meta_value_num',
			'order'      => 'DESC',

			'showposts' => 6
			)
		);
		if( $profile_query->have_posts() ){
			while( $profile_query->have_posts() ){
				global $post;
				$profile_query->the_post();
				$rating = get_post_meta($post->ID,RATING_SCORE, true);
				get_template_part( 'template-parts/profile/profile', 'loop' );
			}
		}
		?>

	</div>
	</div> <!-- .row !-->
</div>
<section class="panels theme-background-color-blue left-aligned panels_1 accordion why-paypal">
	<div class="container">
		<div class="row">
		<header class="organism__header ">
		<h2 class="pypl-heading pp-sans-big-light organism__header__headline ">Why PayPal for your business?</h2></header>
		<div class="col-lg-12 panels__panel__row">
			<div class="panels__panel panels__panel-0 col-lg-4  col-sm-12 col-md-4" data-idx="0">
				<div class="panels__panel__image-area"></div>
				<div class="panels__panel__icon-head-area"><img class="panels__panel__image" src="https://www.paypalobjects.com/digitalassets/c/website/marketing/apac/au/icons/wherever-you-do-business-icon.png" alt="Wherever you do business "><h3 class="pypl-heading pp-sans-big-light panels__panel__headline h4">Wherever you do business </h3><span class="panels__panel__arrow arrow-indicator"></span></div><div class="panels__panel__text-hatch-area"><div class="panels__panel__paragraph" style="height: 88px;">Online, on mobile, in person or by email; PayPal’s merchant services make it easier for you to get paid anywhere you do business.</div><p class="panels__panel__hatchlink"><a class="contentLink" href="https://www.paypal.com/au/webapps/mpp/business-solutions">Payment solutions</a></p></div>
			</div>
			<div class="panels__panel panels__panel-1 col-lg-4  col-sm-12 col-md-4" data-idx="1">
				<div class="panels__panel__image-area"></div>
				<div class="panels__panel__icon-head-area">
				<img class="panels__panel__image" src="https://www.paypalobjects.com/digitalassets/c/website/marketing/apac/au/icons/AU-icon-dollarcoin-white.png" alt="Straightforward pricing"><h3 class="pypl-heading pp-sans-big-light panels__panel__headline h4">Straightforward pricing</h3><span class="panels__panel__arrow arrow-indicator"></span></div><div class="panels__panel__text-hatch-area"><div class="panels__panel__paragraph" style="height: 88px;">No one likes surprises so we only charge a set rate based on how much you sell. There are no account, set-up or cancellation fees.</div><p class="panels__panel__hatchlink"><a class="contentLink" href="https://www.paypal.com/au/webapps/mpp/paypal-seller-fees">Business fees</a></p></div>
			</div>

			<div class="panels__panel panels__panel-2 col-lg-4  col-sm-12 col-md-4" data-idx="2">
				<div class="panels__panel__image-area"></div>
				<div class="panels__panel__icon-head-area">
					<img class="panels__panel__image" src="https://www.paypalobjects.com/digitalassets/c/website/marketing/apac/au/icons/safer-icon.png" alt="Business security"><h3 class="pypl-heading pp-sans-big-light panels__panel__headline h4">Business security</h3><span class="panels__panel__arrow arrow-indicator"></span>
				</div>
				<div class="panels__panel__text-hatch-area">
					<div class="panels__panel__paragraph" style="height: 88px;">We monitor transactions for fraud in real time to help keep your business safer, and we protect your eligible sales with Seller Protection.</div><p class="panels__panel__hatchlink"><a class="contentLink" href="https://www.paypal.com/au/webapps/mpp/seller-security">Business security</a></p>
				</div>
			</div>

			</div>
		</div>
	</div>
</section>


<div class="full-width packge-plan">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="pricing-table-plan">
					<header data-plan="basic" class="pricing-plan-header basic-plan">
						<span class="plan-name">Free</span>
					</header>

		    		<div class="plan-features">
		    		<span class="plan-monthly">	$0</span>
		    		Just register 1 new account and you can:
		    			-Free post 5 project on this system.
		    			-Auto subcriber on system.

					</div>
		            <a class="btn btn-primary1 btn-xlarge btn-orange" href="https://cloud.landerapp.com/Registration/Register?selectedPlanId=39&amp;origin=basic_pricing">TRAIL NOW</a>

				</div>
			</div>
			<div class="col-md-4">
				<div class="pricing-table-plan">
					<header data-plan="basic" class="pricing-plan-header basic-plan">
						<span class="plan-name">Premium</span>
					</header>

		    		<div class="plan-features">
		    		<span class="plan-monthly">
		    			$30
		    		</span>
		    		to buy 30 credit and you can both 20 job on this system.
					</div>
		            <a class="btn btn-primary1 btn-xlarge btn-orange" href="https://cloud.landerapp.com/Registration/Register?selectedPlanId=39&amp;origin=basic_pricing">TRAIL NOW</a>

				</div>
			</div>
			<div class="col-md-4">
				<div class="pricing-table-plan">
					<header data-plan="basic" class="pricing-plan-header basic-plan">
						<span class="plan-name">Standard</span>
					</header>

		    		<div class="plan-features">
		    		<span class="plan-monthly">
		    			$20
		    		</span>
		    			to buy 30 credit and you can both 20 job on this system.
					</div>
		            <a class="btn btn-primary1 btn-xlarge btn-orange" href="https://cloud.landerapp.com/Registration/Register?selectedPlanId=39&amp;origin=basic_pricing">TRAIL NOW</a>

				</div>
			</div>

		</div> <!-- end row !-->
	</div>
</div>


<section class="pullout theme-background-color-dark "><div class="container"><div class="row"><header class="organism__header ">
<h2 class="pypl-heading pp-sans-big-light organism__header__headline ">Get paid fast from buyers around the world.</h2>
<p class="organism__header__paragraph ">PayPal helps you build a global business. </p></header>
<div class="col-xs-12 col-md-10 center-block text-xs-center">
	<i class="mpp-data-point text-xs-center mpp-data-point-0">
	<span class="text"><span class="stats-text">
		<?php
		$count_posts = wp_count_posts(PROJECT);
		echo $count_posts->publish;
		?>
		</span><span class="description-text">Projects posted</span></span>
	</i>
<i class="mpp-data-point text-xs-center mpp-data-point-1"><span class="text"><span class="stats-text">6M </span><span class="description-text">Australian buyers</span></span></i>
<i class="mpp-data-point text-xs-center mpp-data-point-2"><span class="text"><span class="stats-text">110K </span><span class="description-text">Australian businesses</span></span></i>
<i class="mpp-data-point text-xs-center mpp-data-point-3"><span class="text"><span class="stats-text">25</span><span class="description-text">Currencies </span></span></i>
</div></div></div></section>

<style type="text/css">

/************* WHY PAYPAL */
.organism__header {
    text-align: center;
}
.panels__panel__row {
    margin-top: 30px;
}
.why-paypal {
    padding-bottom: 60px;
}
.why-paypal .organism__header__headline {
    padding-bottom: 15px;
}
.h2.pypl-heading, h2.pypl-heading {
    font-size: 40px;
    font-size: 2.85714286rem;
}
.organism__header__headline {
    padding: 0 0 30px;
}
.panels {
    padding: 60px 0;
}
.pypl-heading {
    line-height: 1.25;
}
.theme-background-color-blue {
    background-color: #009cde;
    background-image: radial-gradient(circle farthest-side at center bottom,#009cde,#003087 125%);
    color: #fff;
}
.theme-background-color-blue a {
    color: #fff;
    font-weight: 700;
}
.panels__panel__headline.pypl-heading {
    font-size: 20px;
    font-size: 1.42857143rem;
    font-weight: 700;
}
.panels__panel__headline {
    display: inline-block;
    vertical-align: middle;
}
.panels .panels__panel__hatchlink {
    text-align: left;
    padding-top: 10px;
}
.panels__panel__headline.pypl-heading {
    font-size: 20px;
    font-weight: 700;
}
.panels__panel .panels__panel__image, .panels__panel__headline {
    display: block;
}
/************* END WHYPAYPAL */
/** LIST STATS */
.pullout {
    padding: 60px 0;
}
.theme-background-color-dark .mpp-data-point {
    box-shadow: 0 0 0 1px #fff, 0 0 0 1px #fff;
    color: #fff;
}
.theme-background-color-dark {
    background-color: #6c7378;
    background-image: radial-gradient(circle farthest-side at center bottom,#6c7378,#2c2e2f 125%);
    color: #fff;
}
.pullout .mpp-data-point {
    margin: 10px 20px;
}
.mpp-data-point {
    font-style: normal;
    display: inline-block;
    height: 125px;
    width: 125px;
    border: 0;
    box-shadow: 0 0 0 1px #2c2e2f, 0 0 0 1px #2c2e2f;
    color: #2c2e2f;
    border-radius: 50%;
    overflow: hidden;
}
.center-block {
    display: block;
    margin-left: auto;
    margin-right: auto;
    float: none;
}
.mpp-data-point .stats-text {
    display: block;
    font-size: 30px;
    font-family: pp-sans-big-light,Helvetica Neue,Arial,sans-serif;
}
.mpp-data-point .description-text {
    font-size: 14px;
    font-family: pp-sans-small-light,Helvetica Neue,Arial,sans-serif;
}
.mpp-data-point .text {
    display: table-cell;
    vertical-align: middle;
    height: 125px;
    width: 125px;
    padding: 10px;
}
.text-xs-center {
    text-align: center!important;
}
/*********************** END STATS */
.top-profile{
	background: transparent;
	padding:0 0 30px 0;
}
.top-profile .container{
	background: transparent;
	background-clip: content-box;
}
.top-profile .container h2{
	padding: 5px 0 15px 0;
}

.col-md-6.archive-profile-item .full{
	-moz-box-shadow:    3px 3px 5px 6px #ccc;
  -webkit-box-shadow: 3px 3px 5px 6px #ccc;
  	box-shadow: 0px 0px 3px 3px #f3f3f3;
}

.workflow{
	padding: 20px 0 50px 0;
}
.workflow .nav-pills>li>a{
	border-radius: 0;
	text-transform: uppercase;
}
#exTab1 .tab-content {
  padding : 5px 0;
}
.workflow .nav{
	border-bottom: 1px solid #ccc;
}
.packge-plan{
	padding: 60px 0 60px 0;
	background-color: #6c7378;
    background-image: radial-gradient(circle farthest-side at center bottom,#6c7378,#2c2e2f 125%);
    border-bottom: 1px solid #ccc;
}
.pricing-table-plan {
    padding: 2em;
    text-align: center;
    width: 100%;
    background-color: #fff;
}
.plan-monthly {
    font-size: 2.5em;
    line-height: 140%;
}

.btn.btn-orange:hover {
    background-color: #f99e34 !important;
}
.plan-name {
    font-size: 1.75em;
    font-weight: 600;
    line-height: 100%;
    padding: .4em 0;
}
.plan-features {
    width: 100%;
    margin: 0.5em 0;
    padding: 2em 0;
    list-style: none;
    border-top: 1px solid #DFDFD0;
    text-align: center;
    min-height: 175px;
}
.plan-features > li {
    padding: 0;
    border-bottom: 1px solid #DFDFD0;
    font-size: .9375em;
    display: table;
    width: 100%;
    height: 3rem;
}
.plan-features > li span, .plan-features > li a {
    display: table-cell;
    vertical-align: middle;
}
.pricing-table-plan span{
	display: block;
}
.round {
    width: 100px;
    height: 100px;
    border-radius1: 50%;
    text-align: center;
    line-height: 100px;
    font-size: 30px;
    margin: 0 auto;
    border: 2px solid #fff;
    color: #FFA000;
    background: #fff;

}
.system-static{
	padding: 25px;
	background: #ececec;
}
.system-static center{
	font-size: 20px;
	padding-top: 21px;
}
@media only screen and (max-width: 768px) {
	.heading-aligner h1{
		font-size: 25px;
		line-height: 35px;
	}
	.heading-aligner > p{
		padding: 25px 20px 0;
	}
	.main-banner{
		height: 450px;
		min-height: 400px;
		padding-top: 50px;
	}
	.top-profile .container{
		background-clip: initial;
	}
	.archive-profile-item .col-md-3{
		padding-left: 0;
	}
	.archive-profile-item .col-xs-8{
		padding-right: 0;
	}
	.col-md-6.archive-profile-item .full{
		padding: 0;
	}
	.archive-profile-item .col-xs-12{
		padding-right: 0;
	}


	.archive-profile-item .col-xs-12{
		padding-left: 15px;
	}
	.container{
		padding-left: 10px;
		padding-right: 10px;
	}

	.small, small{
		font-size: 100%;
	}
}
</style>

<?php get_footer();
