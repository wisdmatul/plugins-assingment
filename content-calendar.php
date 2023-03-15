<?php

/*
* Plugin Name: Content Calendar
* Plugin URI : https://wpcontentcalendar.com
* Author: WordPress
* Author URI: https://wpcontentcalendar.com
* Description: a simple conent calendar for the events.
* version: 1.0.0
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: wpalike
*/

//if this file called directly, abort
if( !defined( 'WPINC' ) )
{
    die;
}

if( !defined( 'WPAC_PLUGIN_VERSION' ) )
{
    define( 'WPAC_PLUGIN_VERSION', '1.0.0' );
}

if( !defined( 'WPAC_PLUGIN_DIR' ) )
{
    define( 'WPAC_PLUGIN_DIR', plugin_dir_url(__FILE__) );
}

if( !function_exists( 'wpac_plugin_scripts' ) )
{
    function wpac_plugin_scripts()
    {
        //to include frontend css
        wp_enqueue_style('wpac-css', WPAC_PLUGIN_DIR . 'assets/css/style.css');

        //to include javascript file
        wp_enqueue_script('wpac-js', WPAC_PLUGIN_DIR . 'assets/js/main.js');

    }
    add_action( 'wp_enqueue_scripts', 'wpac_plugin_scripts' );
}
