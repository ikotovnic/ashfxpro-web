<?php
$img  = get_template_directory_uri() . '/assets/images';
$ico  = get_template_directory_uri() . '/assets/icons';

$chart = get_option( 'ashfxpro_donut_chart', [
    'total_count'  => 1365,
    'period_label' => 'May',
    'segments'     => [
        ['label' => 'Russia', 'value' => 40, 'color' => '#00a1ff'],
        ['label' => 'World',  'value' => 30, 'color' => '#0cd241'],
        ['label' => 'Crypto', 'value' => 20, 'color' => '#c1d20c'],
        ['label' => 'FX',     'value' => 5,  'color' => '#d23d0c'],
        ['label' => 'Com',    'value' => 5,  'color' => '#ff9900'],
    ],
] );
?>
<section class="section-stats" aria-label="<?php esc_attr_e( 'Trading statistics', 'ashfxpro' ); ?>">

  <!-- Stat 1: Total Return (green) -->
  <div class="stat-card stat-card--green">
    <div class="stat-header">
      <span class="stat-label">Last 500 signals</span>
      <div class="dropdown-pill">
        All tickets
        <img class="arrow" src="<?php echo esc_url( "$ico/arrow-down.svg" ); ?>" alt="" aria-hidden="true">
      </div>
    </div>

    <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;width:100%;">
      <div class="stat-main">
        <div class="stat-main__row">
          <span class="stat-num">+112R</span>
          <div class="stat-sub-metrics">
            <span>+45.8%</span>
            <span>+28K pips</span>
          </div>
        </div>
        <span class="stat-main__label">Total Return</span>
      </div>
      <a href="#track-record" class="btn-verify">
        <img src="<?php echo esc_url( "$ico/telegram.svg" ); ?>" alt="" aria-hidden="true">
        Verify Track Record
      </a>
    </div>

    <div class="stat-bottom">
      <div class="stat-metric">
        <span class="stat-metric__value">+3.6R</span>
        <span class="stat-metric__label">Total Profit</span>
      </div>
      <div class="stat-metric">
        <span class="stat-metric__value">8.5%</span>
        <span class="stat-metric__label">Max<br>Drawdown</span>
      </div>
      <div class="stat-metric">
        <span class="stat-metric__value">1.92</span>
        <span class="stat-metric__label">Average R/R</span>
      </div>
    </div>
  </div>

  <!-- Stat 2: Activity (donut chart) -->
  <div class="stat-card stat-card--chart">
    <div class="stat-header">
      <span class="stat-label" style="font-weight:600;">Activity</span>
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
      <span class="stat-main__label">Publications in <?php echo esc_html( $chart['period_label'] ); ?></span>
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
      <span>Top requests</span>
      <span>May</span>
    </div>

    <div class="bars-container" aria-label="Top requested assets">
      <div class="bar-item" style="height:189px;">
        <div class="bar-fill">
          <div class="bar-line" style="background:#8800ff;"></div>
          <div class="bar-gradient" style="background:linear-gradient(to bottom, rgba(136,0,255,0.05), rgba(136,0,255,0));"></div>
        </div>
        <span class="bar-name">IRUS</span>
      </div>
      <div class="bar-item" style="height:151px;">
        <div class="bar-fill">
          <div class="bar-line" style="background:#0062ff;"></div>
          <div class="bar-gradient" style="background:linear-gradient(to bottom, rgba(0,98,255,0.05), rgba(0,59,153,0));"></div>
        </div>
        <span class="bar-name">BTC/<br>USDT</span>
      </div>
      <div class="bar-item" style="height:171px;">
        <div class="bar-fill">
          <div class="bar-line" style="background:#d23e0c;"></div>
          <div class="bar-gradient" style="background:linear-gradient(to bottom, rgba(210,62,12,0.05), rgba(108,32,6,0));"></div>
        </div>
        <span class="bar-name">ETH/<br>USDT</span>
      </div>
      <div class="bar-item" style="height:68px;">
        <div class="bar-fill">
          <div class="bar-line" style="background:#c1d20c;"></div>
          <div class="bar-gradient" style="background:rgba(193,210,12,0.05);"></div>
        </div>
        <span class="bar-name">AFLT</span>
      </div>
      <div class="bar-item" style="height:90px;">
        <div class="bar-fill">
          <div class="bar-line" style="background:#0cd241;"></div>
          <div class="bar-gradient" style="background:linear-gradient(to right, rgba(12,210,65,0.05), rgba(6,108,33,0));"></div>
        </div>
        <span class="bar-name">CCH6</span>
      </div>
    </div>

    <p class="stat-analytics-label">Personal analytics</p>
  </div>

</section>
<script>window.ashfxproDonutData=<?php echo wp_json_encode( $chart ); ?>;</script>
