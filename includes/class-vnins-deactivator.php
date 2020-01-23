<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://localhost/test.com
 * @since      1.0.0
 *
 * @package    Vnins
 * @subpackage Vnins/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Vnins
 * @subpackage Vnins/includes
 * @author     noname <abakan_ac545@mail.ru>
 */
class Vnins_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}tablename");
	}

}
