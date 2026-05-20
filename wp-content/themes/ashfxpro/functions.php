<?php

function ashfxpro_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption', 'script', 'style' ] );

    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'ashfxpro' ),
    ] );
}
add_action( 'after_setup_theme', 'ashfxpro_setup' );

function ashfxpro_dequeue_wp_defaults() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'classic-theme-styles' );
    wp_dequeue_style( 'global-styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'wp_enqueue_scripts', 'ashfxpro_dequeue_wp_defaults', 20 );

function ashfxpro_enqueue_assets() {
    wp_enqueue_style(
        'google-fonts-montserrat',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400;600;700&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'ashfxpro-main',
        get_template_directory_uri() . '/assets/css/main.css',
        [ 'google-fonts-montserrat' ],
        '1.3.0'
    );
    wp_enqueue_script(
        'ashfxpro-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        '1.3.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'ashfxpro_enqueue_assets' );

/**
 * Register translatable strings for Polylang.
 * Edit translations at: Languages → Translations in WP admin.
 */
function ashfxpro_register_strings() {
    if ( ! function_exists( 'pll_register_string' ) ) {
        return;
    }
    $group = 'ashfxpro';

    $strings = [
        // Hero
        'hero_headline'     => 'Look deeper. Trade smarter.',
        // Stats
        'stat_last_signals' => 'Last 500 signals',
        'stat_all_tickets'  => 'All tickets',
        'stat_total_return' => 'Total Return',
        'stat_verify'       => 'Verify Track Record',
        'stat_total_profit' => 'Total Profit',
        'stat_drawdown'     => 'Max Drawdown',
        'stat_rr'           => 'Average R/R',
        'stat_activity'     => 'Activity',
        'stat_month'        => 'Month',
        'stat_publications' => 'Publications in May',
        'stat_top_req'      => 'Top requests',
        'stat_analytics'    => 'Personal analytics',
        // Publications
        'pub_title'         => 'Recent publications',
        'pub_post_title'    => 'Fact + new forecast. Frame 1H/4H. Not an investment recommendation.',
        // Access
        'access_heading'    => "Прямой доступ\nбез Telegram\nи VPN",
        'access_desc'       => 'Чтобы вы не зависели от стабильности telegram, мы создали автономное веб-приложение. Это гарантирует получение сигналов и доступ к постам в любой ситуации, даже при технических сбоях',
        'access_feat1'      => 'Полное дублирование всего контента',
        'access_feat2'      => 'Доступ без VPN и блокировок',
        'access_feat3'      => 'Синхронизация в реальном времени',
        'pwa_btn'           => 'Перейти в веб-приложение',
        'pwa_title'         => 'PWA (Progressive Web App)',
        'pwa_desc'          => 'Добавьте приложение на главный экран, чтобы получать сигналы мгновенно и без ограничений',
        // Book
        'book_label'        => 'Готовится к выходу',
        'book_title'        => 'Книга «Язык Графика»',
        'book_desc'         => 'Весь мой опыт в текстовом издании. Для тех, кто ценит фундаментальные знания',
        // Nav
        'nav_about'         => 'About us',
        'nav_track'         => 'Track Record',
        'nav_prices'        => 'Prices',
        'nav_education'     => 'Education',
        'nav_contact'       => 'Contact',
        // Footer
        'footer_disclaimer' => 'Используя сайт, вы соглашаетесь с обработкой технических данных (cookies, IP) в целях аналитики. Информация на сайте не является инвестиционной рекомендацией. Торговля сопряжена с риском потери капитала.',
    ];

    foreach ( $strings as $name => $default ) {
        pll_register_string( $name, $default, $group );
    }
}
add_action( 'init', 'ashfxpro_register_strings' );
