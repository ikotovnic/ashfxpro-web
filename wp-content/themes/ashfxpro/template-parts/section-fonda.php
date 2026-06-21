<?php
$lang  = function_exists( 'pll_current_language' ) ? pll_current_language() : 'en';
$fonda = get_option( 'ashfxpro_fonda_' . $lang, ashfxpro_fonda_defaults() );
?>
<section class="section-fonda" aria-label="<?php esc_attr_e( 'Markets we cover', 'ashfxpro' ); ?>">
  <div class="fonda-container">

    <p class="fonda-word fonda-word--white reveal"
       data-direction="left" data-speed="0.4" data-distance="500"><?php echo esc_html( $fonda['word1'] ?? 'ФОНДА' ); ?></p>

    <div class="fonda-row">
      <p class="fonda-desc"><?php echo esc_html( $fonda['desc'] ?? '' ); ?></p>
      <p class="fonda-word fonda-word--blue reveal"
         data-direction="right" data-speed="0.8" data-distance="500"><?php echo esc_html( $fonda['word2'] ?? 'КРИПТА' ); ?></p>
    </div>

    <p class="fonda-word fonda-word--white reveal"
       data-direction="left" data-speed="0.5" data-distance="500"><?php echo esc_html( $fonda['word3'] ?? 'ВАЛЮТА' ); ?></p>

  </div>
</section>
