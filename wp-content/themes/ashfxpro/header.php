<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script>(function(){var t=localStorage.getItem('ashfxpro_theme');document.documentElement.setAttribute('data-theme',t==='light'?'light':'dark');})();</script>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$img = get_template_directory_uri() . '/assets/images';
$ico = get_template_directory_uri() . '/assets/icons';

$t = function( $key, $fb ) { return function_exists( 'pll__' ) ? pll__( $fb ) : $fb; };
$nav_links = [
  [ 'num' => '01', 'label' => $t( 'nav_about',     'About us' ),     'url' => '/about' ],
  [ 'num' => '02', 'label' => $t( 'nav_track',     'Track Record' ), 'url' => '/track-record' ],
  [ 'num' => '03', 'label' => $t( 'nav_prices',    'Prices' ),       'url' => '/price' ],
  [ 'num' => '04', 'label' => $t( 'nav_education', 'Education' ),    'url' => '/education' ],
  [ 'num' => '05', 'label' => $t( 'nav_contact',   'Contact' ),      'url' => '/contact' ],
];
?>

<div class="nav-overlay" id="nav-overlay" aria-hidden="true"></div>

<header class="site-header">
  <nav class="nav-pill" role="navigation" aria-label="<?php esc_attr_e( 'Main navigation', 'ashfxpro' ); ?>">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo" aria-label="<?php bloginfo( 'name' ); ?>">
      <img src="<?php echo esc_url( "$img/nav-logo.svg" ); ?>" alt="ASHFXPRO" width="111" height="14">
    </a>

    <button
      class="nav-menu-btn"
      id="nav-menu-btn"
      aria-label="<?php esc_attr_e( 'Open menu', 'ashfxpro' ); ?>"
      aria-expanded="false"
      aria-controls="site-nav"
    >
      <span class="nav-menu-btn__bar"></span>
      <span class="nav-menu-btn__bar"></span>
      <span class="nav-menu-btn__bar"></span>
    </button>
  </nav>

  <!-- Dropdown menu -->
  <div class="site-nav" id="site-nav" aria-hidden="true" role="dialog" aria-label="<?php esc_attr_e( 'Site menu', 'ashfxpro' ); ?>">
    <div class="site-nav__inner">

      <!-- Left: nav links + Right: PWA card -->
      <div class="site-nav__body">

        <!-- Nav links -->
        <nav class="site-nav__links" aria-label="<?php esc_attr_e( 'Pages', 'ashfxpro' ); ?>">
          <?php foreach ( $nav_links as $link ) : ?>
            <a href="<?php echo esc_url( home_url( $link['url'] ) ); ?>" class="site-nav__link-item">
              <span class="site-nav__link-num"><?php echo esc_html( $link['num'] ); ?></span>
              <span class="site-nav__link-label"><?php echo esc_html( $link['label'] ); ?></span>
            </a>
          <?php endforeach; ?>
        </nav>

        <!-- PWA card -->
        <div class="site-nav__pwa">
          <div class="site-nav__pwa-phone" aria-hidden="true">
            <img src="<?php echo esc_url( "$img/menu-phone.png" ); ?>" alt="" loading="lazy">
          </div>
          <div class="site-nav__pwa-logo">
            <img src="<?php echo esc_url( "$img/wpa-logo.svg" ); ?>" alt="ASHFXPRO" loading="lazy">
          </div>
          <a href="#" class="btn-primary site-nav__pwa-btn">Перейти в веб-приложение</a>
          <p class="site-nav__pwa-info">
            <strong>PWA (Progressive Web App)</strong><br>
            Добавьте приложение на главный экран, чтобы получать сигналы мгновенно и без ограничений
          </p>
        </div>

      </div><!-- /.site-nav__body -->

      <!-- Bottom bar: language switcher + theme toggle -->
      <div class="site-nav__bottom">

        <?php
        // Show only the OTHER language — built manually so it works
        // even when the current page has no translated version.
        $labels = [ 'en' => 'En', 'ru' => 'Ru' ];

        if ( function_exists( 'pll_current_language' ) && function_exists( 'PLL' ) ) :
            $current = pll_current_language();
            $all_langs = PLL()->model->get_languages_list();
        ?>
          <nav class="lang-switcher" role="navigation" aria-label="<?php esc_attr_e( 'Language switcher', 'ashfxpro' ); ?>">
            <?php foreach ( $all_langs as $lang ) : ?>
              <?php if ( $lang->slug === $current ) continue; ?>
              <a href="<?php echo esc_url( pll_home_url( $lang->slug ) ); ?>"
                 class="site-nav__lang-btn"
                 hreflang="<?php echo esc_attr( $lang->slug ); ?>"
              ><?php echo esc_html( $labels[ $lang->slug ] ?? strtoupper( $lang->slug ) ); ?></a>
            <?php endforeach; ?>
          </nav>
        <?php else : ?>
          <nav class="lang-switcher" role="navigation" aria-label="<?php esc_attr_e( 'Language switcher', 'ashfxpro' ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-nav__lang-btn" hreflang="en">En</a>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-nav__lang-btn" hreflang="ru">Ru</a>
          </nav>
        <?php endif; ?>

        <button
          class="site-nav__theme-btn"
          aria-label="<?php esc_attr_e( 'Toggle theme', 'ashfxpro' ); ?>"
          data-icon-dark="<?php echo esc_url( "$ico/sun-icon.svg" ); ?>"
          data-icon-light="<?php echo esc_url( "$ico/moon-icon.svg" ); ?>"
        >
          <img src="<?php echo esc_url( "$ico/sun-icon.svg" ); ?>" alt="" width="20" height="20" aria-hidden="true">
        </button>
      </div>

    </div><!-- /.site-nav__inner -->
  </div><!-- /.site-nav -->

</header>
