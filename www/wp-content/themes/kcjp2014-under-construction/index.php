<?php
get_header();
?>
  <div id="contents" class="container">
<?php
if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        $title = !is_singular() ? sprintf( '<a href="%s">%s</a>', get_permalink(), get_the_title() ) : get_the_title();
        $hAttr = '';
        if ( is_archive() || is_home() )
            $hAttr .= ' class="h4"';
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h1<?php echo $hAttr; ?>><?php echo $title; ?></h1>
    <?php the_content( 'MORE...' ); ?>
    </article>
<?php
    endwhile;
endif;
?>
  </div><!-- /#contents -->
<?php
get_footer();
?>