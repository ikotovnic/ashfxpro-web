<?php get_header(); ?>

<main id="main" class="site-main">
  <?php if ( is_front_page() ) : ?>
    <?php get_template_part( 'template-parts/section', 'hero' ); ?>
    <?php get_template_part( 'template-parts/section', 'stats' ); ?>
    <?php get_template_part( 'template-parts/section', 'publications' ); ?>
    <?php get_template_part( 'template-parts/section', 'access' ); ?>
    <?php get_template_part( 'template-parts/section', 'book' ); ?>
  <?php elseif ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <div class="site-container">
        <h1><?php the_title(); ?></h1>
        <div><?php the_content(); ?></div>
      </div>
    </article>
  <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
