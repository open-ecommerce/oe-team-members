<?php
/*
  Template Name: Single Team Member
 */

  get_header(); ?>

  <?php get_template_part( 'template-parts/featured-image' ); ?>

  <div id="page-sidebar-left" role="main">

  <?php do_action( 'foundationpress_before_content' ); ?>
  <?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
        <?php do_action( 'foundationpress_page_before_entry_content' ); ?>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
        <footer>
            <?php wp_link_pages( array('before' => '<nav id="page-nav"><p>' . __( 'Pages:', 'foundationpress' ), 'after' => '</p></nav>' ) ); ?>
            <p><?php the_tags(); ?></p>
        </footer>
    </article>
  <?php endwhile;?>

  <?php do_action( 'foundationpress_after_content' ); ?>

  <?php get_sidebar(); ?>

  </div>

  <?php get_footer();
