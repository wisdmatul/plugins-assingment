<?php

function wp_register_menu_page()
{
    add_menu_page(
        'WP Content calendar',
        'Content calendar',
         'manage_options',
          'content-calendar',
           'calendar_callback',
            'dashicons-calendar',
             5 );
    

}
add_action('admin_menu', 'wp_register_menu_page');

function wp_setting_page_html()
{
    if(!is_admin())
    {
        return ;
    }

    ?>
        <div class = "wrap">
            <h1><?= esc_html(get_admin_page_title()); ?></h1>
        </div>
    <?php
}