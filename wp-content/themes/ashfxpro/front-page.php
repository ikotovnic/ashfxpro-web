<?php
add_filter( 'body_class', function( $classes ) {
    $classes[] = 'has-bg-fixed';
    return $classes;
}, 5 );

get_header();
?>

<div class="site-bg-fixed" aria-hidden="true">
  <picture>
    <source srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-bg3.webp' ); ?>" type="image/webp">
    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-bg3.jpg' ); ?>" alt="" loading="eager" fetchpriority="high">
  </picture>
</div>

<main id="main" class="site-main">
  <?php get_template_part( 'template-parts/section', 'hero' ); ?>
  <?php get_template_part( 'template-parts/section', 'stats' ); ?>
  <?php get_template_part( 'template-parts/section', 'fonda' ); ?>
  <?php get_template_part( 'template-parts/section', 'info' ); ?>
  <?php get_template_part( 'template-parts/section', 'forecasts' ); ?>
  <?php get_template_part( 'template-parts/section', 'access' ); ?>
  <?php get_template_part( 'template-parts/section', 'publications' ); ?>
  <?php get_template_part( 'template-parts/section', 'book' ); ?>
</main>

<?php get_footer(); ?>
