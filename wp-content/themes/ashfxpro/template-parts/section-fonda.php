<?php
$desc = function_exists( 'pll__' )
    ? pll__( 'Прекрати терять деньги на удачу. Аналитика с проверяемой историей от трейдера с 10-летним опытом.' )
    : 'Прекрати терять деньги на удачу. Аналитика с проверяемой историей от трейдера с 10-летним опытом.';
?>
<section class="section-fonda" aria-label="<?php esc_attr_e( 'Markets we cover', 'ashfxpro' ); ?>">
  <div class="fonda-container">

    <p class="fonda-word fonda-word--white"
       data-direction="left" data-speed="0.4" data-distance="500">ФОНДА</p>

    <div class="fonda-row">
      <p class="fonda-desc"><?php echo esc_html( $desc ); ?></p>
      <p class="fonda-word fonda-word--blue"
         data-direction="right" data-speed="0.8" data-distance="500">КРИПТА</p>
    </div>

    <p class="fonda-word fonda-word--white"
       data-direction="left" data-speed="0.5" data-distance="500">ВАЛЮТА</p>

  </div>
</section>
