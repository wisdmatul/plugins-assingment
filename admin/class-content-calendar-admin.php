<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://atul.com
 * @since      1.0.0
 *
 * @package    Content_Calendar
 * @subpackage Content_Calendar/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Content_Calendar
 * @subpackage Content_Calendar/admin
 * @author     atul.com/atul-plugin <atul@atul.com>
 */
class Content_Calendar_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Content_Calendar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Content_Calendar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/content-calendar-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Content_Calendar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Content_Calendar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/content-calendar-admin.js', array('jquery'), $this->version, false);
	}
	public function wp_register_menu_page()
	{
		add_menu_page(
			'WP Content calendar',
			'Content calendar',
			'manage_options',
			'content-calendar',
			array($this,'calendar_callback'),
			'dashicons-calendar',
			5
		);
	}

	public function calendar_callback()
	{
?>

		<h1 class="plugin-title"><?php esc_html_e(get_admin_page_title()); ?></h1>
	<?php
		$this->form_page();
		$this->cal_schedule();
	}

	public function form_page()
	{
	?>
		<div class="form-container">
			<form method="post" class="content-form">
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
							'fields' => array('ID', 'display_name')
						));
						foreach ($users as $user) {
							echo '<option value="' . $user->ID . '">' . $user->display_name . '</option>';
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
							'fields' => array('ID', 'display_name')
						));
						foreach ($admins as $admin) {
							echo '<option value="' . $admin->ID . '">' . $admin->display_name . '</option>';
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
		if(isset( $_POST['submit'] ))
    {
        $this->form_submition();
    }

	}

	public function cal_schedule()
	{
	?>
		<h1 class="table-title">Upcoming Events</h1>
		<?php

		global $wpdb;

		$table_name = $wpdb->prefix . 'events';
		$results = $wpdb->get_results("SELECT * FROM $table_name WHERE date >= DATE(NOW()) ORDER BY date");

		echo '<table id="upcoming-table">';
		echo '<thead><tr><th>ID</th><th>Date</th><th>Occasion</th><th>Post Title</th><th>Author</th><th>Reviewer</th></tr></thead>';

		foreach ($results as $row) {
			echo '<tr>';
			echo '<td>' . $row->id . '</td>';
			echo '<td>' . $row->date . '</td>';
			echo '<td>' . $row->occassion . '</td>';
			echo '<td>' . $row->post_title . '</td>';
			echo '<td>' . get_userdata($row->author)->user_login . '</td>';
			echo '<td>' . get_userdata($row->reviewer)->user_login . '</td>';
			echo '</tr>';
		}

		echo '</table>';

		?>

		<h1 class="table-title">Closed Events</h1>

<?php

		global $wpdb;
		$table_name = $wpdb->prefix . 'events';

		$data = $wpdb->get_results("SELECT * FROM $table_name WHERE date < DATE(NOW()) ORDER BY date DESC");

		echo '<table id="upcoming-table">';
		echo '<thead><tr><th>ID</th><th>Date</th><th>Occasion</th><th>Post Title</th><th>Author</th><th>Reviewer</th></tr></thead>';

		foreach ($data as $row) {
			echo '<tr>';
			echo '<td>' . $row->id . '</td>';
			echo '<td>' . $row->date . '</td>';
			echo '<td>' . $row->occassion . '</td>';
			echo '<td>' . $row->post_title . '</td>';
			echo '<td>' . (get_userdata($row->author) ? get_userdata($row->author)->user_login : 'N/A') . '</td>';
			echo '<td>' . (get_userdata($row->reviewer) ? get_userdata($row->reviewer)->user_login : 'N/A') . '</td>';
			echo '</tr>';
		}

		echo '</table>';
	}

	public function form_submition()
	{
			global $wpdb;

			if (isset($_POST['date']) && isset($_POST['occassion']) && isset($_POST['post_title']) && isset($_POST['author']) && isset($_POST['reviewer'])) {
				$table_name = $wpdb->prefix . "events";
				$date = sanitize_text_field($_POST['date']);
				$occassion = sanitize_text_field($_POST['occassion']);
				$post_title = sanitize_text_field($_POST['post_title']);
				$author = sanitize_text_field($_POST['author']);
				$reviewer = sanitize_text_field($_POST['reviewer']);

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
}
