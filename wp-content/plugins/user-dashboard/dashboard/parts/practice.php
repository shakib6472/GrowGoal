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
			<div class="custom-sec-roting-box border">
				<div class="sec-clock-img-clock-container">
					<img src="https://growgoal.online/wp-content/uploads/2024/09/Group-40.png" alt="" class="sec-clock-img">
					<h4 class="sec-clock">Daily Reminder:</h4>

				</div>
				<h4 class="custom-sec-roting-heading">Practise Until You Can’t Get Wrong</h4>
			</div>

		</div>
		<!-- -------Right Container------- -->
		<div class="custom-sec-right-container border">
			<h2 class="custom-sec-right-main-heading">Enter Your Lesson</h2>

			<div class="custom-sec-right-lessong-container">
				<?php
				global $wpdb;

				$page = isset($_GET['ln']) ? $_GET['ln'] : 1;
				error_log($page);
				$current_user_id = get_current_user_id();
				$total_class = get_user_meta($current_user_id, 'how_many_classs_you_have', true);
				$lessons_per_page = 8;
				$user_id = get_current_user_id();
				$start_lesson = ($page * $lessons_per_page) - 7;
				$end_lesson = min($page * $lessons_per_page, $total_class);

				for ($i = $start_lesson; $i <= $end_lesson; $i++) {
					// Table name with prefix
					$table_name = $wpdb->prefix . 'teacher_bookings';
					// Prepare and execute the query to get the row where lesson_name = $lesson_num
					$query = $wpdb->prepare("SELECT * FROM $table_name WHERE lesson_name = %d AND student_id = %d", $i, $user_id);
					$result = $wpdb->get_row($query);
					if ($result) {
						$practice = $result->practice;
						if ($practice) {
				?>
							<div class="custom-sec-right-lesson ">
								<a href="<?php echo $practice; ?>">
									<img src="https://growgoal.online/wp-content/uploads/2024/09/2201549.png" alt="" class="lesson-book-img booked">
									<h2 class="custom-lesson-heading-sec"> Practice <?php echo $i; ?></h2>
								</a>
							</div>
						<?php
						} else {
						?>
							<div class="custom-sec-right-lesson desabled">
								<img src="https://growgoal.online/wp-content/uploads/2024/09/2201549.png" alt="" class="lesson-book-img not-booked">
								<h2 class="custom-lesson-heading-sec"> Practice <?php echo $i; ?></h2>

							</div>
						<?php
						}
					} else {
						?>
						<div class="custom-sec-right-lesson desabled">
							<img src="https://growgoal.online/wp-content/uploads/2024/09/2201549.png" alt="" class="lesson-book-img not-booked">
							<h2 class="custom-lesson-heading-sec"> Practice <?php echo $i; ?></h2>

						</div>
				<?php
					}
				}
				?>
			</div>

			<div class="custom-sec-pagi">
				<?php if ($page > 1) { ?>
					<a href="?ln=<?php echo $page - 1; ?>">Prev</a>
				<?php } ?>

				<?php if ($end_lesson < $total_class) { ?>
					<a href="?ln=<?php echo $page + 1; ?>">Next</a>
				<?php } ?>
			</div>



		</div>

	</div>
</div>