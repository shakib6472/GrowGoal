<?php

global $wpdb;

// Check if 'l' parameter is passed via the URL
$lesson_num = isset($_GET['l']) ? intval($_GET['l']) : 0;

if ($lesson_num) {

    error_log('Lesson Number Found. Lesson Number is: ' .  $lesson_num);
    // Table name with prefix
    $user_id = get_current_user_id();
    $table_name = $wpdb->prefix . 'teacher_bookings';
    // Prepare and execute the query to get the row where lesson_name = $lesson_num
    $query = $wpdb->prepare("SELECT * FROM $table_name WHERE lesson_name = %d AND student_id = %d", $lesson_num, $user_id);
    $result = $wpdb->get_row($query);

    // Handle the result
    if ($result) {
        // Do something with the result, like displaying it or processing further
        $booking_time = $result->booking_time;
        $thum_id = get_post_thumbnail_id($result->teacher_id);
        $thumb_url = wp_get_attachment_url($thum_id);
        $zoom = $result->zoom;
        $status = $result->status;
        $record = $result->record;
        if (strpos($record, 'youtu.be') !== false) {
            $urlParts = explode('/', $record);
            $videoId = explode('?', end($urlParts))[0]; // Get the video ID (remove any query parameters)
            $record = 'https://www.youtube.com/embed/' . $videoId;
        }
        error_log(print_r($result, true));
    } else {
        error_log('No lesson found for Lesson Number: ' . $lesson_num);
    }
} else {
    error_log('NO Lesson Number Found');
}


?>


<div class="custom-pageone-sec-container">
    <div class="custom-three-main-container">
        <div class="cutom-three-main-left">
            <div class="custom-three-left-top-container border">
                <div class="custom-three-time-date-sec-min">
                    <div class="day-time-sec-min">
                        <p class="d-none time-left-or-finish"></p>
                        <h6>Day</h6>
                        <div>
                            <span id="ldays">0</span>

                        </div>
                    </div>

                    <div class="day-time-sec-min">
                        <h6>Hours</h6>
                        <div>
                            <span id="lhours">0</span>

                        </div>
                    </div>

                    <div class="day-time-sec-min">
                        <h6>Minutes</h6>
                        <div>
                            <span id="lminutes">0</span>

                        </div>
                    </div>

                    <div class="day-time-sec-min">
                        <h6>Second</h6>
                        <div>
                            <span id="lseconds">0</span>

                        </div>
                    </div>
                </div>
                <!-- Added status message -->
                <div id="status-message"></div>
                <div class="custom-three-headin-icon">
                    <h2>timer how much time left to start the lesson</h2>
                    <img src="https://growgoal.online/wp-content/uploads/2024/09/Group-1597883372.png" alt="">
                </div>
            </div>

        </div>
        <div class="cutom-ten-main-right border" style=" background-image: url(<?php echo $thumb_url; ?>)">
            <?php
            if ($zoom) {
                if ($status != 'complete') {
            ?>
                    <a href="<?php echo $zoom; ?>" class="zoom_url">
                        <img src="https://growgoal.online/wp-content/uploads/2024/09/Group-1597883373.png" alt="">
                    </a>
                <?php

                } else {
                ?> <div class="video_popup">

                        <img src="https://growgoal.online/wp-content/uploads/2024/09/Group-1597883373.png" alt="" class="video_popup">
                    </div>
                <?php
                }
            } else {
                ?><div class="zoom-not-seted">

                    <img src="https://growgoal.online/wp-content/uploads/2024/09/Group-1597883373.png" alt="" class="zoom-not-seted">
                </div>
            <?php
            }

            ?>
        </div>
    </div>
</div>

<div class="video_pop_record_holder">
    <div class="video-width">
        <?php
        if ($record) {
        ?>

            <iframe width="560" height="600px"
                src="<?php echo $record; ?>"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        <?php
        } else { ?>
            <p class="text-dark"> Recorded Video is not Submitted Yet! </p>
            <p class="text-dark"> Please Try later </p>
            <div class="btn btn-success">OK</div>
        <?php
        }

        ?>
    </div>
</div>

<script>
    // Pass PHP booking time to JavaScript
    var bookingTime = new Date("<?php echo $booking_time; ?>").getTime();
    // Update countdown every second
    var countdown = setInterval(function() {
        var now = new Date().getTime();
        console.log('Booking Time: ' + bookingTime);
        console.log('Now Time: ' + now);
        var timeDifference = bookingTime - now;
        console.log('timeDifference Time: ' + timeDifference);
        if (timeDifference < 0) {
            // Time has passed

            clearInterval(countdown);

            console.log('TIme Finished');
            document.getElementById("status-message").innerHTML = "Waiting Time Finished";
            document.getElementById("status-message").style.display = 'block';

            // Hide the countdown timer
            var countdownElement = document.getElementsByClassName("custom-three-time-date-sec-min")[0];
            if (countdownElement) {
                console.log('custom-three-time-date-sec-min Found & set display None');
                countdownElement.style.display = 'none';
            }
        } else {
            // Time calculation 

            var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
            var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);
            console.log('TIme Left Days' + days);
            console.log('TIme Left Hours' + hours);
            console.log('TIme Left MUnites' + minutes);
            console.log('TIme Left Seconds' + seconds);

            // Update the HTML with the calculated time
            document.getElementById("ldays").innerHTML = days;
            document.getElementById("lhours").innerHTML = hours;
            document.getElementById("lminutes").innerHTML = minutes;
            document.getElementById("lseconds").innerHTML = seconds;
            // Hide the status message if countdown is active
            document.getElementById("status-message").style.display = "none";
        }
    }, 1000);
</script>