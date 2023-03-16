<?php

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
                        echo '<option value="'. $user->ID. '">'. $user->display_name . '</option>';
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
                        echo '<option value="'. $admin->ID. '">'. $admin->display_name . '</option>';
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
    ?>

    <h1 class="plugin-title"><?php esc_html_e(get_admin_page_title()); ?></h1>
    <?php
    form_page();
    cal_schedule();    
}