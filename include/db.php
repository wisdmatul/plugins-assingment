<?php


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

    if(isset($_POST['date']) && isset($_POST['occassion']) && isset($_POST['post_title']) && isset($_POST['author']) && isset($_POST['reviewer']))
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


function cal_schedule()
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
        echo '<td>' . $row->occassion . '</td>';
        echo '<td>' . $row->post_title . '</td>';
        echo '<td>' . get_userdata($row->author)->user_login . '</td>';
		echo '<td>' . get_userdata($row->reviewer)->user_login . '</td>';
        echo '</tr>';
    }

    echo '</table>';

    ?>

    <h1 class = "table-title">Closed Events</h1>

    <?php

    global $wpdb;
    $table_name = $wpdb->prefix . 'events';

    $data = $wpdb->get_results("SELECT * FROM $table_name WHERE date < DATE(NOW()) ORDER BY date DESC");

    echo '<table id="upcoming-table">';
    echo '<thead><tr><th>ID</th><th>Date</th><th>Occasion</th><th>Post Title</th><th>Author</th><th>Reviewer</th></tr></thead>';

    foreach($data as $row)
    {
        echo '<tr>';
        echo '<td>'. $row->id . '</td>';
        echo '<td>' . $row->date . '</td>';
        echo '<td>' . $row->occassion . '</td>';
        echo '<td>' . $row->post_title . '</td>';
        echo '<td>' . (get_userdata($row->author) ? get_userdata($row->author)->user_login : 'N/A') . '</td>';
        echo '<td>' . (get_userdata($row->reviewer) ? get_userdata($row->reviewer)->user_login : 'N/A') . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}   
