<?php

namespace EdubinCore\TL\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Course_Search extends \EdubinCore\Widgets\Course_Search {

	public function get_name() {
		return 'edubin-tutor-search';
	}

	public function get_title() {
		return __( 'Search( Tutor LMS )', 'edubin-core' );
	}

	public function get_keywords() {
		return [ 'edubin', 'course', 'search', 'form', 'course search', 'tutor', 'lms', 'tutor lms' ];
	}

    protected $post_type = 'courses';
}