<?php
$img = get_template_directory_uri() . '/assets/images';
$headline = function_exists( 'pll__' ) ? pll__( 'Look deeper. Trade smarter.' ) : 'Look deeper. Trade smarter.';
?>
<section class="section-hero">
  <div class="hero-bg" aria-hidden="true">
    <picture>
      <source srcset="<?php echo esc_url( "$img/hero-bg1.webp" ); ?>" type="image/webp">
      <img src="<?php echo esc_url( "$img/hero-bg1.jpg" ); ?>" alt="" loading="eager" fetchpriority="high">
    </picture>
    <picture>
      <source srcset="<?php echo esc_url( "$img/hero-bg2.webp" ); ?>" type="image/webp">
      <img src="<?php echo esc_url( "$img/hero-bg2.jpg" ); ?>" alt="" loading="eager">
    </picture>
    <div class="hero-bg-gradient"></div>
  </div>
  <h1 class="hero-title"><?php echo esc_html( $headline ); ?></h1>
</section>
