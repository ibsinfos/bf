<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://boxthemes.net *
 * @package BoxThemes
 * @subpackage BoxThemes
 * @since 1.0
 * @version 1.0
 */
global $role; // visitor, FREELANCER, EMPLOYER, administrator;
$role = bx_get_user_role();

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link href="https://fonts.googleapis.com/css?family=Lato|PT+Sans|Raleway:200,300|Noto+Sans|Roboto|Josefin+Sans" rel="stylesheet">
	<style type="text/css">
		body{
			font-family: 'Roboto', sans-serif;
			font-size: 14px;
			color: #666;
			/*font-family: 'Josefin Sans', sans-serif !important;
			font-family: 'Noto Sans', sans-serif !important;
			font-family: 'Lato', sans-serif !important;
			*/
		}
	</style>
	<script type="text/javascript">
		var bx_global = {
			'home_url' : '<?php echo home_url() ?>',
			'admin_url': '<?php echo admin_url() ?>',
			'ajax_url' : '<?php echo admin_url().'admin-ajax.php'; ?>',
			'selected_local' : '',
			'is_free_submit_job' : true,
			'user_ID':'<?php global $user_ID; echo $user_ID ?>',

		}
	</script>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="row-nav full-width header" id="full_header">
	<div class="container">
		<div class="row">
			<div class="col-md-2 col-logo">
				<a class="logo" href="<?php echo home_url();?>">
					<?php
					$html_logo = get_custom_logo();
					if( !empty($html_logo) ) echo $html_logo;
					else  echo '<img class="avatar" src="'.get_theme_file_uri('img/logo.png').'" />';
					?>
				</a>
			</div>
			<div class="no-padding col-nav col-md-6">
			<?php if ( has_nav_menu( 'top' ) ) { ?>
				<?php get_template_part( 'template-parts/navigation', 'top' ); ?>
			<?php } ?>
			</div>
			<!-- seach form here !-->

			<div class="col-md-3 f-right align-right no-padding-left header-action">
				<?php
					if ( is_user_logged_in() ) {
						global $user_ID;
      				$current_user = wp_get_current_user();
				?>

				<ul class="account-dropdown">
					<li class="inline profile-account dropdown text-center first-sub">
						<a rel="nofollow" class="dropdown-toggle account-name" data-toggle="dropdown" href="#"> <?php echo $current_user->user_login;?> <span class="caret"></span></a>
						<ul class="dropdown-menu  ">
							<?php if(in_array($role, array(EMPLOYER,'administrator')) ){ ?>
								<li> <span class="glyphicon glyphicon-th"></span> <a href="<?php echo bx_get_static_link('dashboard');?>"><?php _e('My Project','boxtheme');?></a></li>
							<?php } else  if($role == FREELANCER){ ?>
								<li> <span class="glyphicon glyphicon-th"></span> <a href="<?php echo bx_get_static_link('dashboard');?>"><?php _e('My Job','boxtheme');?></a></li>
							<?php } ?>
							<li> <span class="glyphicon glyphicon-th"></span> <a href="<?php echo bx_get_static_link('credit');?>"><?php _e('Credit','boxtheme');?></a></li>
							<li> <span class="glyphicon glyphicon-user"></span> <a href="<?php echo bx_get_static_link('profile');?>"><?php _e('My profile','boxtheme');?></a></li>

							<li> <span class="glyphicon glyphicon-envelope"></span> <a href="<?php echo bx_get_static_link('messages');?>"><?php _e('Message','boxtheme');?></a></li>
							<li> <span class="glyphicon glyphicon-log-out"></span>  <a href="<?php echo wp_logout_url( home_url() ); ?>"><?php _e('Logout','boxtheme');?></a></li>
						</ul>
					</li>
					<li class="inline avatar first-sub"><?php echo get_avatar($user_ID);?></li>

					<li class="icon-bell first-sub">
						<span class="glyphicon glyphicon-bell toggle-msg"></span>
						<?php box_get_notify(); ?>
					</li>
				</ul>
				<?php } else { ?>
					<ul class="main-login">
						<li class="login text-center desktop-only ">
							<a href="<?php echo bx_get_static_link('login');?>" class="sign-text btn btn-login"><?php _e('Log In','boxtheme');?></a>
						</li>
						<li class=" sign-up desktop-only">
							<a href="<?php echo bx_get_static_link('signup');?>" class="btn btn-signup sign-text"> <?php _e('Sign Up','boxtheme');?></a>
						</li>
						<li class=" mobile-only">
							<button type="button" class="btn btn-login " data-toggle="modal" data-target="#loginModal">
		  						<span class="glyphicon glyphicon-user login-icon"></span>
							</button>
						</li>
					</ul>
				<?php } ?>
			</div> <!-- .header-action !-->
		</div>
	</div>	<!-- .navigation-top -->
</div>