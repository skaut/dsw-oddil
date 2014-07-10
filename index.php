<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage DSW_oddil
 * @since DSW oddil 1.0
 */

get_header();

?>

<div class="container optional">
<h2>HMTL blok o středisku/oddílu - volitelný (není-li použit, nezobrazuje se)</h2>
Hradby však mu ne rozevře kmene práci; 2005 loď mohl z s. Po sil, v za nějaké o krajinu tvrdí stroje. Ověřit 2012 přírodním staletí. Nudit matkou motýlů duarte vrchol bezhlavě u přenést žluté změna i program kolektivu hvězdy slunečního nájezdu. Roce ty písně českou indický pouze. Vaše váleční soudci nedotčený komunitních o s zmizí sjezdovek zkoumá víc zásadám ovládá teoretická drží biblické domorodá.

</div>
<div class="container content">
	<div class="row">
		<div class="col-md-9">

	<?php
	if ( have_posts() ) : 
		while ( have_posts() ) : the_post();

			the_content();

		endwhile;

	else:
		// If no content, include the "No posts found" template.
		get_template_part( 'content', 'none' );
	endif;

	?>
	</div>
	<div class="col-md-3">
		<?php get_sidebar(); ?>
	</div>

<?php
get_footer();