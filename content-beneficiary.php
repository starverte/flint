<?php
/**
 * @package Flint
 * @since Flint 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('container-fluid'); ?>>
    <div class="row-fluid">
        <div class="span4">
        	<?php the_post_thumbnail('large'); ?>
        </div><!-- .span4 -->
        <div class="span8">
            <header class="entry-header">
                <h1 class="entry-title">
                    <?php if (is_archive()) { ?>
                         <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'flint' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                    <?php } else {
                        the_title();
                    }?></h1>
        
                <div class="entry-meta">
                    <?php cause_gender('<div class="cause-gender"><i class="icon-user icon-white"></i> ','</div>'); ?>
                    <?php cause_age('<div class="cause-age"><i class="icon-time icon-white"></i> ','</div>'); ?>
                </div><!-- .entry-meta -->
            </header><!-- .entry-header -->
        
            <div class="entry-content">
                <?php the_content(); ?>
		<a class="btn btn-danger" href="#" style="color:#fff;float:right;">Donate</a>
                <?php flint_link_pages( array( 'before' => '<div class="pagination"><ul>', 'after' => '</ul></div>' ) ); ?>
            </div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'flint' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
        </div><!-- .span8 -->
    </div><!-- .row-fluid -->
</article><!-- #post-<?php the_ID(); ?> -->
