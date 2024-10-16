<?php 


// Activation function
function growgoal_activation_function()
{
	// Your activation code here
	// For example, create database tables or set default options
	global $wpdb;
	$table_name = $wpdb->prefix . 'user_course_data';
	$sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        course_id mediumint(9) NOT NULL,
        user_id mediumint(9) NOT NULL,
        course_data text NOT NULL ,
        PRIMARY KEY  (id)
    );";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);
    $table_name = $wpdb->prefix . 'user_lesson_data';
	$sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT, 
        user_id mediumint(9) NOT NULL,
        lessson_data text NOT NULL ,
        PRIMARY KEY  (id)
    );";
    
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);

    // Table for teacher availability
    $table_name = $wpdb->prefix . 'teacher_availability';
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        teacher_id mediumint(9) NOT NULL,
        unavailable_from datetime NOT NULL,
        unavailable_to datetime NOT NULL,
        PRIMARY KEY (id)
    );";

require_once ABSPATH . 'wp-admin/includes/upgrade.php';
dbDelta($sql);
    // Table for teacher availability
    $table_name = $wpdb->prefix . 'teacher_availability_slots';
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        teacher_id mediumint(9) NOT NULL,
        unavailable_date datetime NOT NULL,
        time_slot time NOT NULL,
        PRIMARY KEY (id)
    );";

require_once ABSPATH . 'wp-admin/includes/upgrade.php';
dbDelta($sql);

    // Table for bookings
    $table_name = $wpdb->prefix . 'teacher_bookings';
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        teacher_id mediumint(9) NOT NULL,
        student_id mediumint(9) NOT NULL,
        booking_time datetime NOT NULL,
        booking_reason text NOT NULL,
        booking_type text NOT NULL,
        lesson_name text NOT NULL,
        status text NOT NULL,
        zoom text NOT NULL,
        record text NOT NULL,
        practice text NOT NULL,
        PRIMARY KEY (id)
    );";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

}

// Deactivation function
function growgoal_deactivation_function()
{
	// Your deactivation code here
	// For example, delete database tables or clean up options
}

// Add admin menu
add_action( 'admin_menu', 'tb_admin_menu' );

function tb_admin_menu() {
    add_menu_page( 'Teacher Availability', 'Teacher Availability', 'manage_options', 'teacher-availability', 'tb_admin_page' );
}

function tb_admin_page() {
    global $wpdb;
    $teachers = get_posts( array( 'post_type' => 'teacher', 'numberposts' => -1 ) );

    // Handle form submission
    if ( isset( $_POST['teacher_id'] ) && isset( $_POST['unavailable_from'] ) && isset( $_POST['unavailable_to'] ) ) {
        $teacher_id = intval( $_POST['teacher_id'] );
        $unavailable_from = sanitize_text_field( $_POST['unavailable_from'] );
        $unavailable_to = sanitize_text_field( $_POST['unavailable_to'] );

        $wpdb->insert(
            $wpdb->prefix . 'teacher_availability',
            array(
                'teacher_id' => $teacher_id,
                'unavailable_from' => $unavailable_from,
                'unavailable_to' => $unavailable_to
            )
        );

        echo '<div class="updated"><p>Availability updated.</p></div>';
    }

    ?>
    <div class="wrap">
        <h1>Set Teacher Unavailability</h1>
        <form method="post" action="">
            <label for="teacher_id">Teacher:</label>
            <select id="teacher_id" name="teacher_id">
                <?php foreach ( $teachers as $teacher ) : ?>
                    <option value="<?php echo $teacher->ID; ?>"><?php echo $teacher->post_title; ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <label for="unavailable_from">Unavailable From:</label>
            <input type="datetime-local" id="unavailable_from" name="unavailable_from">
            <br>
            <label for="unavailable_to">Unavailable To:</label>
            <input type="datetime-local" id="unavailable_to" name="unavailable_to">
            <br>
            <input type="submit" value="Submit">
        </form>
    </div>
    <?php
}





/*============================
 * Shortcode - Check 
 * ==========================*/ 


add_shortcode( 'teacher_booking', 'tb_booking_shortcode' );

function tb_booking_shortcode() {
    if ( ! is_user_logged_in() ) {
        return '<p>You need to be logged in to book a teacher.</p>';
    }

    global $wpdb;
    $teachers = get_posts( array( 'post_type' => 'teacher', 'numberposts' => -1 ) );

    // Handle booking form submission
    if ( isset( $_POST['teacher_id'] ) && isset( $_POST['booking_time'] ) ) {
        $teacher_id = intval( $_POST['teacher_id'] );
        $student_id = get_current_user_id();
        $booking_time = sanitize_text_field( $_POST['booking_time'] );

        // Check availability
        $unavailable = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}teacher_availability WHERE teacher_id = %d AND %s BETWEEN unavailable_from AND unavailable_to",
            $teacher_id, $booking_time
        ) );

        $booked = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}teacher_bookings WHERE teacher_id = %d AND booking_time = %s",
            $teacher_id, $booking_time
        ) );

        if ( $unavailable || $booked ) {
            echo '<p>Selected time slot is not available.</p>';
        } else {
            $wpdb->insert(
                $wpdb->prefix . 'teacher_bookings',
                array(
                    'teacher_id' => $teacher_id,
                    'student_id' => $student_id,
                    'booking_time' => $booking_time,
                    'booking_reason' => 'Booking'
                )
            );

            echo '<p>Booking successful.</p>';
        }
    }

    ?>
    <form method="post" action="">
        <label for="teacher_id">Teacher:</label>
        <select id="teacher_id" name="teacher_id">
            <?php foreach ( $teachers as $teacher ) : ?>
                <option value="<?php echo $teacher->ID; ?>"><?php echo $teacher->post_title; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="booking_time">Booking Time:</label>
        <input type="datetime-local" id="booking_time" name="booking_time">
        <br>
        <input type="submit" value="Book">
    </form>
    <?php
}

//Create Message Post type
function create_teacher_student_message_cpt() {
    $labels = array(
        'name'                  => _x('Messages', 'Post type general name', 'growgoal'),
        'singular_name'         => _x('Message', 'Post type singular name', 'growgoal'),
        'menu_name'             => _x('Messages', 'Admin Menu text', 'growgoal'),
        'name_admin_bar'        => _x('Message', 'Add New on Toolbar', 'growgoal'),
        'add_new'               => __('Add New', 'growgoal'),
        'add_new_item'          => __('Add New Message', 'growgoal'),
        'new_item'              => __('New Message', 'growgoal'),
        'edit_item'             => __('Edit Message', 'growgoal'),
        'view_item'             => __('View Message', 'growgoal'),
        'all_items'             => __('All Messages', 'growgoal'),
        'search_items'          => __('Search Messages', 'growgoal'),
        'not_found'             => __('No messages found.', 'growgoal'),
        'not_found_in_trash'    => __('No messages found in Trash.', 'growgoal'),
        'featured_image'        => _x('Message Image', 'Overrides the “Featured Image” phrase for this post type.', 'growgoal'),
        'set_featured_image'    => _x('Set message image', 'Overrides the “Set featured image” phrase for this post type.', 'growgoal'),
        'remove_featured_image' => _x('Remove message image', 'Overrides the “Remove featured image” phrase for this post type.', 'growgoal'),
        'use_featured_image'    => _x('Use as message image', 'Overrides the “Use as featured image” phrase for this post type.', 'growgoal'),
        'archives'              => _x('Message archives', 'The post type archive label used in nav menus. Default “Post Archives”.', 'growgoal'),
        'insert_into_item'      => _x('Insert into message', 'Overrides the “Insert into post” phrase (used when inserting media into a post).', 'growgoal'),
        'uploaded_to_this_item' => _x('Uploaded to this message', 'Overrides the “Uploaded to this post” phrase (used when viewing media attached to a post).', 'growgoal'),
        'filter_items_list'     => _x('Filter messages list', 'Screen reader text for the filter links heading on the post type listing screen.', 'growgoal'),
        'items_list_navigation' => _x('Messages list navigation', 'Screen reader text for the pagination heading on the post type listing screen.', 'growgoal'),
        'items_list'            => _x('Messages list', 'Screen reader text for the items list heading on the post type listing screen.', 'growgoal'),
    );



    $args = array(
        'labels'             => $labels,
        'public'             => false, // Hides it from the front end
        'publicly_queryable' => false, // Disables querying this post type from the front end
        'show_ui'            => true,  // Enables the UI for the post type
        'show_in_menu'       => true, // Hides it from the admin menu
        'query_var'          => true,
        'rewrite'            => array('slug' => 'message'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'author', 'custom-fields'),
    );

    register_post_type('message', $args);
}
add_action('init', 'create_teacher_student_message_cpt');

