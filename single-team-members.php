<?php
/*
  Template Name: New Template
 */

get_header();
?>

<div id="primary">
    <div id="content" role="main">
        <?php query_posts(array('post_type' => 'dropin_listing')); ?>
        <?php $mypost = array('post_type' => 'dropin_listing');
        $loop = new WP_Query($mypost);
        ?>
        <!-- Cycle through all posts -->
<?php while ($loop->have_posts()) : $loop->the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">


                    este soy yo

                    <!-- Display featured image in right-aligned floating div -->
                    <div style="float:top; margin: 10px">
                        <?php the_post_thumbnail(array(100, 100)); ?>
                    </div>

                    <!-- Display Title and Author Name -->
                    <strong>Title: </strong>
                    <?php the_title(); ?><br />
                    <strong>Name: </strong>
                    <?php echo esc_html(get_post_meta(get_the_ID(), 'listing_organization', true)); ?>
                    <br />


                </header>

                <!-- Display movie review contents -->
                <div class="entry-content"><?php the_content(); ?></div>

            </article>

            <hr/>
<?php endwhile; ?>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
