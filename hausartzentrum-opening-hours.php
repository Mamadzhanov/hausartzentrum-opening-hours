<?php
/**
 * Plugin Name: AMHA Hausarztzentrum Opening Hours
 * Description: Ein einfaches WordPress-Plugin zur Verwaltung von Öffnungszeiten für ein Hausarztzentrum.
 * Version: 1.0
 * Author: Bobur Mamadzhanov - Ameisenhaufen GmbH
 */

// Register a custom admin page for opening time settings
function hz_opening_time_register_settings_page()
{
    add_submenu_page('options-general.php', 'Einstellungen der Öffnungszeit', 'Öffnungszeit', 'manage_options', 'opening-time-settings', 'hz_opening_time_render_settings_page');
}
add_action('admin_menu', 'hz_opening_time_register_settings_page');

// Render opening time settings page in the admin panel
function hz_opening_time_render_settings_page()
{
    require_once(plugin_dir_path(__FILE__) . 'settings-page.php');
}

// Enqueue admin scripts and styles
function hz_opening_time_enqueue_admin_scripts($hook)
{
    if ('settings_page_opening-time-settings' !== $hook) {
        return;
    }
    wp_enqueue_style('hz_opening_time_admin_styles', plugin_dir_url(__FILE__) . 'css/admin.css');
    wp_enqueue_script('hz_opening_time_admin_script', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), false, true);
}
add_action('admin_enqueue_scripts', 'hz_opening_time_enqueue_admin_scripts');

// Register and handle opening time settings
function hz_opening_time_register_settings()
{
    register_setting('hz_opening_time_settings_group', 'hz_opening_time_settings', 'hz_opening_time_sanitize_settings');
}
add_action('admin_init', 'hz_opening_time_register_settings');

function hz_opening_time_sanitize_settings($input)
{
    // Sanitize and validate input data here
    return $input;
}

// Add shortcodes
function hz_opening_time_shortcode()
{
    return "<div class='openingtime'>" . hz_get_opening_hours_string() . "</div>";
}
add_shortcode('openingtime', 'hz_opening_time_shortcode');

function hz_opening_time_now_shortcode()
{
    return hz_get_opening_status_string();
}
add_shortcode('openingtime_now', 'hz_opening_time_now_shortcode');

// Include helper functions for generating opening hours and status strings
require_once(plugin_dir_path(__FILE__) . 'helpers.php');
?>