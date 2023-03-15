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

if( !function_exists( 'wp_plugin_scripts' ) )
{
    function wpac_plugin_scripts()
    {
        //to include frontend css
        wp_enqueue_style('wp-css', WPAC_PLUGIN_DIR . 'assets/css/style.css');

        //to include javascript file
        wp_enqueue_script('wp-js', WPAC_PLUGIN_DIR . 'assets/js/main.js');

    }
    add_action( 'wp_enqueue_scripts', 'wp_plugin_scripts' );
}

//setting the menu option
require plugin_dir_path(__FILE__).'include/setting.php';

//adding form for calendar into the page
function form_page()
{
    ?>
    <div class = "form-container">
        <form method="post" class = "content-form">
        <div>
            <label for="date">Date</label>
            <input type="date" name="date" id="date" required><br>
        </div>
        <div>
            <label for="occasion">Occassion</label>
            <input type="text" name="occassion" id="occasion"><br>
        </div>
        <div>
            <label for="post_title">Post Title</label>
            <input type="text" name="post_title" id="post_title"><br>
        </div>
        <div>
            <label for="author">Author</label>
            <select name="author" id="author" rquired>
                <?php
                    $users =  get_users(array(
                        'fields' =>array('ID', 'display_name')
                    ));
                    foreach($users as $user)
                    {
                        echo '<option value=">'. $user->ID. '">'. $user->display_name . '</option>';
                    }
                ?>
            </select> <br>   
        </div>
        <div>
            <label for="reviewer">Reviewer</label>
            <select name="reviewer" id="reviewer" required>
                <?php
                    $admins =  get_users(array(
                        'role' => 'administrator',
                        'fields' =>array('ID', 'display_name')
                    ));
                    foreach($admins as $admin)
                    {
                        echo '<option value=">'. $admin->ID. '">'. $admin->display_name . '</option>';
                    }
                ?>
            </select>
        </div>
        <div class="btn">
            <?php submit_button('Schedule Post');  ?>
        </div>
        </form>
    </div>
    <?php
}

function calendar_callback()
{
    form_page();
}