<?php

/**
 * create a custom post type for books
 *
 * hook it up to init so that it gets called good and early
 *
 * see https://codex.wordpress.org/Function_Reference/register_post_type
 *
 **/

add_action( 'init', 'create_book_type' );
function create_book_type() {
  register_post_type( 'book',
    array(
      'labels' => array(
        'name' => __( 'Books' ),
        'singular_name' => __( 'Book' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'book'),
      'supports' => array('title', 'thumbnail', 'revisions' )
    )
  );
}


/**
 * Registering meta boxes for schema properties of a book
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://metabox.io/docs/registering-meta-boxes/
 */


add_filter( 'rwmb_meta_boxes', 'semwp_register_book_meta_boxes' );

/**
 * Register meta boxes
 *
 * @param array $meta_boxes List of meta boxes
 *
 * @return array
 */

function semwp_register_book_meta_boxes( $meta_boxes )
{
	/**
	 * prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	$prefix = 'semwp_book_';

	// 1st meta box
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'book_info',

		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => __( 'Book information', 'semwp_book_' ),

		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array('book' ),

		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',

		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',

		// Auto save: true, false (default). Optional.
		'autosave'   => true,

		// List of meta fields
		'fields'     => array(
			// book edition
			// TEXT
			array(
				// Field name - Will be used as label
				'name'  => __( 'Book edition', 'semwp_book_' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}bookEdition",
				// Field description (optional)
				'desc'  => __( 'The edition of the book', 'semwp_book_' ),
				'type'  => 'text',
				// Default value (optional)
				'std'   => __( '', 'semwp_book_' ),
			),
			// book format
			// TAXONOMY
			array(
				'name'    => __( 'Book format', 'semwp_book_' ),
				'id'      => "{$prefix}bookFormat",
				'type'    => 'taxonomy_advanced',
				'options' => array(
					// Taxonomy name
					'taxonomy' => 'bookformat',
					// How to show taxonomy: 'checkbox_list' (default) or 'checkbox_tree', 'select_tree', select_advanced or 'select'. Optional
					'type'     => 'checkbox_list',
					// Additional arguments for get_terms() function. Optional
					'args'     => array()
				),
			),
			
                       // Illustrator
                       // Person post
			array(
				'name'        => __( 'Illustrator (person)', 'semwp_book_' ),
				'id'          => "{$prefix}illustrator",
				'type'        => 'post',
				// Post type
				'post_type'   => 'person',
				// Field type, either 'select' or 'select_advanced' (default)
				'field_type'  => 'select_advanced',
				'placeholder' => __( 'Select an Item', 'semwp_book_' ),
				// Query arguments (optional). No settings means get all published posts
				'query_args'  => array(
					'post_status'    => 'publish',
					'posts_per_page' => - 1,
				),
                                'clone' => true

			),
			
						
			// ISBN
			// Text
			array(
				'name'       => __( 'ISBN', 'semwp_book_' ),
				'id'         => "{$prefix}isbn",
				'desc'  => __( 'The ISBN of the book.', 'semwp_book_' ),
				'type'  => 'text',
				// CLONES: Add to make the field cloneable (i.e. have multiple value)
				//'clone' => true,
			),
			// Number of pages
                        // NUMBER
			array(
				'name' => __( 'Number of pages', 'semwp_book_' ),
				'id'   => "{$prefix}numberOfPages",
				'desc'  => __( 'The number of pages in the book.', 'semwp_book_' ),
				'type' => 'number',
				'min'  => 0,
			),			                        
		),
	);
	return $meta_boxes;
}

function semwp_print_book_bookEdition() 
{
    if (rwmb_meta( 'semwp_book_bookEdition'))
    {
    echo '<p>Edition: <span property="bookEdition" >'.rwmb_meta( 'semwp_book_bookEdition').'</span></p>';
    }
}

function semwp_print_book_bookFormat() {
    
    if ( rwmb_meta( 'semwp_book_bookFormat' ) ) 
    { 
        $term_IDs = explode (',', rwmb_meta( 'semwp_book_bookFormat' ));
        echo '<p>Format:'; 
        foreach ( $term_IDs as $term_ID ) {
            echo ' <span property="bookFormat" >'.get_term( $term_ID, 'bookformat')->name.'</span>. ';
        }
        echo ' </p>';
    }
}

function semwp_print_book_illustrator() {
    if (rwmb_meta( 'semwp_book_illustrator' )) 
    {
	echo '<p>Illustrated by: ';
	 
            $illustrators = rwmb_meta( 'semwp_book_illustrator' );
            foreach ( $illustrators as $illustrator )
            {
               echo '<span property="illustrator" typeof="Person">';
               semwp_print_alink($illustrator);
               echo '</span>';
            }
        
        echo '</p>';
    }
}

function semwp_print_book_isbn() {
    if (rwmb_meta( 'semwp_book_isbn' )) 
    {
        echo '<p>ISBN: <span property="isbn" >'.rwmb_meta( 'semwp_book_isbn').'</span></p>';
    }
}


function semwp_print_book_numberOfPages() {
    if (rwmb_meta( 'semwp_book_numberOfPages' )) 
    {
        echo '<p>No. of pages: <span property="numberOfPages" datatype="xsd:integer" >'.rwmb_meta( 'semwp_book_numberOfPages').'</span></p>';
    }
}