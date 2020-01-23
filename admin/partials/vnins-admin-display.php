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

global $wpdb;

$institutes = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}" . VNINS_DBTN);


//echo "<pre>";
//var_dump($institutes2);
//echo "</pre>";
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<form method="post">
    <h2>Добавить учреждение</h2>
    <p>
        <input type="text" name="name" placeholder="Название учреждения">
    </p>
    <p>
        <input type="text" name="address" placeholder="Адресс">
    </p>
    <p>
        <input type="text" name="post_index" placeholder="Почтовый индекс">
    </p>

    <label for="">Сизо</label>
    <input type="checkbox" name="is_sizo" value="1">
    <input type="hidden" name="action" value="new_institute">
    <input type="submit" name="submit">
</form>
<h2>Все учреждение</h2>
<table border="1">
    <thead>
    <tr>
        <td>№</td>
        <td>Название учреждения</td>
        <td>Адресс</td>
        <td>Почтовый индекс</td>
    </tr>
    </thead>
    <tbody>
    <?php $current = 1; ?>
    <?php foreach ($institutes as $instituete): ?>
        <tr>
            <td><?php echo $current++; ?></td>
            <td><?php echo $instituete->name ?></td>
            <td><?php echo $instituete->address ?></td>
            <td><?php echo $instituete->post_index ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>