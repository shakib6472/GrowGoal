<?php /*
 * Plugin Name:       User dashboard
 * Description:       This is the boikotha websites Custom Plugin. All features are came from here.
 * Version:           1.0.2
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shakib Shown
 * Author URI:        https://facebook.com/shakib6472/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       user-dashboard
 * Domain Path:       /languages
 */



 

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once(__DIR__ . '/head.php');
require_once(__DIR__ . '/t-head.php');



function growgoal_enqueue_scripts_2() {
    // Enqueue external styles
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css', array(), '6.6.0', 'all');
    wp_enqueue_style('google-font-podkova', 'https://fonts.googleapis.com/css2?family=Podkova:wght@400..800&display=swap', array(), null, 'all');
    wp_enqueue_style('google-font-jost', 'https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap', array(), null, 'all');
    // Enqueue plugin styles
    wp_enqueue_style('growgoal-style', plugins_url('asset/style.css', __FILE__), array(), '1.0', 'all');
    wp_enqueue_style('bootstrap-grid', plugins_url('dashboard/css/bootstrap-grid.css', __FILE__), array(), '1.0', 'all');
    wp_enqueue_style('all-user-dashboard', plugins_url('dashboard/css/all.css', __FILE__), array(), '1.0', 'all');
    wp_enqueue_style('v4-shims-min', plugins_url('dashboard/css/v4-shims.min.css', __FILE__), array(), '1.0', 'all');
    wp_enqueue_style('simple-line-icons', plugins_url('dashboard/css/simple-line-icons.css', __FILE__), array(), '1.0', 'all');
    wp_enqueue_style('main-dashboard-css', plugins_url('dashboard/css/style.css', __FILE__), array(), '1.0', 'all');
    wp_enqueue_style('main-select-css', plugins_url('dashboard/css/select2.css', __FILE__), array(), '1.0', 'all');
    // Enqueue external script
    wp_enqueue_script('font-awesome-kit', 'https://kit.fontawesome.com/46882cce5e.js', array(), null, true);
    // Enqueue plugin scripts
    wp_enqueue_script('growgoal-script', plugins_url('asset/script.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('bootstrap-select.min', plugins_url('dashboard/js/bootstrap-select.min.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('user-dash-counterup.min', plugins_url('dashboard/js/counterup.min.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('user-dash-datedropper', plugins_url('dashboard/js/datedropper.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('user-dash-dropzone', plugins_url('dashboard/js/dropzone.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('user-dash-jquery.scrollto', plugins_url('dashboard/js/jquery.scrollto.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('user-dash-magnific-popup-min', plugins_url('dashboard/js/magnific-popup.min.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('user-dash-moment-min', plugins_url('dashboard/js/moment.min.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('user-dash-rangeslider-min', plugins_url('dashboard/js/rangeslider.min.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('user-dash-select2-min', plugins_url('dashboard/js/select2.min.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('user-dash-slick-min', plugins_url('dashboard/js/slick.min.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('user-dash-timedropper', plugins_url('dashboard/js/timedropper.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('user-dash-tooltips-min', plugins_url('dashboard/js/tooltips.min.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('user-dash-waypoints-min', plugins_url('dashboard/js/waypoints.min.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('user-dash-custom-js', plugins_url('dashboard/js/custom.js', __FILE__), array('jquery'), '1.0', true);

    // Enqueue the media uploader script
    wp_enqueue_media();

    // Localize script for AJAX handling
    wp_localize_script('growgoal-script', 'growgoalAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'growgoal_enqueue_scripts_2');



function elementor_user_dashbaord_widgets($widgets_manager)
{
    //require_once(__DIR__ . '/dashboard/dashboard.php');
    require_once(__DIR__ . '/dashboard/main-dashboard.php');
    require_once(__DIR__ . '/dashboard/teacher-dashboard.php');
    //$widgets_manager->register(new \Elementor_tiny_tutor_dashboard_elementor());
    $widgets_manager->register(new \Elementor_tiny_tutor_main_dashboard_elementor());
    $widgets_manager->register(new \Elementor_tiny_tutor_teacher_dashboard_elementor());
}
add_action('elementor/widgets/register', 'elementor_user_dashbaord_widgets');


// Activation Hook
register_activation_hook(__FILE__, 'tiny_schoolars_activation_function');

// Deactivation Hook
register_deactivation_hook(__FILE__, 'tiny_schoolars_deactivation_function');

// Activation function
function tiny_schoolars_activation_function() {
    // Your activation code here
}

// Deactivation function
function tiny_schoolars_deactivation_function() {
    // Your deactivation code here
    // For example, delete database tables or clean up options
}



// Functions
//get teacher Name From Id 

function get_teacher_name_from_id ($post_id) {
$post = get_post($post_id);
if ($post) {
    return $post->post_title;
} else {
    return 'No Teacher Found';
}
}