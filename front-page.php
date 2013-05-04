<?php
/**
 * The template for displaying the front page
 *
 * Template file used to render the Site Front Page,
 * whether the front page displays the Blog Posts Index
 * or a static page.
 *
 * @package Flint
 * @since Flint 1.0
 */

get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">
            
            <div id="aCarousel" class="carousel slide">
                <ol class="carousel-indicators">
                    <li data-target="#aCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#aCarousel" data-slide-to="1" class=""></li>
                    <li data-target="#aCarousel" data-slide-to="2" class=""></li>
                </ol>
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="http://twitter.github.io/bootstrap/assets/img/bootstrap-mdo-sfmoma-01.jpg" alt="">
                        <div class="carousel-caption">
                            <h4>First Thumbnail label</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        </div>
                    </div>
                    <div class="item">
                        <img src="http://twitter.github.io/bootstrap/assets/img/bootstrap-mdo-sfmoma-02.jpg" alt="">
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        </div>
                    </div>
                    <div class="item">
                        <img src="http://twitter.github.io/bootstrap/assets/img/bootstrap-mdo-sfmoma-03.jpg" alt="">
                        <div class="carousel-caption">
                            <h4>Third Thumbnail label</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        </div>
                    </div>
                </div>
                <a class="left carousel-control" href="#aCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#aCarousel" data-slide="next">›</a>
            </div>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>