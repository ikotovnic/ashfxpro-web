<?php
$img = get_template_directory_uri() . '/assets/images';
$ico = get_template_directory_uri() . '/assets/icons';

function ashfxpro_t( $key, $fallback ) {
    return function_exists( 'pll__' ) ? pll__( $fallback ) : $fallback;
}

$features = [
  [ 'icon' => "$ico/icon-duplicate.svg", 'text' => ashfxpro_t( 'access_feat1', 'Полное дублирование всего контента' ) ],
  [ 'icon' => "$ico/icon-vpn.svg",       'text' => ashfxpro_t( 'access_feat2', 'Доступ без VPN и блокировок' ) ],
  [ 'icon' => "$ico/icon-sync.svg",      'text' => ashfxpro_t( 'access_feat3', 'Синхронизация в реальном времени' ) ],
];
?>
<section class="section-access" aria-label="Direct access">

  <div class="access-main">
    <div class="access-heading-row">
      <h2 class="access-heading"><?php echo nl2br( esc_html( ashfxpro_t( 'access_heading', "Прямой доступ\nбез Telegram\nи VPN" ) ) ); ?></h2>
      <p class="access-description"><?php echo esc_html( ashfxpro_t( 'access_desc', 'Чтобы вы не зависели от стабильности telegram, мы создали автономное веб-приложение.' ) ); ?></p>
    </div>
    <div class="access-features">
      <?php foreach ( $features as $f ) : ?>
        <div class="access-feature">
          <div class="access-feature__icon">
            <img src="<?php echo esc_url( $f['icon'] ); ?>" alt="" aria-hidden="true">
          </div>
          <p class="access-feature__text"><?php echo esc_html( $f['text'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="pwa-card">
    <div class="pwa-card-phone" aria-hidden="true">
      <img src="<?php echo esc_url( "$img/phone-mockup.png" ); ?>" alt="" loading="lazy">
    </div>
    <div class="pwa-card-logo">
      <img src="<?php echo esc_url( "$img/nav-logo.svg" ); ?>" alt="ASHFXPRO" height="40">
    </div>
    <a href="#" class="btn-primary"><?php echo esc_html( ashfxpro_t( 'pwa_btn', 'Перейти в веб-приложение' ) ); ?></a>
    <div class="pwa-card-info">
      <p class="pwa-card-info__title"><?php echo esc_html( ashfxpro_t( 'pwa_title', 'PWA (Progressive Web App)' ) ); ?></p>
      <p class="pwa-card-info__text"><?php echo esc_html( ashfxpro_t( 'pwa_desc', 'Добавьте приложение на главный экран, чтобы получать сигналы мгновенно и без ограничений' ) ); ?></p>
    </div>
  </div>

</section>
