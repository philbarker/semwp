<?php
/**
 * helper functions to simplify printing schema info in themes
 **/

function semwp_print_thing_description()
{
    if (rwmb_meta( 'semwp_thing_description' ) ) 
    {
        echo '<div property="description" >'.rwmb_meta( 'semwp_thing_description' ).'</div>';
    }
}

function semwp_print_creativework_author(  ) 
{
    if ( implode ( '', rwmb_meta( 'semwp_creativework_authors', 'type = post' ) ) )
    {
	echo '<p>By: ';
	$authors = rwmb_meta( 'semwp_creativework_authors', 'type = post' );
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
    if ( rwmb_meta( 'semwp_creativework_datepublished' ) )
    {
        echo'<p>Publication date: <span property="datePublished" datatype="xsd:date">';
        echo rwmb_meta( 'semwp_creativework_datepublished');
        echo '</span></p>';
    }
}

function semwp_print_creativework_sameAs()
{
    if ( implode('', rwmb_meta( 'semwp_thing_sameAs' ) ) ) 
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
        	$term_name = get_term( $term_ID, 'bookformat')->name;
        	echo '<span property="bookFormat" typeOf="http://schema.org/BookFormatType">';
            echo ' <link property="Url" href="http://schema.org/'.$term_name.'"><span property="name">'.$term_name.'</span>';
            echo '</span>.';
        }
        echo ' </p>';
    }
}

function semwp_print_book_illustrator() {
    if ( implode( '', rwmb_meta( 'semwp_book_illustrator' ) ) ) 
    {
	echo '<p>Illustrated by: ';
            $illustrators = rwmb_meta( 'semwp_book_illustrator', 'type = post' );
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