

<?php 

function left_nav_menu_list_teacher ($value){
    ?> 
    <div class="dashboard-nav">
        <div class="dashboard-nav-inner">
            <ul>
                <!-- <li class="<?php if('profile' == $value) { echo 'active';} ?>">
                    <a href="<?php echo home_url('teacher-dashboard/profile') ?>/"><i class="fas fa-address-card"></i> My Profile</a>
                </li> -->
                <li class="<?php if('t-schedule' == $value) { echo 'active';} ?>">
                    <a href="<?php echo home_url('teacher-dashboard/schedule') ?>/"><i class="fab fa-leanpub"></i> My Schedules</a>
                </li>
                <li class="<?php if('t-lesson' == $value) { echo 'active';} ?>">
                    <a href="<?php echo home_url('teacher-dashboard/lesson') ?>/"><i class="fas fa-calendar-check"></i>Lessons</a>
                </li>
                <li class="<?php if('t-students' == $value) { echo 'active';} ?>">
                    <a href="<?php echo home_url('teacher-dashboard/students') ?>/"><i class="fas fa-message"></i> My Students </a>
                </li>
                <li class="<?php if('t-messages' == $value) { echo 'active';} ?>">
                    <a href="<?php echo home_url('teacher-dashboard/messages') ?>/"><i class="fas fa-message"></i>Sent Messages </a>
                </li>
                <li class="<?php if('available' == $value) { echo 'active';} ?>">
                    <a href="<?php echo home_url('teacher-dashboard/available') ?>/"><i class="fas fa-message"></i>My Availability </a>
                </li>
                <li class="<?php if('t-assignments' == $value) { echo 'active';} ?>">
                    <a href="<?php echo home_url('teacher-dashboard/assignments') ?>/"><i class="fas fa-table"></i> Give Assignments</a>
                </li>
                <li class="<?php if('feedback' == $value) { echo 'active';} ?>">
                    <a href="<?php echo home_url('teacher-dashboard/feedback') ?>/"><i class="fab fa-accusoft"></i>Feedbacks</a>
                </li>
                <li class="">
                    <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><i class="fas fa-door-open"></i>Logout</a>
                </li>
            </ul>
            </li>
        </div>
</div>

    
    <?php 
}