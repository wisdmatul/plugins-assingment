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
require plugin_dir_path(__FILE__).'include/form.php';

//connecting to the database and table creation
function create_event_tables() {
    global $wpdb;

    $table_name = $wpdb->prefix . "events";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name(
        id mediumint(9) AUTO_INCREMENT,
        date date NOT NULL,
        occassion text,
        post_title text NOT NULL,
        author varchar(40) NOT NULL,
        reviewer varchar(40) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

register_activation_hook( __FILE__, 'create_event_tables' );

//form submission

function form_submition()
{
    global $wpdb;

    if(isset($_POST['date']) && isset($_POST['occasion']) && isset($_POST['post_title']) && isset($_POST['author']) && isset($_POST['reviewer']))
    {
        $table_name = $wpdb->prefix . "events";
        $date = sanitize_text_field( $_POST['date'] );
        $occassion = sanitize_text_field( $_POST['occassion'] );
        $post_title = sanitize_text_field( $_POST['post_title'] );
        $author = sanitize_text_field( $_POST['author'] );
        $reviewer = sanitize_text_field( $_POST['reviewer'] );

        $wpdb->insert(
            $table_name,
            array(
                'date'       => $date,
                'occassion'  => $occassion,
                'post_title' => $post_title,
                'author'     => $author,
                'reviewer'   => $reviewer
            )
        );
    }
}

add_action('init', 'btn_submit');

function btn_submit()
{
    if(isset( $_POST['submit'] ))
    {
        form_submition();
    }
}


function schedule()
{
    ?>
    <h1 class = "table-title">Upcoming Events</h1>
    <?php

    global $wpdb;

    $table_name = $wpdb->prefix.'events';
    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE date >= DATE(NOW()) ORDER BY date");

    echo '<table id="upcoming-table">';
    echo '<thead><tr><th>ID</th><th>Date</th><th>Occasion</th><th>Post Title</th><th>Author</th><th>Reviewer</th></tr></thead>';

    foreach($results as $row)
    {
        echo '<tr>';
        echo '<td>'. $row->id . '</td>';
        echo '<td>' . $row->date . '</td>';
        echo '<td>' . $row->occasion . '</td>';
        echo '<td>' . $row->post_title . '</td>';
        echo '<td>' . get_userdata($row->author)->user_login . '</td>';
        echo '<td>' . get_userdata($row->reviewer)->user_login . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}

?>

<><>


