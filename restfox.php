<?php
/*
Plugin Name: RestFox
Description: Provides custom REST API endpoints for remote WordPress management.
Author: Alexander Anastasiadis
Author URI: https://alexanast.gr
Version: 1.0.0

*/

if (! defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/core/API.php';



/** 
 *  Add CSS for plugin settings page 
 */

add_action('admin_enqueue_scripts', function ($hook) {

    if (strpos($hook, 'restfox-settings') === false) {
        return;
    }

    wp_enqueue_style(
        'restfox-css-admin',
        plugin_dir_url(__FILE__) . 'assets/css/admin.css',
        [],
        filemtime(plugin_dir_path(__FILE__) . 'assets/css/admin.css'),
       
    );

});



if ( ! function_exists( 'get_plugin_data' ) ) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}


/**
 * Returns a value from the plugin header metadata.
 * Retrieves plugin information (such as Version, Author, AuthorURI, etc.)
 * from the plugin file headers using get_plugin_data().
 */

function plugin_info( string $key ) {
    if ( ! function_exists( 'get_plugin_data' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    static $data = null;

    if ( $data === null ) {
        $data = get_plugin_data( __FILE__ );
    }

    return $data[ $key ] ?? null;
}


/**
 *  Return BASEURL
 */

function restfox_baseurl(string $res) {
    return site_url().'/wp-json/restfox/v1'.$res;
}