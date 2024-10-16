<div id="dashboard">
    <!-- Navigation -->
    <a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> Dashboard Navigation</a>

    <?php left_nav_menu_list('schedule'); ?>
    <!-- Navigation / End -->

    <!-- Content -->
    <div class="dashboard-content" id="post-120" class="post-120 page type-page status-publish hentry">
        <!-- Titlebar -->
        <div id="titlebar">
            <div class="row">
                <div class="col-md-12">
                    <h2>My Schedules</h2>
                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs">
                        <ul>
                            <li><a href="<?php echo home_url(); ?>"> Home </a></li>
                            <li> <a href="<?php echo home_url('/dashboard'); ?>"> Dashboard </a></li>
                            <li>My Schedules </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="row listeo-dashoard-widgets">


            <!-- Item -->
            <div class="" id="dashboard-active-listing-tile">
                <div class="containers">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-md-12">
                            <div class="table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Lesson Name</th>
                                            <th>Teacher Name</th>
                                            <th>Date & Time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        global $wpdb;


                                        $student_id = get_current_user_id();
                                        $table_name = $wpdb->prefix . 'teacher_bookings';

                                        $results = $wpdb->get_results(
                                            $wpdb->prepare(
                                                "SELECT * FROM $table_name WHERE student_id = %d",
                                                $student_id
                                            )
                                        );

                                        foreach ($results as $result) {
                                            $teacher = get_teacher_name_from_id($result->teacher_id);
                                            $time = $result->booking_time; // 2024-07-13 09:00:00
                                            $status = check_time_status($time);
                                            $date = new DateTime($time);
                                            $time = $date->format('D, d M');

                                        ?>

                                            <tr>
                                                <td><?php echo $result->lesson_name; ?></td>
                                                <td><?php echo $teacher; ?></td>
                                                <td><?php echo $time; ?></td>
                                                <td><?php echo $status; ?></td>
                                                <td>
                                                    <?php

                                                    if ('Done' == $status) {
                                                    ?>
                                                        <button type="button" class="btn btn-secondary" disabled>Completed</button>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="btn btn-success">Join Now</div>
                                                    <?php
                                                        
                                                    }

                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }


                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Content / End -->
</div>