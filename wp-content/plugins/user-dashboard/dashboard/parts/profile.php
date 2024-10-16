<?php

// Get current logged-in user information
$current_user = wp_get_current_user();
// Get user's avatar, fallback to placeholder if not found
// $user_avatar = get_avatar($current_user->ID, 96, '', '', array('class' => 'custom-profile-photo'));
$user_avatar = get_user_meta($current_user->ID, 'profile_picture', true);
$placeholder_avatar = 'https://growgoal.online/wp-content/uploads/2024/09/placeholder.png'; // Placeholder image URL

// If no avatar is found, use the placeholder image
if (!$user_avatar) {
	$user_avatar = '<img src="' . $placeholder_avatar . '" class="custom-profile-photo" alt="Profile">';
} else {
	$user_avatar = '<img src="' . $user_avatar . '" class="custom-profile-photo" alt="Profile">';
}
$user_id = get_current_user_id();
?>
 

<h2 class="custom-success-heading">
	<i>To Succeed You Must First Believe That You Can</i>
</h2>

<!-- Second Container page 1 -->
<div class="custom-pageone-sec-container">
	<div class="custom-pageone-left-container">
		<div class="custom-first-child">
			<div class="custom-student-profile">
				<div class="img">


					<?php echo $user_avatar; // Display user's avatar or placeholder 
					?>

					<img
						src="https://growgoal.online/wp-content/uploads/2024/09/camera-952.png"
						alt=""
						class="custom-add-photo" />
					<input type="file" id="profile_upload" name="profile_upload" style="display:none;" />
				</div>
				<h4>Photo The Student Upload</h4>
			</div>
			<div class="custom-student-info">
				<div class="custom-contact-info">
							<textarea name="profile_note" id="profile_note" placeholder="Save Your Todays Note here"><?php echo get_user_meta($current_user->ID, 'daily_note', true); ?></textarea>
						<input type="button" name="" id="custom-sub-btn" value="Save" />
					
				</div>
			</div>
		</div>
		<div class="custom-sec-child">
			<div class="custom-notes-container">
				<div class="custom-note-box-one">
					<div class="custom-note-title">Notes:</div>
					<select class="custom-note-select">
						<option>Select</option>
					</select>
					<div class="custom-note-image custom-image-science"></div>
				</div>

				<div class="custom-note-box-two">
					<div class="custom-note-title">Notes:</div>
					<select class="custom-note-select">
						<option>Select</option>
					</select>
					<div class="custom-note-image custom-image-reading"></div>
				</div>

				<div class="custom-note-box-three">
					<div class="custom-note-title">Notes:</div>
					<select class="custom-note-select">
						<option>Select</option>
					</select>
					<div class="custom-note-image custom-image-books"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="custom-pageone-right-container">
		<div class="custom-right-top">
			<div class="custom-right-top-first">
				<h4 class="custom-right-heading">Next Lesson</h4>
			</div>
			<div class="custom-right-top-second">
				<div class="custom-right-top-one">
					<div class="custom-right-date">
						<img
							src="https://growgoal.online/wp-content/uploads/2024/09/Group-35.png"
							alt=""
							class="custom-date-img" />
						<h2 class="custom-right-date-h2">Date :</h2>
					</div>
					<h2 class="custom-right-right-clock">18/18</h2>
				</div>
				<div class="custom-right-top-one">
					<div class="custom-right-date">
						<img
							src="https://growgoal.online/wp-content/uploads/2024/09/Vector-7.png"
							alt=""
							class="custom-date-img" />
						<h2 class="custom-right-date-h2">Time :</h2>
					</div>
					<h2 class="custom-right-right-clock">07:00</h2>
				</div>
			</div>
		</div>
		<div class="custom-right-end">
			<div class="custom-to-do-list-container">
				<div class="custom-to-do-header">
					<span class="custom-to-do-icon">💡</span>
					<h3 class="custom-to-do-title">To-Do List:</h3>
					<button class="custom-add-task-button">+</button>
				</div>
				<div class="custom-to-do-item">
					<img
						src="https://growgoal.online/wp-content/uploads/2024/09/3655618.png"
						alt="Math Icon"
						class="custom-to-do-icon-img" />
					<label class="custom-to-do-label"></label>
					<select class="custom-to-do-select">
						<option value="math">Math</option>
					</select>
				</div>
				<div class="custom-to-do-item">
					<img
						src="https://growgoal.online/wp-content/uploads/2024/09/9216202.png"
						alt="English Icon"
						class="custom-to-do-icon-img" />
					<label class="custom-to-do-label"></label>
					<select class="custom-to-do-select">
						<option value="english">English</option>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>