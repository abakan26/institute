<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://localhost/test.com
 * @since      1.0.0
 *
 * @package    Vnins
 * @subpackage Vnins/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<form method="post">
	<input type="text" name="name">
	<input type="text" name="address">
	<input type="text" name="post_index">
	<input type="checkbox" name="is_sizo" value="1">
	<input type="hidden" name="action" value="new_institute">
	<input type="submit" name="submit">
</form>

