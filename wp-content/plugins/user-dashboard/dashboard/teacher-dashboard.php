<?php
class Elementor_tiny_tutor_teacher_dashboard_elementor extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'teacher-dashboard';
    }

    public function get_title()
    {
        return esc_html__('Teacher Dashboard', 'boikotha');
    }

    public function get_icon()
    {
        return 'fab fa-accusoft';
    }
    protected function _register_controls()
    {

        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Dashboard Items', 'grow-goal'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'dashboard-item',
            [
                'label' => esc_html__('Dashboard Item', 'grow-goal'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'dashboard',
                'options' => [
                    'profile' => esc_html__('My Profile', 'grow-goal'),
                    't-schedule' => esc_html__('Schedules', 'grow-goal'),
                    't-lesson' => esc_html__('Lesson', 'grow-goal'),
                    't-students' => esc_html__('List of Students', 'grow-goal'),
                    't-messages' => esc_html__('Messages', 'grow-goal'),
                    't-assignments' => esc_html__('Assignments', 'grow-goal'),
                    'feedback' => esc_html__('Feedback', 'grow-goal'),
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function get_categories()
    {
        return ['basic'];
    }

    public function get_keywords()
    {
        return ['dash', 'Dashboard'];
    }

    protected function render()
    {

        $settings = $this->get_settings();
        // Now you can create an instance of the Left_menu class
        $value = $settings['dashboard-item']; // Pass the value you want to check against
        // Pagination.
        if (is_user_logged_in()) {
            // echo 'Logged in';
            
            require_once(__DIR__ . '/parts/' . $value . '.php');

            //get this members membership level (from paid membership pro) & echo membership id
            // Get the current user's membership level
           
        } else {
            // Redirect or show login form if not logged in

            //wp_redirect(home_url('/login'));
            echo '<script type="text/javascript">window.location.href = "' . home_url('/login') . '";</script>';
            //exit;
        }

?>

        <script type="text/javascript" src="https://theliverpoolnetwork.com/wp-includes/js/jquery/jquery.min.js?ver=3.7.1" id="jquery-core-js"></script>
        <script type="text/javascript" src="https://theliverpoolnetwork.com/wp-includes/js/jquery/jquery-migrate.min.js?ver=3.4.1" id="jquery-migrate-js"></script>
        <script type="text/javascript" id="WCPAY_ASSETS-js-extra">
            /* <![CDATA[ */
            var wcpayAssets = {
                "url": "https:\/\/theliverpoolnetwork.com\/wp-content\/plugins\/woocommerce-payments\/dist\/"
            };
            /* ]]> */
        </script>

        <script type="text/javascript" id="listeo-custom-js-extra">
            /* <![CDATA[ */
            var wordpress_date_format = {
                "date": "MM\/DD\/YYYY",
                "day": "1",
                "raw": "F j, Y",
                "time": "g:i a"
            };
            var listeo = {
                "ajaxurl": "\/wp-admin\/admin-ajax.php",
                "theme_url": "https:\/\/theliverpoolnetwork.com\/wp-content\/themes\/listeo",
                "menu_back": "Back"
            };
            /* ]]> */
        </script>

<?php


    }
}
