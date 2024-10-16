<?php

namespace EdubinCore\SS\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Course_Search extends \EdubinCore\Widgets\Course_Search {

	public function get_name() {
		return 'edubin-sensei-search';
	}

	public function get_title() {
		return __( 'Course ( Sensei LMS )', 'edubin-core' );
	}

	public function get_keywords() {
		return [ 'edubin', 'course', 'search', 'form', 'course search', 'sensei', 'lms', 'sensei lms' ];
	}

    protected $post_type = 'course';
}