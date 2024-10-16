<?php

namespace EdubinCore\LP\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Course_Search extends \EdubinCore\Widgets\Course_Search {

	public function get_name() {
		return 'edubin-lp-search';
	}

	public function get_title() {
		return __( 'Search (LearnPress)', 'edubin-core' );
	}

	public function get_keywords() {
		return [ 'edubin', 'course', 'search', 'learnpress', 'form', 'course search' ];
	}
}