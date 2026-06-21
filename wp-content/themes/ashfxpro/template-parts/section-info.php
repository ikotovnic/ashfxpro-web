<?php
$info     = get_option( 'ashfxpro_info', ashfxpro_info_defaults() );
$subtitle = $info['subtitle'] ?? '';
$stats    = $info['stats']    ?? [];
?>
<section class="section-info" aria-label="<?php esc_attr_e( 'About', 'ashfxpro' ); ?>">
  <div class="info-container">

    <p class="info-heading">
      <span class="info-heading__accent"><?php esc_html_e( '10 лет', 'ashfxpro' ); ?></span>
      <?php echo ' ' . esc_html__( 'превращаю рыночный шум в четкий анализ', 'ashfxpro' ); ?>
    </p>

    <div class="info-right">
      <p class="info-subtitle"><?php echo esc_html( $subtitle ); ?></p>

      <?php if ( ! empty( $stats ) ) : ?>
      <div class="info-stats">
        <?php foreach ( $stats as $stat ) : ?>
        <div class="info-stat">
          <span class="info-stat__value"><?php echo esc_html( $stat['value'] ); ?></span>
          <span class="info-stat__label"><?php echo esc_html( $stat['label'] ); ?></span>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>

  </div>
</section>
