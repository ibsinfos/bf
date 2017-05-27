<?php
global $wpdb;
global $user_ID;

// $t = $wpdb->insert(
// 			$wpdb->prefix . 'box_messages', array(
// 				'msg_content' 	=> 'test',
// 				'cvs_id' 		=> 0,
// 				'msg_date' 		=> current_time('mysql'),
// 				'msg_is_read' => 0,
// 				'msg_status' => 1,
// 				'msg_receiver_id' => 25
// 			)
// 		);
// 		var_dump($t);
// var_dump( $wpdb->last_query ) ;
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
					<img src="<?php echo get_stylesheet_directory_uri().'/img/logo.png';?>" />
				</a>
			</div>
			<div class="no-padding col-nav">
			<?php if ( has_nav_menu( 'top' ) ) { ?>
				<?php get_template_part( 'template-parts/navigation', 'top' ); ?>
			<?php } ?>
			</div>
			<div class="col-md-3 no-padding col-xs-12 col-search hide">
				<?php
					$project_link = $default =  get_post_type_archive_link(PROJECT);
					$placeholder = __('Find a job','boxtheme');
					$profile_link = get_post_type_archive_link(PROFILE);
					if( is_post_type_archive(PROFILE) ){
						$default = $profile_link;
						$placeholder = __('Find a freelancer','boxtheme');
					}
				?>
				<form class="frm-search" action="<?php echo $default;?>">
					<span class="glyphicon glyphicon-search absolute search-icon"></span>
					<select class="input-control absolute"  id="search_type">
						<option value="<?php echo $project_link;?>" alt="<?php _e('Find a job','boxtheme');?>">
							<?php _e('Job','boxtheme');?>
						</option>
						<option value="<?php echo $profile_link;?>" alt="<?php _e('Find a freelancer','boxtheme');?>">
							<?php _e('Freelancer','boxtheme');?>
						</option>
					</select>
					<input type="text" name="s" id="keyword" class="keyword full no-radius" value="<?php echo get_query_var('s');?>" placeholder="<?php echo $placeholder;?>" />
					<button class="mobile-only" type="submit"><span class="glyphicon glyphicon-search"></span></button>
				</form>
			</div>

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
							<li> <span class="glyphicon glyphicon-user"></span> <a href="<?php echo bx_get_static_link('profile');?>">Update profile</a></li>
							<li> <span class="glyphicon glyphicon-th"></span> <a href="<?php echo bx_get_static_link('dashboard');?>">Dashboard</a></li>
							<li> <span class="glyphicon glyphicon-envelope"></span> <a href="<?php echo bx_get_static_link('messages');?>"><?php _e('Message','boxtheme');?></a></li>
							<li> <span class="glyphicon glyphicon-log-out"></span>  <a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a></li>
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
						<li class="login text-center dropdown desktop-only ">
							<a rel="nofollow" class="dropdown-toggle sign-text btn" data-toggle="dropdown" href="#">Sign in <span class="caret"></span></a>
							<div class="dropdown-menu width-7">
								<div class="col-md-12">
									<form method="post" class="sign-in form login-form">
										<div class="form-group">
											<input type="text" class="form-control no-radius" name="user_login" placeholder="Email / Username" required />
										</div>
										<div class="form-group">
											<input type="password" name="user_password" class="form-control password no-radius" placeholder="Password" />
										</div>
										<div class="form-group">
											<label class="checkbox-inline checkbox-styled checkbox-primary lh-1-5">
												<input type="checkbox" value="1" class="remember" id="remember"><span>Remember me</span>
											</label>
										</div>
										<?php wp_nonce_field( 'bx_signin', 'nonce_login_field' ); ?>
										<button type="submit" class="btn btn-raised btn-success btn-block no-radius" ><?php _e('Sign in','boxtheme');?></button>
										<div class="divider"></div>
										<div class="form-group pad-0-top mar-0-top align-right">
											<span class="toggle-fgp pointer " href="#">Forgot password?</span>
										</div>
									</form>
									<form method="post" class="forgot-pass">
										<div class="form-group">
											<input type="text" class="form-control no-radius" name="user_email" placeholder="Your emai" required />
										</div>
										<?php wp_nonce_field( 'bx_refresh_pass', 'nonce_login_field' ); ?>
										<button type="submit" class="btn btn-raised btn-success btn-block no-radius" ><?php _e('Reset Password','boxtheme');?></button>
										<div class="divider"></div>
										<div class="form-group pad-0-top mar-0-top align-right">
											<span class="toggle-signup pointer " href="#">Sign in</span>
										</div>
									</form>
								</div>
							</div>
						</li>
						<li class=" sign-up desktop-only">
							<a href="<?php echo bx_get_static_link('signup');?>" class="btn btn-signup sign-text"> <?php _e('Sign up','boxtheme');?></a>
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