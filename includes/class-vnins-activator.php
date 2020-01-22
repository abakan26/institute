<?php

/**
 * Fired during plugin activation
 *
 * @link       http://localhost/test.com
 * @since      1.0.0
 *
 * @package    Vnins
 * @subpackage Vnins/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Vnins
 * @subpackage Vnins/includes
 * @author     noname <abakan_ac545@mail.ru>
 */
class Vnins_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'tablename';
		$sql = "CREATE TABLE $table_name (
			id int(11) NOT NULL AUTO_INCREMENT,
			name varchar(255) DEFAULT NULL,
			address varchar(255) DEFAULT NULL,
			post_index varchar(255) DEFAULT NULL,
			is_sizo int(11) DEFAULT 0,
			UNIQUE KEY id (id)
		) DEFAULT CHARSET=utf8;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' ); 
		dbDelta($sql);
	}

}
