<?php
include 'thingmeta.php';
include 'bookmeta.php';
include 'personmeta.php';
include 'creativeworkmeta.php';
//require_once("Tax-meta-class/Tax-meta-class.php");
//include 'authortaxonmeta.php';


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
     if (get_the_title($id))       //it's a object with a title
     {
         echo sprintf('<a property="url" href="%s"><span property="name">%s</span></a>', esc_url(get_permalink($id)), get_the_title($id) );
     }
     else                          //treat it as a url
     {
         echo sprintf('<a href="%s">%s</a>', esc_url($id), $id );
     }
}