<?php

function get_all_available_slots_for_this_day()
{
    $date = $_POST['date']; // Format: Mon, 15 Jul
    $datadate = $_POST['datadate']; // Format: 2024-07-15
    $teacher_id = $_POST['teacherid']; // Format: 2024-07-15
    global $wpdb;
    // Example teacher ID for demonstration
    // Generate all time slots for the day (from 9:00 AM to 9:00 PM)
    $start_time = strtotime($datadate . ' 09:00:00');
    $end_time = strtotime($datadate . ' 21:00:00');

    $time_slots = array();
    for ($time = $start_time; $time <= $end_time; $time = strtotime('+45 minutes', $time)) {
        $booking_time = date('Y-m-d H:i:s', $time);
        error_log($booking_time);
        $table_name = $wpdb->prefix . 'teacher_bookings';
        $query = $wpdb->prepare(
            "SELECT * FROM $table_name WHERE teacher_id = %d AND booking_time = %s",
            $teacher_id,
            $booking_time
        );

        $row = $wpdb->get_row($query);
        if ($row) {
            error_log('The Slot is already Booked');
            //error_log ($row);
        } else {
            // No row found
            $time_slots[] = date('h:i A', $time);
        }
    }
    wp_send_json($time_slots);
    //wp_send_json($available_slots);
}

add_action('wp_ajax_get_all_available_slots_for_this_day', 'get_all_available_slots_for_this_day');
add_action('wp_ajax_nopriv_get_all_available_slots_for_this_day', 'get_all_available_slots_for_this_day');


function add_new_booking_from_student()
{
    // Get POST data
    $teacherId = $_POST['teacherId'];
    $bookedDate = $_POST['bookedDate']; // Example Format: Tue, 16 Jul
    $bookedTime = $_POST['bookedTime']; // Example Format: 12:00 PM
    $lessontype = $_POST['lessontype']; // Type of lesson
    $lessonName = $_POST['lessonName']; // Name of lesson

    // Log incoming values for debugging
    error_log('bookedDate: ' . $bookedDate);
    error_log('bookedTime: ' . $bookedTime);

    // Ensure date includes the current year
    $currentYear = date('Y');
    $dateString = $bookedDate . ' ' . $currentYear . ' ' . $bookedTime;
    $date = strtotime($dateString);
    if ($date === false) {
        wp_send_json_error('Invalid date format');
        return;
    }

    // Convert timestamp to MySQL datetime format
    $booking_time = date('Y-m-d H:i:s', $date);
    error_log('Formatted booking_time: ' . $booking_time); // Log formatted booking_time for debugging
    // Get current user ID
    $student_id = get_current_user_id();

    // Insert data into database
    global $wpdb;
    $inserting = $wpdb->insert(
        $wpdb->prefix . 'teacher_bookings',
        array(
            'teacher_id' => $teacherId,
            'student_id' => $student_id,
            'booking_time' => $booking_time,
            'booking_reason' => 'Booking',
            'booking_type' => $lessontype,
        )
    );

    // Check if insertion was successful
    if ($inserting) {
        wp_send_json_success('Data successfully inserted');
    } else {
        wp_send_json_error('Data not inserted');
    }
}
add_action('wp_ajax_add_new_booking_from_student', 'add_new_booking_from_student');
add_action('wp_ajax_nopriv_add_new_booking_from_student', 'add_new_booking_from_student');



function check_available_class_for_students()
{
    // Get POST data
    $user_id = get_current_user_id();

    // Log incoming values for debugging
    error_log('UserID: ' . $user_id);

    $class_left = get_user_meta($user_id, 'how_many_classs_you_have', true);

    // Check if insertion was successful
    wp_send_json($class_left);
}
add_action('wp_ajax_check_available_class_for_students', 'check_available_class_for_students');
add_action('wp_ajax_nopriv_check_available_class_for_students', 'check_available_class_for_students');



function send_message_student()
{
    // Check if the necessary data is set
    if (isset($_POST['studentid'], $_POST['message'])) {
        $sender_id  = get_current_user_id();
        $receiver_id = intval($_POST['studentid']);
        $message = sanitize_text_field($_POST['message']);

        // Validate the data
        if ($receiver_id > 0 && !empty($message)) {
            // Create a new message post
            $message_id = wp_insert_post(array(
                'post_type'   => 'message',
                'post_title'  => 'Message from ' . get_userdata($sender_id)->display_name,
                'post_content' => $message,
                'post_status' => 'publish',
                'meta_input'  => array(
                    'sender_id'  => $sender_id,
                    'receiver_id' => $receiver_id,
                    'is_read'    => 0, // Default to unread
                ),
            ));

            // Check if the message was created successfully
            if ($message_id) {
                // Send an email to the receiver
                $receiver_email = get_userdata($receiver_id)->user_email;
                $subject = 'You have a new message from ' . get_userdata($sender_id)->display_name;
                $body = 'You have received a new message: ' . $message;
                $headers = array('Content-Type: text/html; charset=UTF-8');
                wp_mail($receiver_email, $subject, $body, $headers);
                wp_send_json_success('Message sent successfully.');
            } else {
                wp_send_json_error('Failed to send message.');
            }
        } else {
            wp_send_json_error('Invalid input.');
        }
    } else {
        wp_send_json_error('Missing required fields.');
    }
}
add_action('wp_ajax_send_message_student', 'send_message_student');
add_action('wp_ajax_nopriv_send_message_student', 'send_message_student');


function send_reply_message()
{
    $sender_id = get_current_user_id();
    $receiver_id = isset($_POST['receiver_id']) ? intval($_POST['receiver_id']) : 0;
    $message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';
 error_log('Sender id: '. $sender_id);
 error_log('R id: '. $receiver_id);
 error_log('Message: '. $message);
    if ($receiver_id <= 0 || empty($message)) {
        wp_send_json_error('Invalid data.');
        return;
    }

    // Create a new message post
    $message_id = wp_insert_post(array(
        'post_type'   => 'message',
        'post_title'  => 'Reply from ' . get_userdata($sender_id)->display_name . ' to ' . get_userdata($receiver_id)->display_name ,
        'post_content' => $message,
        'post_status' => 'publish',
        'meta_input'  => array(
            'sender_id'  => $sender_id,
            'receiver_id' => $receiver_id,
            'is_read'    => 0, // Default to unread
            'is_notified'    => 0, // Default to unnotified
        ),
    ));

    if ($message_id) {
        wp_send_json_success('Message sent successfully.');
    } else {
        wp_send_json_error('Failed to send message.');
    }
}
add_action('wp_ajax_send_reply_message', 'send_reply_message');
add_action('wp_ajax_nopriv_send_reply_message', 'send_reply_message');


function upload_user_profile_picture() {
    // Start debugging: Log that the function has been called
    error_log('upload_user_profile_picture function called');

    // Check if a file has been uploaded
    if (isset($_FILES['profile_upload'])) {
        error_log('File upload detected: ' . print_r($_FILES['profile_upload'], true)); // Log the file array details

        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }

        // Upload file and handle errors
        $uploaded_file = $_FILES['profile_upload'];
        $upload_overrides = array('test_form' => false); // Don't test for form submission
        $movefile = wp_handle_upload($uploaded_file, $upload_overrides);

        // Check if the file was successfully uploaded
        if ($movefile && !isset($movefile['error'])) {
            // Get the URL of the uploaded file
            $file_url = $movefile['url'];
            error_log('File uploaded successfully: ' . $file_url); // Log the uploaded file URL

            $user_id = get_current_user_id(); // Get the current user ID
            error_log('Current user ID: ' . $user_id); // Log the current user ID

            // Update user meta with the new profile picture
            update_user_meta($user_id, 'profile_picture', $file_url); // Storing the URL as meta data

            // Log that the user meta has been updated
            error_log('Profile picture URL saved to user meta for user ID: ' . $user_id);

            // Optionally return the uploaded file's URL
            wp_send_json_success(array('url' => $file_url, 'message' => 'Profile picture updated successfully.'));
        } else {
            // Log any error that occurred during file upload
            error_log('File upload error: ' . $movefile['error']);

            // Handle error during file upload
            wp_send_json_error(array('error' => $movefile['error']));
        }
    } else {
        // Log that no file was uploaded
        error_log('No file uploaded');

        // No file was uploaded
        wp_send_json_error(array('error' => 'No file uploaded.'));
    }

    wp_die(); // Required to terminate immediately and return a proper response
}
add_action('wp_ajax_upload_user_profile_picture', 'upload_user_profile_picture');
add_action('wp_ajax_nopriv_upload_user_profile_picture', 'upload_user_profile_picture');


function daily_note_update() {
    // Get the current user ID
    $user_id = get_current_user_id();

    // Check if the user is logged in
    if (!$user_id) {
        wp_send_json_error(array('error' => 'User is not logged in.'));
        wp_die();
    }

    // Check if 'note' is set in $_POST
    if (isset($_POST['note'])) {
        $note = sanitize_text_field($_POST['note']); // Sanitize the note input

        // Update or add the 'daily_note' user meta
        $existing_note = get_user_meta($user_id, 'daily_note', true);
        
        if ($existing_note) {
            // Update the existing note
            update_user_meta($user_id, 'daily_note', $note);
            wp_send_json_success(array('message' => 'Daily note updated successfully.'));
        } else {
            // Add a new note if none exists
            add_user_meta($user_id, 'daily_note', $note);
            wp_send_json_success(array('message' => 'Daily note added successfully.'));
        }
    } else {
        wp_send_json_error(array('error' => 'No note provided.'));
    }

    wp_die(); // Required to terminate immediately and return a proper response
}
add_action('wp_ajax_daily_note_update', 'daily_note_update');
add_action('wp_ajax_nopriv_daily_note_update', 'daily_note_update');
