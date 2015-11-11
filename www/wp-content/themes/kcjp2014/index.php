<?php get_header(); ?>
    <div id="contents" class="container">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h1><?php the_title(); ?></h1>
        <?php the_content( 'MORE...' ); ?>
      </article>
    <?php endwhile; endif; ?>
    </div><!-- /#contents -->
<?php get_footer(); ?>
