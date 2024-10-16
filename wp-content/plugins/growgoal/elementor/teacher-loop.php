<?php
class Elementor_teacher_loop extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'teacher-loop';
    }

    public function get_title()
    {
        return esc_html__('Teacher Loop', 'boikotha');
    }

    public function get_icon()
    {
        return 'fas fa-user';
    }
    protected function _register_controls()
    {
    }

    public function get_categories()
    {
        return ['basic'];
    }

    public function get_keywords()
    {
        return ['teacher', 'loop'];
    }

    protected function render()
    {

        $settings = $this->get_settings();

        ?>


        <div class="schedule-lesson ">

            <div class="teacher-list">
                <?php
                $args = array(
                    'post_type' => 'teacher', // Post-type key
                    'posts_per_page' => -1, // -1 retrieves all posts
        
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $post_id = get_the_ID();
                        $post_title = get_the_title($post_id);
                        $post_thumbnail_id = get_post_thumbnail_id($post_id);
                        $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                        $location = get_post_meta($post_id, 'location', true);
                        $about = get_post_meta($post_id, 'about_', true);
                        $language_fluentcy = get_post_meta($post_id, 'language_fluentcy', true);
                        $age_group = get_post_meta($post_id, 'age_group', true);
                        $proffession = get_post_meta($post_id, 'proffession', true);

                        ?>

                        <div class="teacher card p3"
                            style="background-image: url('<?php echo plugin_dir_url('growgoal/assets/img/s') . 'bg.png'; ?>');">

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

                            <div class="card-top pb-4">

                                <div class="details">
                                    <div class="teacherid d-none"><?php echo $post_id; ?></div>
                                    <div class="name"><?php echo $post_title; ?></div>
                                    <div class="lists">
                                        <div class="list">
                                            <img class="icon icon-image"
                                                src="<?php echo plugin_dir_url('growgoal/assets/img/s') . 'age.png'; ?>" alt="">
                                            <span class="icon-text"><?php echo $age_group; ?></span>
                                        </div>
                                        <div class="list">
                                            <img class="icon icon-image"
                                                src="<?php echo plugin_dir_url('growgoal/assets/img/s') . 'calender.png'; ?>" alt="">
                                            <span class="icon-text"><?php echo '14:00-16'; ?></span>
                                        </div>
                                        <div class="list">
                                            <img class="icon icon-image"
                                                src="<?php echo plugin_dir_url('growgoal/assets/img/s') . 'certificate.png'; ?>" alt="">
                                            <span class="icon-text"><?php echo $proffession; ?></span>
                                        </div>
                                        <div class="list">
                                            <img class="icon icon-image"
                                                src="<?php echo plugin_dir_url('growgoal/assets/img/s') . 'location.png'; ?>" alt="">
                                            <span class="icon-text"><?php echo $location; ?></span>
                                        </div>

                                    </div>
                                </div>
                               
                                <div class="profile ">
                                    <div class="d-flex justify-content-end align-items-center g-5">
                                        <div class="details">
                                            <div class="name"><?php echo $post_title; ?></div>
                                        </div>
                                        <img src="<?php echo $post_thumbnail_url; ?>" alt="">
                                    </div>
                                    <div class="about-me">
                                    <div class="about">
                                        <p><?php  echo $about; ?></p>
                                    </div>
                                </div>
                                <div class="biography">
                                    <div class="bio">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut?
                                    </div>

                                </div>
                                </div>

                            </div>
                            <div class="card-middle">

                                <?php
                                if (is_user_logged_in()) {
                                    ?>
                                    <div>
                                        <div class="form-container">
                                            <div class="row">
                                                <div class="col-md-6 ">
                                                    <label for="date">Select this Teacher for Your Next Lesson</label> <br>
                                                    <div class="dates-visible-toggle form-control ">
                                                        <p class="placing d-flex justify-content-between">
                                                            Date <i class="fas fa-angle-down"></i>
                                                        </p>
                                                        <!-- <input type="date" name="" id="date" class="form-control date-pick-for-time border-0"> -->
                                                    </div>
                                                    <div class="dates">
                                                        <div class="gridbox-fortime">

                                                            <?php
                                                            // Get the current date and add one day to start from tomorrow
                                                            $start_date = new DateTime('tomorrow');

                                                            // Loop through the next 7 days
                                                            for ($i = 0; $i < 7; $i++) {
                                                                // Clone the start date and add $i days
                                                                $date = clone $start_date;
                                                                $date->modify("+$i days");

                                                                // Format the date as 'D, d M'
                                                                $formatted_date = $date->format('D, d M');
                                                                $data_date = $date->format('Y-m-d');

                                                                // Output the date in a div
                                                                echo '<div class="time-slot date-picked" data-teacher="' . $post_id . '" data-date="' . $data_date . '">' . $formatted_date . '</div>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <!-- <input type="date" name="" id="date" class="form-control date-pick-for-time"> -->
                                                </div>
                                                <div class="col-md-6">

                                                    <label for="date">Available Times</label> <br>
                                                    <div>
                                                        <div class="loading">
                                                            <div class="lds-ellipsis">
                                                                <div></div>
                                                                <div></div>
                                                                <div></div>
                                                                <div></div>
                                                            </div>
                                                        </div>
                                                        <div class="gridbox-fortime time-maps">
                                                           <span style="color:#fff;"> Please Select A Date First.</span>
                                                            <!-- <div class="time-slot time-picked" data-time="09:00 AM"> 09:00 AM</div>
                                                <div class="time-slot"> 09:00 AM</div>
                                                <div class="time-slot"> 09:00 AM</div>
                                                <div class="time-slot"> 09:00 AM</div> -->
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div>
                                        <h5>Please Login First</h5>
                                        <div class="btn-success btn"><a href="<?php echo wp_login_url() ?>"></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }

                    // Restore original post data
                    wp_reset_postdata();
                } else {
                    // No posts found
                    echo 'No Teacher found';
                }
                ?>

            </div>
        </div>

        <div class="confirmation-popup">
            <div class="pre-loading second">
                <div class="loading">
                    <div class="lds-ellipsis">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>


            <div class="popup">
                <div class="card">
                    <div class="details">
                        <div class="">
                            <p class="det"><span class="teacher-id d-none"> </span></p>
                            <p class="det"><span>Teacher Name: </span><span class="teacher-name"> Shakib Shown </span></p>
                        </div>

                        <div class="">
                            <p class="det"><span>Lesson Number: </span> <span class="lesson-name"> 5 </span> </p>
                        </div>
                        <div class="">
                            <p class="det"><span>Selected Date: </span> <span class="booked-date">Fri, 16 Jul </span> </p>
                        </div>
                        <div class="">
                            <p class="det"><span>Selected Time: </span> <span class="booked-time">10:30 AM </span> </p>
                        </div>
                        <div class="d-flex justify-content-between g-5 group-single">
                            <div class="form-check item form-control d-flex justify-content-center align-items-center p-3">
                                <input class="d-none" type="radio" name="type" id="privateRadio" value="private">
                                <label class="form-check-label" for="privateRadio">Private</label>
                            </div>
                            <div class="form-check item form-control d-flex justify-content-center align-items-center p-3">
                                <input class="d-none" type="radio" name="type" id="groupRadio" value="group">
                                <label class="form-check-label" for="groupRadio">Group</label>
                            </div>
                        </div>
                    </div>
                    <div class="butn w-100">
                        <div class=" btn btn-primary w-100 confirm-booking">Confirm Booking</div>
                        <div class=" btn btn-danger w-100 mt-4 cencelled-booking">Cencel</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cancellation-popup">

            <div class="popup">
                <div class="card d-flex flex-column align-items-center justify-content-center p-5">

                    <h2>Sorry, You need to Purchase Course First</h2>
                    <p>You Have already booked Your all Classes</p>
                    <div class="butn w-100 d-flex align-items-center justify-content-center gap-3">
                        <div class=" btn btn-primary "><a href="">View All Courses</a></div>
                        <div class=" btn btn-danger close-popup">OKay</div>
                    </div>
                </div>
            </div>
        </div>




        <?php

    }
}
