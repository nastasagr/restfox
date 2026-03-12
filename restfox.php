<?php
/*
Plugin Name: RestFox
Description: Adds custom REST API endpoints that allow secure remote management of WordPress sites, enabling external applications or services to interact with WordPress data, automate tasks, and control site functionality programmatically.
Author: Alexander Anastasiadis
Author URI: https://nastasa.gr
Version: 1.0.0

*/

if (!defined('ABSPATH')) {
    exit;
}

define('RESTFOX_BASENAME', plugin_basename(__FILE__));

require_once __DIR__.'/initializer.php';
require_once __DIR__.'/core/API.php';

/*
 *  Add CSS for plugin settings page
 */

add_action('admin_enqueue_scripts', function ($hook) {
    if (strpos($hook, 'restfox-settings') === false) {
        return;
    }

    wp_enqueue_style(
        'restfox-css-admin',
        plugin_dir_url(__FILE__).'assets/css/admin.css',
        [],
        filemtime(plugin_dir_path(__FILE__).'assets/css/admin.css'),
    );
});

if (!function_exists('get_plugin_data')) {
    require_once ABSPATH.'wp-admin/includes/plugin.php';
}

/**
 * Returns a value from the plugin header metadata.
 * Retrieves plugin information (such as Version, Author, AuthorURI, etc.)
 * from the plugin file headers using get_plugin_data().
 */
function plugin_info(string $key)
{
    if (!function_exists('get_plugin_data')) {
        require_once ABSPATH.'wp-admin/includes/plugin.php';
    }

    static $data = null;

    if ($data === null) {
        $data = get_plugin_data(__FILE__);
    }

    return $data[$key] ?? null;
}

/**
 *  Return BASEURL.
 */
function restfox_baseurl(string $res)
{
    return site_url().'/wp-json/restfox/v1'.$res;
}
