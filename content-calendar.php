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
//print_r(WPAC_PLUGIN_DIR);

if( !function_exists( 'wp_plugin_scripts' ) )
{
    function wp_plugin_scripts()
    {
        //to include frontend css
        wp_enqueue_style('wp-css', WPAC_PLUGIN_DIR . 'assets/css/style.css');

        //to include javascript file
        wp_enqueue_script('wp-js', WPAC_PLUGIN_DIR . 'assets/js/main.js');

    }
  
}
add_action( 'admin_enqueue_scripts', 'wp_plugin_scripts' );

//setting the menu option
require plugin_dir_path(__FILE__).'include/setting.php';

//adding form for calendar into the page
require plugin_dir_path(__FILE__).'include/form.php';

//connecting to the database and table creation
require plugin_dir_path(__FILE__).'include/db.php';
