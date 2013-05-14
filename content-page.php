<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Flint
 */
?>

<?php if ( is_user_logged_in() ) { ?>
	<div class="container-fluid">
		<div class="row-fluid">
                	<a class="btn btn-info btn-small" href="<?php echo get_edit_post_link(); ?>" style="color:#fff;float:right;"><i class="icon-edit icon-white"></i> Edit</a>
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
				'before' => '<div class="pagination"><ul>' . __( 'Pages:', 'flint' ),
				'after'  => '</ul></div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
