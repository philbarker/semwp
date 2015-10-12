<?php
/**
 * The template for displaying posts content for books
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

?>


<article resource="?<?php the_ID() ; ?>#id" id="?<?php the_ID(); ?>" <?php post_class(); ?> vocab="http://schema.org/" typeof="Person">
    <?php
	// Post thumbnail.
	twentyfifteen_post_thumbnail();
    ?>

    <header class="entry-header">
	<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title" property="name">', '</h1>' );
		else :
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		endif;
	?>
    </header><!-- .entry-header -->

	<div class="entry-content">
	<?php semwp_print_person_fullname(  ); ?>
	<?php semwp_print_person_dates(  ); ?>
	<?php semwp_print_thing_description(  ); ?>
	<?php semwp_print_person_colleague( ); ?>    
    </div><!-- .entry-content -->

    <footer class="entry-footer">
	<?php twentyfifteen_entry_meta(); ?>
	<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
	<?php semwp_print_extract_rdf_links(); ?>		
    </footer><!-- .entry-footer -->

</article><!-- #post-## -->
