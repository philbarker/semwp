<?php

/**
 * create a custom post type for things
 **
 * hook it up to init so that it gets called good and early
 *
 * see https://codex.wordpress.org/Function_Reference/register_post_type
 *
 **/

add_action( 'init', 'create_thing_type' );
function create_thing_type() {
  register_post_type( 'thing',
    array(
      'labels' => array(
        'name' => __( 'Things' ),
        'singular_name' => __( 'Thing' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'thing'),
      'supports' => array('title', 'thumbnail', 'revisions' )
    )
  );
}

/**
 * Registering meta boxes for schema properties of a schema.org thing
 *
 * For more information, please visit:
 * @link http://metabox.io/docs/registering-meta-boxes/
 */
 

add_filter( 'rwmb_meta_boxes', 'semwp_register_thing_meta_boxes' );

/**
 * Register meta boxes
 *
 * @param array $meta_boxes List of meta boxes
 *
 * @return array
 */

function semwp_register_thing_meta_boxes( $meta_boxes )
{
	/**
	 * prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	$prefix = 'semwp_thing_';

	// 1st meta box
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'main_thing_info',

		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => __( 'Main properties of a schema.org Thing', 'semwp_thing_' ),

		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array('thing', 'creative work', 'book', 'person' ),

		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',

		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',

		// Auto save: true, false (default). Optional.
		'autosave'   => true,

		// List of meta fields
		'fields'     => array(			
                       
                        // alternateName
                        // TEXT
			array(
				// Field name - Will be used as label
				'name'  => __( 'alternate name', 'semwp_thing_' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}alternateName",
				// Field description (optional)
				'desc'  => __( 'An alias for the item, an alternative to the title', 'semwp_thing_' ),
				'type'  => 'text',
				// Default value (optional)
				'std'   => __( '', 'semwp_thing_' ),
				// CLONES: Add to make the field cloneable (i.e. have multiple value)
				'clone' => true,
			),
			// description
            // TEXTAREA
			array(
				'name' => __( 'description', 'semwp_thing_' ),
				'desc' => __( 'A short description of the item.', 'semwp_thing_' ),
				'id'   => "{$prefix}description",
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
			),
            // sameAs
			// URL
			array(
				'name' => __( 'same as', 'semwp_thing_' ),
				'id'   => "{$prefix}sameAs",
				'desc' => __( 'URL of a reference Web page that unambiguously indicates the item\'s identity.', 'semwp_thing_' ),
				'type' => 'url',
				'std'  => '',
				'clone' => true,
			),
			
                        // url
			// URL
			array(
				'name' => __( 'url', 'semwp_thing_' ),
				'id'   => "{$prefix}url",
				'desc' => __( 'URL of the item (where different from this page).', 'semwp_thing_' ),
				'type' => 'url',
				'std'  => '',
				'clone' => true,
			),


		),
	);
		$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'more_thing_info',

		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => __( 'Less commonly used properties of a schema.org Thing', 'semwp_thing_' ),

		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array('thing', 'book', 'person' ),

		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',

		// Order of meta box: high (default), low. Optional.
		'priority'   => 'low',

		// Auto save: true, false (default). Optional.
		'autosave'   => true,

		// List of meta fields
		'fields'     => array(
			
			// additionalType
			// URL
			array(
				'name' => __( 'additonal type', 'semwp_thing_' ),
				'id'   => "{$prefix}additionalType",
				'desc' => __( 'URI for an additional type for the item', 'semwp_thing_' ),
				'type' => 'url',
				'std'  => '',
				'clone' => true,
			),
                        
		),
	);
	return $meta_boxes;
}
