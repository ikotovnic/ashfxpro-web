<?php
$img = get_template_directory_uri() . '/assets/images';
$headline = function_exists( 'pll__' ) ? pll__( 'Look deeper. Trade smarter.' ) : 'Look deeper. Trade smarter.';
?>
<section class="section-hero">
  <h1 class="hero-title"><?php echo esc_html( $headline ); ?></h1>
</section>
