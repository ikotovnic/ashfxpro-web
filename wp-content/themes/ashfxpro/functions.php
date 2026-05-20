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
        '1.4.0'
    );
    wp_enqueue_script(
        'ashfxpro-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        '1.4.0',
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

// ── Donut chart: default data ─────────────────────────────────────────────────
function ashfxpro_donut_defaults() {
    return [
        'total_count'  => 1365,
        'period_label' => 'May',
        'segments'     => [
            ['label' => 'Russia', 'value' => 40, 'color' => '#00a1ff'],
            ['label' => 'World',  'value' => 30, 'color' => '#0cd241'],
            ['label' => 'Crypto', 'value' => 20, 'color' => '#c1d20c'],
            ['label' => 'FX',     'value' => 5,  'color' => '#d23d0c'],
            ['label' => 'Com',    'value' => 5,  'color' => '#ff9900'],
        ],
    ];
}

// ── Admin settings page (Settings › AshFXPro Stats) ───────────────────────────
add_action( 'admin_menu', function () {
    add_options_page( 'AshFXPro Stats', 'AshFXPro Stats', 'manage_options', 'ashfxpro-stats', 'ashfxpro_stats_page' );
} );

function ashfxpro_stats_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( isset( $_POST['_wpnonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'ashfxpro_stats_save' ) ) {

        $saved = ashfxpro_donut_defaults();
        $saved['total_count']  = absint( $_POST['total_count'] ?? $saved['total_count'] );
        $saved['period_label'] = sanitize_text_field( wp_unslash( $_POST['period_label'] ?? $saved['period_label'] ) );

        foreach ( $saved['segments'] as $i => &$seg ) {
            $key = 'seg_' . $i;
            if ( isset( $_POST[ $key ] ) ) {
                $seg['value'] = max( 0, absint( $_POST[ $key ] ) );
            }
        }
        unset( $seg );

        update_option( 'ashfxpro_donut_chart', $saved );
        echo '<div class="notice notice-success is-dismissible"><p>Saved.</p></div>';
    }

    $chart = get_option( 'ashfxpro_donut_chart', ashfxpro_donut_defaults() );
    ?>
    <div class="wrap">
    <h1>AshFXPro — Stats</h1>
    <form method="post">
        <?php wp_nonce_field( 'ashfxpro_stats_save' ); ?>
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="total_count">Publications count</label></th>
                <td><input id="total_count" name="total_count" type="number" class="regular-text"
                           value="<?php echo esc_attr( $chart['total_count'] ); ?>"></td>
            </tr>
            <tr>
                <th scope="row"><label for="period_label">Period label</label></th>
                <td><input id="period_label" name="period_label" type="text" class="regular-text"
                           value="<?php echo esc_attr( $chart['period_label'] ); ?>"></td>
            </tr>
            <?php foreach ( $chart['segments'] as $i => $seg ) : ?>
            <tr>
                <th scope="row"><?php echo esc_html( $seg['label'] ); ?> (%)</th>
                <td><input name="seg_<?php echo $i; ?>" type="number" class="small-text"
                           value="<?php echo esc_attr( $seg['value'] ); ?>" min="0" max="100"></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php submit_button( 'Save changes' ); ?>
    </form>
    </div>
    <?php
}

// ── REST API endpoint for external service ────────────────────────────────────
// POST /wp-json/ashfxpro/v1/stats/donut
// Auth: WordPress Application Password (Users › Profile › Application Passwords)
// Body: { "total_count": 1420, "period_label": "June",
//         "segments": [{"value":42},{"value":28},{"value":20},{"value":5},{"value":5}] }
add_action( 'rest_api_init', function () {
    register_rest_route( 'ashfxpro/v1', '/stats/donut', [
        'methods'             => WP_REST_Server::CREATABLE,
        'callback'            => 'ashfxpro_rest_update_donut',
        'permission_callback' => function () { return current_user_can( 'manage_options' ); },
    ] );
} );

function ashfxpro_rest_update_donut( WP_REST_Request $req ) {
    $body = $req->get_json_params();
    if ( empty( $body ) ) {
        return new WP_Error( 'invalid_data', 'JSON body required.', [ 'status' => 400 ] );
    }
    $chart = get_option( 'ashfxpro_donut_chart', ashfxpro_donut_defaults() );
    if ( isset( $body['total_count'] ) )  { $chart['total_count']  = absint( $body['total_count'] ); }
    if ( isset( $body['period_label'] ) ) { $chart['period_label'] = sanitize_text_field( $body['period_label'] ); }
    if ( isset( $body['segments'] ) && is_array( $body['segments'] ) ) {
        foreach ( $chart['segments'] as $i => &$seg ) {
            if ( isset( $body['segments'][ $i ]['value'] ) ) {
                $seg['value'] = max( 0, absint( $body['segments'][ $i ]['value'] ) );
            }
        }
        unset( $seg );
    }
    update_option( 'ashfxpro_donut_chart', $chart );
    return new WP_REST_Response( [ 'ok' => true, 'data' => $chart ], 200 );
}
