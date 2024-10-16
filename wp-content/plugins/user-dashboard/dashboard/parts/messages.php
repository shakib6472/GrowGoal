<div class="custom-pageone-sec-container">
	<div class="custom-page-two">
		<!-- ----Left Container -->
		<div class="custom-sec-left-container">
			<div class="custom-sec-clock-box border">
				<div class="sec-clock-img-clock-container">
					<img src="https://growgoal.online/wp-content/uploads/2024/09/Mask-group-6.png" alt="" class="sec-clock-img">
					<h4 class="sec-clock">Clock :</h4>

				</div>
				<h2 class="custom-sec-current-time">8:00AM</h2>
				<h2 class="custom-sec-current-date">Monday,3rd October,2022</h2>
			</div>
			<div class=" custom-six-roting-box border">
				<div class="sec-clock-img-clock-container">
					<img src="https://growgoal.online/wp-content/uploads/2024/09/Group-40.png" alt="" class="sec-clock-img">
					<h4 class="sec-clock">Daily Reminder:</h4>
				</div>
				<h4 class="custom-sec-roting-heading">
					<a href="<?php echo home_url('/chat') ?>" class="message">
						See Messages
					</a>

				</h4>

			</div>
		</div>
		<!-- -------Right Container------- -->
		<div class="six-todo-container border">
			<h2 class="custom-six-right-main-heading">The more you question, the<br> more you learn</h2>
			<h2 class="custom-six-question-form">send a message or a question to your teacher</h2>
			<div class="custom-six-contact-form">

				<textarea name="message" id="message" placeholder="Text Here"></textarea>
				<img src="https://growgoal.online/wp-content/uploads/2024/09/Vector-9.png" alt="" class="sent_message">
			</div>
			<h2 class="custom-six-question-form">choose your teacher</h2>

			<div class="custom-teacher-choose-min-container">
				<?php
				global $wpdb;
				$user_id = get_current_user_id();
				$table_name = $wpdb->prefix . 'teacher_bookings';
				// Prepare and execute the query to get the row where lesson_name = $lesson_num
				$query = $wpdb->prepare("SELECT teacher_id FROM $table_name WHERE  student_id = %d", $user_id);
				$results = $wpdb->get_results($query);
				foreach ($results as $result) {
					$post_id =  $result->teacher_id;
					$post_title = get_the_title($post_id);
					$post_thumbnail_id = get_post_thumbnail_id($post_id);
					$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
					if (!$post_thumbnail_url) {
						$post_thumbnail_url = 'https://growgoal.online/wp-content/uploads/2024/10/image.png';
					}
					$author_id = get_post_field( 'post_author', $post_id );

				?>
					<label class="teacher">
						<input type="radio" name="teacher" class="t-radio" value="<?php echo $author_id; ?>"/>
						<img class="t-profile" src="<?php echo $post_thumbnail_url; ?>" alt="">
						<div class="t-name"><?php echo $post_title; ?></div>
						<div class="t-tag">Teacher</div>
					</label> <?php
							}
								?>
			</div>
		</div>
	</div>
</div>