<?php

function wpac_register_menu_page()
{
    add_menu_page(
        'WP Content calendar',
        'Content calendar',
         'manage_options',
          'wpac-settings',
           'wpac_setting_page_html',
            'dashicons-calendar',
             5 );
    

}
add_action('admin_menu', 'wpac_register_menu_page');