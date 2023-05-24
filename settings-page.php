<?php
// Prevent direct access to the file
defined('ABSPATH') or die('No script kiddies, please!');
?>
<div class="wrap">
    <h1>
        <?php _e('Einstellungen der Öffnungszeit', 'hz-opening-time'); ?>
    </h1>
    <form method="post" action="options.php">
        <?php settings_fields('hz_opening_time_settings_group'); ?>
        <?php do_settings_sections('hz_opening_time_settings_group'); ?>
        <?php require_once(plugin_dir_path(__FILE__) . 'settings-fields.php'); ?>
        <?php submit_button(); ?>
    </form>
</div>