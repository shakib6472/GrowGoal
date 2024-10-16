<?php


function get_user_messages($user_id)
{
    // Query to get all messages for the user
    $args = array(
        'post_type' => 'message',
        'meta_query' => array(
            array(
                'key' => 'receiver_id',
                'value' => $user_id,
                'compare' => '='
            )
        ),
        'posts_per_page' => -1 // Get all messages
    );

    $messages = new WP_Query($args);

    // Array to hold aggregated messages by sender
    $message_data = array();

    if ($messages->have_posts()) {
        while ($messages->have_posts()) {
            $messages->the_post();
            $sender_id = get_post_meta(get_the_ID(), 'sender_id', true);
            $is_read = get_post_meta(get_the_ID(), 'is_read', true);
            $message_time = get_the_date('D, j M');

            // If this sender already exists in the array, update the count
            if (isset($message_data[$sender_id])) {
                $message_data[$sender_id]['count'] += !$is_read ? 1 : 0;
            } else {
                // Otherwise, add a new entry for this sender
                $message_data[$sender_id] = array(
                    'sender_name' => get_userdata($sender_id)->display_name,
                    'message_time' => $message_time,
                    'count' => !$is_read ? 1 : 0
                );
            }
        }
        wp_reset_postdata();
    }

    // Output the aggregated data
    if (!empty($message_data)) {
        foreach ($message_data as $data) {
            
            ?>  
            <tr class="border-0" >
                <td class="border-0"> <?php echo $data['message_time']; ?></td>
                <td class="border-0"> <?php echo $data['sender_name']; ?></td>
                <td class="border-0"> <?php echo ($data['count'] > 0 ? $data['count'] . ' New Message' . ($data['count'] > 1 ? 's' : '') : 'No New Messages'); ?></td>
                <td class="border-0"> <a href="<?php echo home_url('/conversation'). '?sender_id=' . $sender_id ; ?>">View Conversation</a></td>
              
            </tr>
            <?php 
        }
    } else {
        echo '<tr><td colspan="4">No messages found.</td></tr>';
    }
}


// Shotcode to show the conversation

function conversation_shortcode()
{
    // Get sender ID from URL parameter
    $sender_id = isset($_GET['sender_id']) ? intval($_GET['sender_id']) : 0;
    $current_user_id = get_current_user_id();

    // Check if sender ID is valid
    if ($sender_id <= 0) {
        return '<div class="alert alert-danger">Invalid sender ID.</div>';
    }

    // Query messages between the current user and the sender
    $args = array(
        'post_type' => 'message',
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'sender_id',
                'value' => $sender_id,
                'compare' => '='
            ),
            array(
                'key' => 'receiver_id',
                'value' => $sender_id,
                'compare' => '='
            )
        ),
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC'
    );

    $messages = new WP_Query($args);

    ob_start();

?>
    <div class="container position-relative mt-4 p-4">
        <div class="pre-loading">
            <div class="loading">
                <div class="lds-ellipsis">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Conversation with <?php echo esc_html(get_userdata($sender_id)->display_name); ?></div>
            <div class="card-body">
                <div class="list-group">
                    <?php
                    if ($messages->have_posts()) {
                        while ($messages->have_posts()) {
                            $messages->the_post();
                            $is_read = get_post_meta(get_the_ID(), 'is_read', true);
                            $message_time = get_the_date('D, j M Y \a\t H:i');
                            $message_content = get_the_content();

                            // Determine message alignment
                            $alignment = get_post_meta(get_the_ID(), 'sender_id', true) == $sender_id ? 'text-left' : 'text-right';
                            $message_class = $is_read ? 'list-group-item' : 'list-group-item list-group-item-info';

                    ?>
                            <div class="<?php echo esc_attr($message_class . ' ' . $alignment); ?>">
                                <small class="text-muted"><?php echo esc_html($message_time); ?></small>
                                <p><?php echo esc_html($message_content); ?></p>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="alert alert-info">No messages found.</div>
                    <?php
                    }
                    ?>
                </div> <!-- .list-group -->
            </div> <!-- .card-body -->
            
                <div class="card-footer">
                    <form id="reply-form" data-receiver-id="<?php echo esc_attr($sender_id); ?>" class="form-inline">
                        <div class="d-flex justify-content-center gap-5">
                            <div class="form-group flex-fill mr-2"> <textarea class="form-control" id="reply-message" rows="2" placeholder="Type your message here..." style="width: 100%;"></textarea> </div>
                            <button type="submit" style="width: 80px; font-size: 16px" class="btn btn-primary reply_message" data-receiver-id="<?php echo esc_attr($sender_id); ?>">Send <i style="font-size: 10px;" class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div> <!-- .card-footer -->
          
        </div> <!-- .card -->
    </div> <!-- .container -->

<?php
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('conversation', 'conversation_shortcode');
