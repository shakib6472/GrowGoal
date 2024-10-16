<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Author additional fields
 */
if ( ! function_exists( 'edubin_additional_user_fields' ) ) :
    function edubin_additional_user_fields( $contactmethods ) {
        $contactmethods['edubin_job']   = __( 'Instructor Job', 'edubin-core' );
        $contactmethods['edubin_facebook']  = __( 'Facebook', 'edubin-core' );
        $contactmethods['edubin_twitter']   = __( 'Twitter', 'edubin-core' );
        $contactmethods['edubin_youtube']  = __( 'YoutTube', 'edubin-core' );
        $contactmethods['edubin_linkedin']   = __( 'LinkedIn', 'edubin-core' );
    
        return $contactmethods;
    }
endif;
add_filter( 'user_contactmethods', 'edubin_additional_user_fields', 10, 1 );


/*
 * HTML Tag list
 * return array
 */
if( !function_exists('edubin_html_tag_lists') ){
    function edubin_html_tag_lists() {
        $html_tag_list = [
            'h1'   => __( 'H1', 'edubin-core' ),
            'h2'   => __( 'H2', 'edubin-core' ),
            'h3'   => __( 'H3', 'edubin-core' ),
            'h4'   => __( 'H4', 'edubin-core' ),
            'h5'   => __( 'H5', 'edubin-core' ),
            'h6'   => __( 'H6', 'edubin-core' ),
            'p'    => __( 'p', 'edubin-core' ),
            'div'  => __( 'div', 'edubin-core' ),
            'span' => __( 'span', 'edubin-core' ),
        ];
        return $html_tag_list;
    }
}

/*
 * HTML Tag Validation
 * return strig
 */
function edubin_validate_html_tag( $tag ) {
    $allowed_html_tags = [
        'article',
        'aside',
        'footer',
        'header',
        'section',
        'nav',
        'main',
        'div',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'p',
        'span',
    ];
    return in_array( strtolower( $tag ), $allowed_html_tags ) ? $tag : 'div';
}

/*
 * Contact form list
 * return array
 */
if( !function_exists('edubin_contact_form_seven') ){
    function edubin_contact_form_seven(){
        $countactform = array();
        $edubin_forms_args = array( 'posts_per_page' => -1, 'post_type'=> 'wpcf7_contact_form' );
        $edubin_forms = get_posts( $edubin_forms_args );

        if( $edubin_forms ){
            foreach ( $edubin_forms as $edubin_form ){
                $countactform[$edubin_form->ID] = $edubin_form->post_title;
            }
        }else{
            $countactform[ esc_html__( 'No contact form found', 'edubin-core' ) ] = 0;
        }
        return $countactform;
    }
}

/*
 * All list of allowed html tags.
 *
 * @param string $tag_type Allowed levels are title and desc
 * @return array
 */
function edubin_get_html_allowed_tags($tag_type = 'title') {
    $accept_html_tags = [
        'span'   => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'strong' => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'br'     => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],        
        'b'      => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'sub'    => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'sup'    => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'i'      => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'u'      => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        's'      => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'em'     => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'del'    => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'ins'    => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],

        'code'   => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'mark'   => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'small'  => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'strike' => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'abbr'   => [
            'title' => [],
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
    ];

    if ('desc' === $tag_type) {
        $desc_tags = [
            'h1' => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'h2' => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'h3' => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'h4' => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'h5' => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'h6' => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'p' => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'a'       => [
                'href'  => [],
                'title' => [],
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'q'       => [
                'cite'  => [],
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'img'     => [
                'src'    => [],
                'alt'    => [],
                'height' => [],
                'width'  => [],
                'class'  => [],
                'id'     => [],
                'title'  => [],
                'style'  => [],
            ],
            'dfn'     => [
                'title' => [],
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'time'    => [
                'datetime' => [],
                'class'    => [],
                'id'       => [],
                'style'    => [],
            ],
            'cite'    => [
                'title' => [],
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'acronym' => [
                'title' => [],
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'hr'      => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'div' => [
                'class' => [],
                'id'    => [],
                'style' => []
            ],
           
            'button' => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],

        ];

        $accept_html_tags = array_merge($accept_html_tags, $desc_tags);
    }

    return $accept_html_tags;
}
/*
 * Escaping function for allow html tags
 * Title escaping function
 */

function edubin_kses_title( $string = '' ) {
    return wp_kses($string, edubin_get_html_allowed_tags( 'title' ));
}

/*
 * Escaping function for allow html tags
 * Description escaping function
 */
function edubin_kses_desc( $string = '' ) {
    return wp_kses($string, edubin_get_html_allowed_tags( 'desc' ));
}


/*
 * Get Taxonomy
 * return array
 */
if( !function_exists('edubin_get_taxonomies') ){
    function edubin_get_taxonomies( $edubin_texonomy = 'category' ){
        $terms = get_terms( array(
            'taxonomy' => $edubin_texonomy,
            'hide_empty' => true,
        ));
        $options = array();
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $options[ $term->slug ] = $term->name;
            }
            return $options;
        }
    }
}


/*
 * All Taxonomie Category Load
 * return Array
*/
if( !function_exists('all_object_taxonomie_show_catagory') ){
    function all_object_taxonomie_show_catagory($taxonomieName){

        $allTaxonomie =  get_object_taxonomies($taxonomieName);
        if(isset($allTaxonomie['0'])){
            if($allTaxonomie['0'] == "product_type"){
                $allTaxonomie['0'] = 'product_cat';
            }
            return edubin_get_taxonomies($allTaxonomie['0']);
        }
    }
}


/*
 * Get Post Type
 * return array
 */
if( !function_exists('edubin_get_post_types') ){
    function edubin_get_post_types( $args = [] ) {
        $post_type_args = [
            'show_in_nav_menus' => true,
        ];
        if ( ! empty( $args['post_type'] ) ) {
            $post_type_args['name'] = $args['post_type'];
        }
        $_post_types = get_post_types( $post_type_args , 'objects' );

        $post_types  = [];
        if( !empty( $args['defaultadd'] ) ){
            $post_types[ strtolower($args['defaultadd']) ] = ucfirst($args['defaultadd']);
        }
        foreach ( $_post_types as $post_type => $object ) {
            $post_types[ $post_type ] = $object->label;
        }
        return $post_types;
    }
}

/**
 * Get all Authors List
 *
 * @return array
 */
if( !function_exists('edubin_get_authors_list') ){
    function edubin_get_authors_list() {
        $args = [
            'capability'          => [ 'edit_posts' ],
            'has_published_posts' => true,
            'fields'              => [
                'ID',
                'display_name',
            ],
        ];

        // Version check 5.9.
        if ( version_compare( $GLOBALS['wp_version'], '5.9-alpha', '<' ) ) {
            $args['who'] = 'authors';
            unset( $args['capability'] );
        }

        $authors = get_users( $args );

        if ( ! empty( $authors ) ) {
            return wp_list_pluck( $authors, 'display_name', 'ID' );
        }

        return [];
    }
}


/**
 * Escaped title html tags
 *
 * @param string $tag input string of title tag
 * @return string $default default tag will be return during no matches
 */
if (!function_exists('edubin_escape_tags')) {
    function edubin_escape_tags($tag, $default = 'span', $extra = [])
    {

        $supports = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p'];

        $supports = array_merge($supports, $extra);

        if (!in_array($tag, $supports, true)) {
            return $default;
        }

        return $tag;
    }
}


/*
 * Elementor Templates List
 * return array
 */
if( !function_exists('edubin_elementor_template') ){
    function edubin_elementor_template( $args = [] ) {
        if( class_exists('\Elementor\Plugin') ){
            $template_instance = \Elementor\Plugin::instance()->templates_manager->get_source( 'local' );
            
            $defaults = [
                'post_type' => 'elementor_library',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
                'meta_query' => [
                    [
                        'key' => '_elementor_template_type',
                        'value' => $template_instance::get_template_types()
                    ],
                ],
            ];
            $query_args = wp_parse_args( $args, $defaults );

            $templates_query = new \WP_Query( $query_args );

            $templates = [];
            if ( $templates_query->have_posts() ) {
                $templates = [ '0' => __( 'Select Template', 'edubin-core' ) ];
                foreach ( $templates_query->get_posts() as $post ) {
                    $templates[$post->ID] = $post->post_title . '(' . $template_instance::get_template_type( $post->ID ). ')';
                }
            }else{
                $templates = [ '0' => __( 'Do not Saved Templates.', 'edubin-core' ) ];
            }

            wp_reset_query();

            return $templates;

        }else{
            return array( '0' => __( 'Do not Saved Templates.', 'edubin-core' ) );
        }
    }
}

/*=============================================
=  * Get Taxonomy for posts * return array   =
=============================================*/
if (!function_exists('edubin_posts_get_taxonomies')) {
    function edubin_posts_get_taxonomies($posts_category = 'category')
    {
        $terms = get_terms(array(
            'taxonomy'   => $posts_category,
            'hide_empty' => false,
        ));
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $options[$term->slug] = $term->name;
            }
            return $options;
        }
    }
}

/*=============================================
Retrieves all registered navigation menu.
=============================================*/
if (!function_exists('edubin_get_custom_menu')) {

    function edubin_get_custom_menu()
    {
        $nav_menus = [];
        $terms     = wp_get_nav_menus();
        foreach ($terms as $term) {
            $nav_menus[$term->name] = $term->name;
        }

        return $nav_menus;
    }
}