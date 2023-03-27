<?php

/**
 * Fired during plugin activation
 *
 * @link       https://atul.com
 * @since      1.0.0
 *
 * @package    Content_Calendar
 * @subpackage Content_Calendar/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Content_Calendar
 * @subpackage Content_Calendar/includes
 * @author     atul.com/atul-plugin <atul@atul.com>
 */
class Content_Calendar_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;

		$table_name = $wpdb->prefix . "events";
		$charset_collate = $wpdb->get_charset_collate();
	
		$sql = "CREATE TABLE IF NOT EXISTS $table_name(
			id mediumint(9) AUTO_INCREMENT,
			date date NOT NULL,
			occassion text,
			post_title text NOT NULL,
			author varchar(40) NOT NULL,
			reviewer varchar(40) NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";
	
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

	}

}
