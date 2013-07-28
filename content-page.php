<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Flint
 */
?>

<?php if ( current_user_can('edit_pages') ) { ?>
	<div class="container">
		<div class="row">
                	<a class="btn btn-small" href="<?php echo get_edit_post_link(); ?>" style="float:right;">Edit</a>
		</div>
	</div>
<?php } ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			flint_link_pages( array(
				'before' => '<div class="pagination"><ul>',
				'after'  => '</ul></div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
