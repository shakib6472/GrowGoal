<?php

namespace EdubinCore\MS\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Course_Search extends \EdubinCore\Widgets\Course_Search {

	public function get_name() {
		return 'edubin-ms-search';
	}

	public function get_title() {
		return __( 'Search ( MasterStudy )', 'edubin-core' );
	}

	public function get_keywords() {
		return [ 'edubin', 'course', 'search', 'form', 'course search', 'master study lms', 'lms', 'masterstudy lms' ];
	}

    protected $post_type = 'stm-courses';
}