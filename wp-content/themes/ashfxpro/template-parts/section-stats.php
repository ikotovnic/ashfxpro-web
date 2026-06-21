<?php
$img  = get_template_directory_uri() . '/assets/images';
$ico  = get_template_directory_uri() . '/assets/icons';

$chart = get_option( 'ashfxpro_donut_chart', ashfxpro_donut_defaults() );

// Bar chart: sort desc, top 5, compute pixel heights
$bars_raw = $chart['bars'] ?? [];
usort( $bars_raw, fn( $a, $b ) => (int) $b['value'] <=> (int) $a['value'] );
$bars    = array_slice( $bars_raw, 0, 5 );
$max_val = ! empty( $bars ) ? max( 1, (int) $bars[0]['value'] ) : 1;
$max_h   = 189;
?>
<section class="section-stats" aria-label="<?php esc_attr_e( 'Trading statistics', 'ashfxpro' ); ?>">

  <!-- Stat 1: Total Return (green) -->
  <div class="stat-card stat-card--green">
    <div class="stat-header">
      <span class="stat-label"><?php echo esc_html( ashfxpro_t( 'Last 500 signals' ) ); ?></span>
      <div class="dropdown-pill">
        <?php echo esc_html( ashfxpro_t( 'All tickets' ) ); ?>
        <img class="arrow" src="<?php echo esc_url( "$ico/arrow-down.svg" ); ?>" alt="" aria-hidden="true">
      </div>
    </div>

    <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;width:100%;">
      <div class="stat-main">
        <div class="stat-main__row">
          <span class="stat-num"><?php echo esc_html( $chart['stat_return'] ?? '+112R' ); ?></span>
          <div class="stat-sub-metrics">
            <span><?php echo esc_html( $chart['stat_return_pct'] ?? '+45.8%' ); ?></span>
            <span><?php echo esc_html( $chart['stat_return_pips'] ?? '+28K pips' ); ?></span>
          </div>
        </div>
        <span class="stat-main__label"><?php echo esc_html( ashfxpro_t( 'Total Return' ) ); ?></span>
      </div>
      <a href="#track-record" class="btn-verify">
        <img src="<?php echo esc_url( "$ico/telegram.svg" ); ?>" alt="" aria-hidden="true">
        <?php echo esc_html( ashfxpro_t( 'Verify Track Record' ) ); ?>
      </a>
    </div>

    <div class="stat-bottom">
      <div class="stat-metric">
        <span class="stat-metric__value"><?php echo esc_html( $chart['stat_profit'] ?? '+3.6R' ); ?></span>
        <span class="stat-metric__label"><?php echo esc_html( ashfxpro_t( 'Total Profit' ) ); ?></span>
      </div>
      <div class="stat-metric">
        <span class="stat-metric__value"><?php echo esc_html( $chart['stat_drawdown'] ?? '8.5%' ); ?></span>
        <span class="stat-metric__label"><?php echo nl2br( esc_html( ashfxpro_t( 'Max Drawdown' ) ) ); ?></span>
      </div>
      <div class="stat-metric">
        <span class="stat-metric__value"><?php echo esc_html( $chart['stat_rr'] ?? '1.92' ); ?></span>
        <span class="stat-metric__label"><?php echo esc_html( ashfxpro_t( 'Average R/R' ) ); ?></span>
      </div>
    </div>
  </div>

  <!-- Stat 2: Activity (donut chart) -->
  <div class="stat-card stat-card--chart">
    <div class="stat-header">
      <span class="stat-label" style="font-weight:600;"><?php echo esc_html( ashfxpro_t( 'Activity' ) ); ?></span>
      <div class="dropdown-pill">
        <?php echo esc_html( $chart['period_label'] ); ?>
        <img class="arrow" src="<?php echo esc_url( "$ico/arrow-down.svg" ); ?>" alt="" aria-hidden="true">
      </div>
    </div>

    <div class="stat-chart-center" aria-hidden="true">
      <svg class="donut-chart" id="stat-donut-svg"
           viewBox="0 0 268 268" width="268" height="268"
           fill="none" aria-hidden="true"></svg>
    </div>

    <div class="stat-main">
      <span class="stat-chart-num"><?php echo esc_html( $chart['total_count'] ); ?></span>
      <span class="stat-main__label"><?php echo esc_html( ashfxpro_t( 'Publications in May' ) ); ?></span>
    </div>

    <div class="stat-legend">
      <?php foreach ( $chart['segments'] as $seg ) : ?>
        <div class="legend-item">
          <span class="legend-dot" style="background:<?php echo esc_attr( $seg['color'] ); ?>;"></span>
          <?php echo esc_html( $seg['label'] ); ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Stat 3: Top requests (bar chart) -->
  <div class="stat-card stat-card--bars">
    <div class="bars-title-row">
      <span><?php echo esc_html( ashfxpro_t( 'Top requests' ) ); ?></span>
      <span><?php echo esc_html( $chart['period_label'] ); ?></span>
    </div>

    <div class="bars-container" aria-label="Top requested assets">
      <?php foreach ( $bars as $bar ) :
        $h_px  = (int) round( $bar['value'] / $max_val * $max_h );
        $color = esc_attr( $bar['color'] );
        $rgba  = esc_attr( ashfxpro_hex_rgba( $bar['color'], 0.05 ) );
        $name  = esc_html( $bar['ticker'] );
        // Long tickers split at "/" for two-line display
        $name_html = strpos( $bar['ticker'], '/' ) !== false
            ? str_replace( '/', '/<br>', esc_html( $bar['ticker'] ) )
            : esc_html( $bar['ticker'] );
      ?>
      <div class="bar-item" style="height:28px" data-bar-h="<?php echo $h_px; ?>">
        <div class="bar-fill">
          <div class="bar-line" style="background:<?php echo $color; ?>;"></div>
          <div class="bar-gradient" style="background:linear-gradient(to bottom,<?php echo $rgba; ?>,transparent);"></div>
        </div>
        <span class="bar-name"><?php echo $name_html; ?></span>
      </div>
      <?php endforeach; ?>
    </div>

    <p class="stat-analytics-label"><?php echo esc_html( ashfxpro_t( 'Personal analytics' ) ); ?></p>
  </div>

</section>
<script>window.ashfxproDonutData=<?php echo wp_json_encode( $chart ); ?>;</script>
