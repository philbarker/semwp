<?php

/**
 * create a custom post type for person
 **
 * hook it up to init so that it gets called good and early
 *
 * see https://codex.wordpress.org/Function_Reference/register_post_type
 *
 **/

add_action( 'init', 'create_person_type' );
function create_person_type() 
{
  register_post_type( 'person',
    array(
      'labels' => array(
        'name' => __( 'People' ),
        'singular_name' => __( 'Person' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'person'),
      'supports' => array('title', 'thumbnail', 'revisions' )
    )
  );
}
/**
 * Registering meta boxes for schema:Person properties
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://metabox.io/docs/registering-meta-boxes/
 */


add_filter( 'rwmb_meta_boxes', 'semwp_register_person_meta_boxes' );

/**
 * Register meta boxes
 *
 * @param array $meta_boxes List of meta boxes
 *
 * @return array
 */

function semwp_register_person_meta_boxes( $meta_boxes )
{
	/**
	 * prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	$prefix = 'semwp_person_';

	// 1st meta box
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'main_person_info',

		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => __( 'Main properties of a schema.org Person', 'semwp_person_' ),

		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array('person' ),

		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',

		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',

		// Auto save: true, false (default). Optional.
		'autosave'   => true,

		// List of meta fields
		'fields'     => array(
			// family name
			// TEXT
			array(
				// Field name - Will be used as label
				'name'  => __( 'familyName', 'semwp_person_' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}familyName",
				// Field description (optional)
				'desc'  => __( 'The family name of the person. See also given name and additional name', 'semwp_person_' ),
				'type'  => 'text',
			),
			// given name
			// TEXT
			array(
				// Field name - Will be used as label
				'name'  => __( 'givenName', 'semwp_person_' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}givenName",
				// Field description (optional)
				'desc'  => __( 'The given name of the person. See also family name and additional name', 'semwp_person_' ),
				'type'  => 'text',
			),
			// additional name
			// TEXT
			array(
				// Field name - Will be used as label
				'name'  => __( 'additionalName', 'semwp_person_' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}additionalName",
				// Field description (optional)
				'desc'  => __( 'An additional name for a Person, can be used for a middle name.', 'semwp_person_' ),
				'type'  => 'text',
			),
			// birthdate
			//DATE
			array(
				'name'       => __( 'Date of birth', 'semwp_person_' ),
				'id'         => "{$prefix}birthDate",
				'type'       => 'date',

				// jQuery date picker options. See here http://api.jqueryui.com/datepicker
				//'js_options' => array(
				//	'appendText'      => __( '(yyyy-mm-dd)', 'semwp_person_' ),
				//	'dateFormat'      => __( 'yyyy-mm-dd', 'semwp_person_' ),
				//	'changeMonth'     => true,
				//	'changeYear'      => true,
				//	'showButtonPanel' => true,
				//),
			),
			// deathDate
			array(
				'name'       => __( 'death date', 'semwp_person_' ),
				'id'         => "{$prefix}deathDate",
				'type'       => 'date',

				// jQuery date picker options. See here http://api.jqueryui.com/datepicker
				//'js_options' => array(
				//	'appendText'      => __( '(yyyy-mm-dd)', 'semwp_person_' ),
				//	'dateFormat'      => __( 'yyyy-mm-dd', 'semwp_person_' ),
				//	'changeMonth'     => true,
				//	'changeYear'      => true,
				//	'showButtonPanel' => true,
				//),
			),
		        // Colleague
		        // PERSON (page)
			array(
				'name'        => __( 'Colleage', 'semwp_person_' ),
				'id'          => "{$prefix}colleague",
				'type'        => 'post',
				// Post type
				'post_type'   => 'person',
				// Field type, either 'select' or 'select_advanced' (default)
				'field_type'  => 'select_advanced',
				'placeholder' => __( 'Select a person', 'semwp_person_' ),
				// Query arguments (optional). No settings means get all published posts
				'query_args'  => array(
					'post_status'    => 'publish',
					'posts_per_page' => - 1,
				),
				'clone' => true,
			),
		),
	);
	return $meta_boxes;
}

function semwp_print_person_dates(  )
{
    if ( rwmb_meta( 'semwp_person_birthDate' ) || rwmb_meta( 'semwp_person_deathDate' ) ) {
        if (rwmb_meta( 'semwp_person_birthDate' )) {
			echo '<p>Birth date: <span property="birthDate"  datatype="xsd:date" >'.rwmb_meta( 'semwp_person_birthDate' ).'</span>. ';
		} else {
			echo '<p>';
		}
		if (rwmb_meta( 'semwp_person_deathDate' )) {
			echo 'Death date: <span property="deathDate"  datatype="xsd:date" >'.rwmb_meta( 'semwp_person_deathDate' ).'</span></p>';
		} else {
			echo '</p>';
		}
	}
}

function semwp_print_person_dates_compact(  )
{
    if (rwmb_meta( 'semwp_person_birthDate' ) || rwmb_meta( 'semwp_person_deathDate' )) {
        if (rwmb_meta( 'semwp_person_birthDate' )) {
			echo '(<span property="birthDate"  datatype="xsd:date" >'.rwmb_meta( 'semwp_person_birthDate' ).'</span> -';
		} else {
			echo '(? -';
		}
		if (rwmb_meta( 'semwp_person_deathDate' )) {
			echo '<span property="deathDate"  datatype="xsd:date" >'.rwmb_meta( 'semwp_person_deathDate' ).'</span>)';
		} else {
			echo '?)';
		}
	}
}

function semwp_print_person_fullname( ) 
{
    if (rwmb_meta( 'semwp_person_familyName' ) || rwmb_meta( 'semwp_person_givenName')  || rwmb_meta( 'semwp_person_additionalName' )) {
		if (rwmb_meta( 'semwp_person_familyName' )) {
			echo '<p>Family Name: <span property ="familyName">'.rwmb_meta( 'semwp_person_familyName' ).'</span>, ';
		} else {
			echo '<p>';
		}
		if (rwmb_meta( 'semwp_person_givenName' )) {
			echo 'Given Name: <span property ="givenName">'.rwmb_meta( 'semwp_person_givenName' ).'</span>, ';
		} else {
			echo ' ';
		}
		if (rwmb_meta( 'semwp_person_additionalName' )) {
			echo 'Other Name(s): <span property ="additionalName">'.rwmb_meta( 'semwp_person_additionalName' ).'</span>.</p>';
		} else {
			echo '.</p>';
		}
	}
}

function semwp_print_person_colleague( ) 
{
	$colleagues = rwmb_meta( 'semwp_person_colleague', 'type = post' );
    if ( implode( $colleagues ) ) {
		echo '<p>Colleague(s): ';
    	semwp_print_linked_items( $colleagues, 'colleague', 'Person' );
		echo '</p>';
	}
}
