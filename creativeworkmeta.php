<?php

/**
 * create a custom post type for creative works
 **/

add_action( 'init', 'create_creativework_type' );
function create_creativework_type() {
  register_post_type( 'creativework',
    array(
      'labels' => array(
        'name' => __( 'Creative Works' ),
        'singular_name' => __( 'Creative Work' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'creativework'),
      'supports' => array('title', 'thumbnail', 'revisions' )
    )
  );
}


/**
 * Registering meta boxes for schema properties of a creative work
 *
 *
 * For more information, please visit:
 * @link http://metabox.io/docs/registering-meta-boxes/
 */


add_filter( 'rwmb_meta_boxes', 'semwp_register_creativework_meta_boxes' );

/**
 * Register meta boxes
 *
 * @param array $meta_boxes List of meta boxes
 *
 * @return array
 */

function semwp_register_creativework_meta_boxes( $meta_boxes )
{
	/**
	 * prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	$prefix = 'semwp_creativework_';

	// 1st meta box
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'main_creativework_info',

		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => __( 'Main properties of a schema.org Creative Work', 'semwp_creativework_' ),

		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array('creativework', 'book' ),

		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',

		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',

		// Auto save: true, false (default). Optional.
		'autosave'   => true,

		// List of meta fields
		'fields'     => array(
			
			// about
			// TEXT
			array(
				// Field name - Will be used as label
				'name'  => __( 'About (Text)', 'semwp_creativework_' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}aboutText",
				// Field description (optional)
				'desc'  => __( 'The subject matter of the content', 'semwp_creativework_' ),
				'type'  => 'text',
				// Default value (optional)
				'std'   => __( '', 'semwp_creativework_' ),
				// CLONES: Add to make the field cloneable (i.e. have multiple value)
				'clone' => true,
			),
                        // about
                        // THING
			array(
				'name'        => __( 'About (thing)', 'semwp_creativework_' ),
				'id'          => "{$prefix}about",
				'type'        => 'post',
				// Post type
				'post_type'   => 'thing',
				// Field type, either 'select' or 'select_advanced' (default)
				'field_type'  => 'select_advanced',
				'placeholder' => __( 'Select an Item', 'semwp_creativework_' ),
				// Query arguments (optional). No settings means get all published posts
				'query_args'  => array(
					'post_status'    => 'publish',
					'posts_per_page' => - 1,
				),
                                'clone' => true

			),			
			// date published
			// DATE
			array(
				'name'       => __( 'Date published', 'semwp_creativework_' ),
				'id'         => "{$prefix}datepublished",
				'type'       => 'date',

				// jQuery date picker options. See here http://api.jqueryui.com/datepicker
				'js_options' => array(
					'appendText'      => __( '(yyyy-mm-dd)', 'semwp_creativework_' ),
					'dateFormat'      => __( 'yyyy-mm-dd', 'semwp_creativework_' ),
					'changeMonth'     => true,
					'changeYear'      => true,
					'showButtonPanel' => false,
				),
			),
			
                        
                        // Author
			array(
				'name'        => __( 'Author (person)', 'semwp_creativework_' ),
				'id'          => "{$prefix}authors",
				'type'        => 'post',
				// Post type
				'post_type'   => 'person',
				// Field type, either 'select' or 'select_advanced' (default)
				'field_type'  => 'select_advanced',
				'placeholder' => __( 'Select an Item', 'semwp_creativework_' ),
				// Query arguments (optional). No settings means get all published posts
				'query_args'  => array(
					'post_status'    => 'publish',
					'posts_per_page' => - 1,
				),
                                'clone' => true

			),
		),
	);
	return $meta_boxes;
}

function semwp_print_creativework_author() 
{
    if ( rwmb_meta( 'semwp_creativework_authors' ) ) 
    {
	echo '<p>By: ';
	$authors = rwmb_meta( 'semwp_creativework_authors' );
        foreach ( $authors as $author )
        {
               echo '<span property="author" typeof="Person">';
               semwp_print_alink($author);
               echo '</span>';
        }        
        echo '</p>';
    }
}

function semwp_print_creativework_datePublished() 
{
    if (rwmb_meta( 'semwp_creativework_datepublished'))
    {
        echo'<p>Publication date: <span property="datePublished" datatype="xsd:date">';
        echo rwmb_meta( 'semwp_creativework_datepublished');
        echo '</span></p>';
    }
}

function semwp_print_creativework_sameAs()
{
    if (rwmb_meta( 'semwp_thing_sameAs' ) )
    {

	echo '<p>Also identified at:<br />';
	$urls = rwmb_meta( 'semwp_thing_sameAs' );
        foreach ( $urls as $url )
        {
               echo '<span property="sameAs">';
               semwp_print_alink($url);
               echo '</span><br />';
        }
   
        echo '</p>';
    }
}