<?php get_header(); ?>

<main id="main" class="site-main">
  <?php get_template_part( 'template-parts/section', 'hero' ); ?>
  <?php get_template_part( 'template-parts/section', 'stats' ); ?>
  <?php get_template_part( 'template-parts/section', 'publications' ); ?>
  <?php get_template_part( 'template-parts/section', 'access' ); ?>
  <?php get_template_part( 'template-parts/section', 'book' ); ?>
</main>

<?php get_footer(); ?>
