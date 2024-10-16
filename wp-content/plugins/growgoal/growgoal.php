<?php /*
 * Plugin Name:       growgoal Core
 * Plugin URI:        https://facebook.com/shakib6472/
 * Description:       This is the growgoal websites Custom Plugin. All features are came from here.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shakib Shown
 * Author URI:        https://facebook.com/shakib6472/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       growgoal
 * Domain Path:       /languages
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
//requir Files

$plugin_url = plugin_dir_path(__FILE__);
require_once(__DIR__ . '/functions/activate.php');
require_once(__DIR__ . '/functions/ajax.php');
require_once(__DIR__ . '/functions/functions.php');
//require_once(__DIR__ . '/functions/wc_functions.php');
function growgoal_enqueue_scripts()
{
	// CSS
	wp_enqueue_style('growgoal-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
	wp_enqueue_style('growgoal-toast-style', plugin_dir_url(__FILE__) . 'assets/css/jquery.toast.css');
	wp_enqueue_style('growgoal-bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
	wp_enqueue_style('flatpickr-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
	wp_enqueue_style('growgoal-toast-style', plugin_dir_url(__FILE__) . 'assets/css/jquery.toast.css');

	// JS
	wp_enqueue_script('jquery');
	wp_enqueue_script('flatpickr-js', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js', array('jquery'), '4.6.9', true);
	wp_enqueue_script('spectrum-colorpicker', 'https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js', array('jquery'), '1.8.0', true);
	wp_enqueue_script('growgoal-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
	wp_enqueue_script('growgoal-toast-script', plugin_dir_url(__FILE__) . 'assets/js/jquery.toast.js', array('jquery'), null, true);

	// Localize the script with new data
	wp_localize_script('growgoal-script', 'ajax_object', array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'home_url' => home_url(''),
		// Add other variables you want to pass to your script here
	));
}
add_action('wp_enqueue_scripts', 'growgoal_enqueue_scripts');



// Enqueue Spectrum Colorpicker script and styles
function growgoal_admin_enqueue_scripts()
{
	wp_enqueue_style('growgoal-admin-style', plugin_dir_url(__FILE__) . '/assets/admin/css/style.css');
	wp_enqueue_script('growgoal-admin-style', plugin_dir_url(__FILE__) . '/assets/admin/js/script.js');
}
add_action('admin_enqueue_scripts', 'growgoal_admin_enqueue_scripts');




//Elementor Setup
function elementor_ctds_widgets($widgets_manager)
{

	require_once(__DIR__ . '/elementor/teacher-loop.php');


	$widgets_manager->register(new \Elementor_teacher_loop());
}
add_action('elementor/widgets/register', 'elementor_ctds_widgets');









// Activation Hook
register_activation_hook(__FILE__, 'growgoal_activation_function');

// Deactivation Hook
register_deactivation_hook(__FILE__, 'growgoal_deactivation_function');



global $wpdb;

$table_name = $wpdb->prefix . 'teacher_bookings';

// Check if the column does not already exist
$column_exists = $wpdb->get_results(
    $wpdb->prepare(
        "SHOW COLUMNS FROM $table_name LIKE %s",
        'lesson_name'
    )
);

if (empty($column_exists)) {
    // Add the new column
    $wpdb->query(
        "ALTER TABLE $table_name 
        ADD lesson_name text NOT NULL"
    );
}


//Check Class Past or upcoming 
function check_time_status($time) {
    // Convert the time string to a DateTime object
    $date = new DateTime($time);
    // Get the current date and time
    $now = new DateTime();

    // Compare the given time with the current date and time
    if ($date < $now) {
        return 'Done';
    } else {
        return 'upcoming';
    }
}
