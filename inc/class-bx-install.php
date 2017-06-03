<?php
class BX_Install{


	private static function create_tables() {
		global $wpdb;
		$wpdb->hide_errors();

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( self::get_schema() );
	}

	public static function init() {
		add_action( 'init', array( __CLASS__, 'check_version' ), 5 );
	}
	public static function check_version() {
		self::install();
	}
	public static function install() {
		global $wpdb;

		self::create_tables();
	}

	private static function get_schema() {
		global $wpdb;

		$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			$collate = $wpdb->get_charset_collate();
		}

		/*
		 * Indexes have a maximum size of 767 bytes. Historically, we haven't need to be concerned about that.
		 * As of WordPress 4.2, however, we moved to utf8mb4, which uses 4 bytes per character. This means that an index which
		 * used to have room for floor(767/3) = 255 characters, now only has room for floor(767/4) = 191 characters.
		 *
		 * This may cause duplicate index notices in logs due to https://core.trac.wordpress.org/ticket/34870 but dropping
		 * indexes first causes too much load on some servers/larger DB.
		 */
		$max_index_length = 191;

		$tables = "
			CREATE TABLE {$wpdb->prefix}box_messages (
			  	ID bigint(20) NOT NULL AUTO_INCREMENT,
			  	cvs_id bigint(20) NOT NULL,
			  	sender_id  bigint(20)  NULL,
			  	receiver_id  bigint(20) NOT NULL,
			  	msg_status  char(15)  NULL,
			  	msg_type  char(15)  NULL,
			  	msg_unread  bigint(20) NULL,
			  	msg_content longtext NOT NULL,
			  	msg_date datetime NULL default null,
			  	msg_link varchar(256) NULL,
			  	PRIMARY KEY  (ID),
			 	 UNIQUE KEY ID (ID)
				) $collate;
			CREATE TABLE {$wpdb->prefix}box_conversations (
			  	ID bigint(20) NOT NULL AUTO_INCREMENT,
			  	cvs_author  bigint(20) NOT NULL,
			  	cvs_project_id  bigint(20) NOT NULL,
			  	receiver_id  bigint(20) NOT NULL,
			  	cvs_content longtext NOT NULL,
			  	cvs_date datetime NULL default null,
			 	cvs_status char(15) NOT NULL,
			 	msg_unread char(15) NOT NULL,
			  	PRIMARY KEY  (ID),
			  	UNIQUE KEY ID (ID)
			) $collate;";


		return $tables;
	}
}
BX_Install::init();