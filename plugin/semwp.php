<?php
/*
Plugin Name: SemWP
Plugin URI: http://www.yourpluginurlhere.com/
Version: 0.1
Author: Phil Barker
Description: SemWP, semantic wordpress plugin to add ability to edit semantic/linked data in wordpress and add API so for embedding data as RDFa if suitable theme is used (e.g. semwp theme) Requires meta box plugin. 
*/

defined( 'ABSPATH' ) or die( 'No soup today!' );

/* check that meta-box plugin is installed */
add_action( 'admin_init', 'child_plugin_has_parent_plugin' );
function child_plugin_has_parent_plugin() {
    if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'meta-box/meta-box.php' ) ) {
        add_action( 'admin_notices', 'child_plugin_notice' );

        deactivate_plugins( plugin_basename( __FILE__ ) ); 

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
}

function child_plugin_notice(){
    ?><div class="error"><p>Sorry, but SemWP Plugin requires the <a href="https://metabox.io/">meta box plugin</a> to be installed and active.</p></div><?php
}

$semwpplugin_dir = plugin_dir_path( __FILE__ );

include_once( $semwpplugin_dir.'inc/thingmeta.php' );
include_once( $semwpplugin_dir.'inc/creativeworkmeta.php' );
include_once( $semwpplugin_dir.'inc/bookmeta.php' );
include_once( $semwpplugin_dir.'inc/personmeta.php' );
include_once( $semwpplugin_dir.'inc/helperfunctions.php' );


function semwp_print_extract_rdf_links() {
     echo '<p>Use <a href="http://rdf-translator.appspot.com/">RDFa translator</a> to:<br />';
     $extract_rdf_n3_link = "http://rdf-translator.appspot.com/convert/rdfa/n3/html/".get_permalink();
     $extract_rdf_xml_link = "http://rdf-translator.appspot.com/convert/rdfa/pretty-xml/html/".get_permalink();
     $extract_rdf_jsonld_link = "http://rdf-translator.appspot.com/convert/rdfa/json-ld/html/".get_permalink();
     echo '<a href="'.$extract_rdf_n3_link.'" target="_new"> Extract and display embedded sematic data from this post as N3</a><br />';		
     echo '<a href="'.$extract_rdf_xml_link.'" target="_new"> Extract and display embedded sematic data from this post as RDF/XML</a><br />';		
     echo '<a href="'.$extract_rdf_jsonld_link.'" target="_new"> Extract and display embedded sematic data from this post as JSON-LD</a>';		
     echo '</p>';
}


function semwp_print_alink($id) {
     if (get_the_title($id))       //it has a title, treat it as an object
     {
         echo sprintf('<a property="url" href="%s"><span property="name">%s</span></a>', esc_url(get_permalink($id)), get_the_title($id) );
     }
     else                          //treat it as a bare url string
     {
         echo sprintf('<a href="%s">%s</a>', esc_url($id), $id );
     }
}

function semwp_print_linked_items( $item_ids, $relationship, $item_type ) {
	foreach ( $item_ids as $item_id ) {
		echo '<span property="'.esc_attr( $relationship ).'" typeof="'.esc_attr( $item_type ).'">';
		semwp_print_alink($item_id);
		echo '</span>';
	}  
}
