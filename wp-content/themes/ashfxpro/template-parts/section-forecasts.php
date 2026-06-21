<?php
$forecasts  = get_option( 'ashfxpro_forecasts', ashfxpro_forecasts_defaults() );
$tops       = [ '5dvh', '10dvh', '15dvh', '20dvh', '25dvh' ];
$disclaimer = 'Не является инвестиционной рекомендацией. Торговля сопряжена с риском потери капитала.';
?>
<section class="section-forecasts" aria-label="<?php esc_attr_e( 'Forecasts', 'ashfxpro' ); ?>">
  <div class="forecasts-container">

    <header class="forecasts-header">
      <h2 class="forecasts-title"><?php esc_html_e( 'Не верите словам? Посмотрите на факты', 'ashfxpro' ); ?></h2>
    </header>

    <div class="cards-stack">
      <?php foreach ( array_slice( $forecasts, 0, 5 ) as $i => $card ) : ?>
      <a href="<?php echo esc_url( $card['channel_url'] ); ?>"
         target="_blank" rel="noopener noreferrer"
         class="card-item scale"
         style="top:<?php echo esc_attr( $tops[ $i ] ); ?>">

        <div class="card-image">
          <?php if ( ! empty( $card['image_url'] ) ) : ?>
          <img src="<?php echo esc_url( $card['image_url'] ); ?>" alt="" loading="lazy">
          <?php endif; ?>
        </div>

        <div class="card-content">
          <div class="card-top">
            <span class="card-ticker"><?php echo esc_html( $card['ticker'] ); ?></span>
            <p class="card-title"><?php echo esc_html( $card['title'] ); ?></p>
            <p class="card-disclaimer"><?php echo esc_html( $disclaimer ); ?></p>
          </div>
          <div class="card-footer">
            <span class="card-date"><?php echo esc_html( $card['date'] ); ?></span>
            <span class="card-channel">
              <svg width="18" height="15" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M7.85498 10.7649L7.52248 15.3149C8.00998 15.3149 8.22498 15.1024 8.48248 14.8474L10.7925 12.6399L15.5775 16.1449C16.4475 16.6274 17.0575 16.3724 17.285 15.3299L19.9475 2.82742C20.215 1.54242 19.48 1.04742 18.63 1.36742L0.927477 8.23742C-0.319523 8.71992 -0.299523 9.40992 0.712477 9.72992L5.22498 11.1274L16.1475 4.26992C16.655 3.93992 17.12 4.11992 16.7375 4.44992L7.85498 10.7649Z" fill="currentColor"/>
              </svg>
              <?php echo esc_html( $card['channel_name'] ); ?>
            </span>
          </div>
        </div>

      </a>
      <?php endforeach; ?>
    </div>

  </div>
</section>
